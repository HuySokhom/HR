app.controller(
	'plan_ctrl', [
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
			vm.advertisingLocations = [];
		};
		
		function init(){
			Restful.get('api/Plan').success(function(data){
				vm.collection = data;
				console.log(vm.collection);
				vm.totalItems = data.count;
			});
		};
		init();

		vm.edit = function(params){
			$('#plan').modal('show');
			if(vm.picFile){
				vm.picFile = null;
			}
			vm.data = angular.copy(params);
			vm.advertisingLocations = params.advertising_detail;
			console.log(params);		
		};

		vm.save = function(){	
			console.log(vm.data);
			vm.isDisabled = true;
			if( vm.data.id ){
				Restful.put('api/Plan/' + vm.data.id, vm.data).success(function(data){
					init();
					console.log(data);
					$('#plan').modal('hide');
					vm.isDisabled = false;
				});
			}else{
				Restful.post('api/Plan/', vm.data).success(function(data){
					console.log(data);
					init();
					$('#plan').modal('hide');
					vm.isDisabled = false;
				});
			}
		};

		vm.remove = function($index, params){
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("Are you sure you want to delete this plan?", function (ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
					Restful.delete( 'api/Plan/' + params.id, params ).success(function(data){
						vm.disabled = true;
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						init();
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
			Restful.patch('api/Plan/' + params.id, data).success(function(data){
				console.log(data);
				init();
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
						vm.data.display_type = response.data.image;
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