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
			Restful.get("api/Industry").success(function(data){
				vm.industriesList = data.elements;
			});
			Restful.get("api/Country").success(function(data){
				vm.countries = data.elements;
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
		vm.uploadCV = function(file) {
			if (file) {
				file.upload = Upload.upload({
					url: 'api/UploadCV',
					data: {file: file},
				});
				file.upload.then(function (response) {
					$timeout(function () {
						console.log(response);
						file.result = response.data;
						vm.account.upload_cv = response.data.upload_cv;
					});
				}, function (response) {
					if (response.status > 0)
						vm.errorMsgCV = response.status + ': ' + response.data;
				}, function (evt) {
					// Math.min is to fix I	E which reports 200% sometimes
					file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
				});
			}
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

		// start crop functionality
		vm.showSnapPhoto = function(){
			vm.hide = true;
			$('#crop-image-popup').modal('show');
		};
		vm.done = function(){
			$scope.resultImage = $scope.croppedDataUrl;
			vm.loading = true;
			Restful.post( 'api/ImageUploadBase64' , {fileName: $scope.resultImage}).success(function (data) {
				console.log(data);
				$('#crop-image-popup').modal('hide');
				vm.account.photo =  data.fileName;
				vm.account.photo_thumbnail =  data.fileName;
				$scope.imagePath = data.fileName;
			}).finally(function(){
				vm.loading = false;
			});
		};
		
	}
]);