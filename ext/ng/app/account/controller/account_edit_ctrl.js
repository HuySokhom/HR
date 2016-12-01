app.controller(
	'account_edit_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, '$timeout'
	, 'alertify'
	, function ($scope, Restful, Services, $location, Upload, $timeout, $alertify){
		var vm = this;
		var url = 'api/Session/Customer/';
		vm.service = new Services();
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
				vm.account = data.elements[0];
				console.log(data);
			});
			Restful.get("api/Location").success(function(data){
				vm.locations = data.elements;
			});
		};
		vm.init();

		// update functionality
		vm.save = function(){
			vm.disabled = false;
			Restful.put('api/Session/Customer/', vm.account).success(function (data) {
				console.log(data);
				vm.disabled = true;
				if(data == 1){
					vm.service.alertMessage('<strong>Complete: </strong> Update Success.');
					$location.path('account');
				}else{
					vm.service.alertMessageWarning('<strong>Warning: </strong> Email Existing. Please use other email..');
				}
			});
		};

		//functionality upload
		vm.uploadPic = function(file) {
			if (file) {
				file.upload = Upload.upload({
					url: 'api/UploadImage',
					data: {file: file, username: vm.username},
				});
				file.upload.then(function (response) {
					$timeout(function () {
						console.log(response);
						file.result = response.data;
						vm.account.photo = response.data.image;
						vm.account.photo_thumbnail = response.data.image_thumbnail;
					});
				}, function (response) {
					if (response.status > 0)
						vm.errorMsg = response.status + ': ' + response.data;
				}, function (evt) {
					// Math.min is to fix I	E which reports 200% sometimes
					file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
				});
			}
		};
	}
]);