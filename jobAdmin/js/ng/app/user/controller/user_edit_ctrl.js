app.controller(
	'user_edit_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, '$timeout'
	, '$stateParams'
	, function ($scope, Restful, Services, $location, Upload, $timeout, $stateParams){
		var vm =this
		var url = 'api/Customer/';
		vm.service = new Services();
		// init tiny option
		$scope.tinymceOptions = {};
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
                vm.account = data.elements[0];
				console.log(vm.account);
			});
            Restful.get("api/Location").success(function(data){
                vm.locations = data.elements;
            });
		};
		var params = {id: $stateParams.id};
		vm.init(params);

		// update functionality
		vm.save = function(){
			vm.disabled = false;
			Restful.put('api/Customer/' + $stateParams.id, vm.account).success(function (data) {
				vm.disabled = true;console.log(data);
				if(data == 1){
					vm.service.alertMessage('<b>Complete:</b> Update Success.');
					$location.path('user');
				}else{
					vm.service.alertMessage('<b>Warning:</b> Email Existing. Please use other email.');
				}
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