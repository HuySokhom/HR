app.controller(
	'advertising_banner_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, 'alertify'
	, '$timeout'
	, function ($scope, Restful, Services, $location, Upload, $alertify, $timeout){
		var vm = this;
		vm.service = new Services();
		vm.data = {};
		vm.add = function(){
			vm.data = {};
			if(vm.picFile){
				vm.picFile = null;
			}
		};
		vm.multipleDemo = {};
		vm.advertisingList = [
			{ name: 'Top Header', id: 2},
			{ name: 'Home Page',id: 3},
			{ name: 'Job List',id: 4},
			{ name: 'Job Description',  id: 5},
			{ name: 'CV List',id: 6},
			{ name: 'Company List', id:7},
			{ name: 'Cv or Company Description', id: 8},
		  ];
		
		vm.advertisingLocations = [vm.advertisingList[5], vm.advertisingList[4]];
		  
		function init(params){
			Restful.get(params).success(function(data){
				vm.banners = data;
				console.log(vm.banners);
				vm.totalItems = data.count;
			});
		};
		init('api/AdvertisingBanner');

		vm.edit = function(params){
			$('#banners').modal('show');
			if(vm.picFile){
				vm.picFile = null;
			}
			vm.data = angular.copy(params);
			console.log(params);		
		};

		vm.save = function(){			
			console.log(vm.data);
			var data = {
				master: vm.data,
				detail: vm.locationDetail
			};
			vm.isDisabled = true;
			if( vm.data.id ){
				Restful.put('api/AdvertisingBanner/' + vm.data.id, data).success(function(data){
					init('api/AdvertisingBanner/');
					console.log(data);
					$('#banners').modal('hide');
					vm.isDisabled = false;
				});
			}else{
				Restful.post('api/AdvertisingBanner/', data).success(function(data){
					console.log(data);
					init('api/AdvertisingBanner');
					$('#banners').modal('hide')
					vm.isDisabled = false;
				});
			}
		};

		vm.remove = function($index, params){
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("Are you sure you want to delete this image?", function (ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
					Restful.delete( 'api/AdvertisingBanner/' + params.id, params ).success(function(data){
						vm.disabled = true;console.log(data);
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						vm.banners.elements.splice($index, 1);
					});
				}, function(ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
				});
		};

		// update status 
		vm.updateStatus = function(params){
			params.status === 1 ? params.status = 0 : params.status = 1;
			var data = { status: params.status, name: "update_status"};
			Restful.patch('api/AdvertisingBanner/' + params.id, data).success(function(data){
				console.log(data);
				vm.service.alertMessage('<strong>Complete: </strong> Update Status Success.');
			});
		};

		//functionality upload
		vm.uploadPic = function(file) {
			if (file) {
				file.upload = Upload.upload({
					url: 'api/ImageUpload',
					data: {file: file, username: vm.username},
				});
				file.upload.then(function (response) {
					$timeout(function () {
						file.result = response.data;
						vm.data.image = response.data.image;
						console.log(response);
					});
				}, function (response) {
					if (response.status > 0)
						vm.errorMsg = response.status + ': ' + response.data;
				}, function (evt) {
					// Math.min is to fix IE which reports 200% sometimes
					file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
				});
			}
		};

	}
]);