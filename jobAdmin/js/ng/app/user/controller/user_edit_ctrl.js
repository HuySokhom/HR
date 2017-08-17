app.controller(
	'user_edit_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, '$timeout'
	, '$stateParams'
	, '$state'
	, function ($scope, Restful, Services, $location, Upload, $timeout, $stateParams, $state){
		var vm =this
		var url = 'api/Customer/';
		vm.service = new Services();
		vm.account = {
			user_type: 'agency'
		};
		// init tiny option
		vm.tinymceOptions = {
			 onChange: function(e) {
			// put logic here for keypress and cut/paste changes
			},
			inline: false,
			plugins : 'advlist autolink link image lists charmap print preview',
			skin: 'lightgray',
			theme : 'modern'
		};
		vm.init = function(params){
			if($state.current.name != 'user_create'){
				Restful.get(url, params).success(function(data){
					vm.account = data.elements[0];
					console.log(vm.account);
				});
			}
            Restful.get("api/Location").success(function(data){
                vm.locations = data.elements;
			});
			Restful.get("api/Industries").success(function(data){
                vm.industryList = data.elements;
            });
		};
		var params = {id: $stateParams.id};
		vm.init(params);

		// update functionality
		vm.save = function(){
			vm.disabled = false;
			if($state.current.name != 'user_create'){
				Restful.put('api/Customer/' + $stateParams.id, vm.account).success(function (data) {
					vm.disabled = true;console.log(data);
					if(data == 'success'){
						vm.service.alertMessage('<b>Complete:</b> Update Success.');
						$location.path('user');
					}else{
						vm.service.alertMessage('<b>Warning:</b> Email Existing. Please use other email.');
					}
				});
			}else{
				Restful.post('api/Customer/', vm.account).success(function (data) {
					vm.disabled = true;console.log(data);
					if(data.id){
						vm.service.alertMessage('<b>Complete:</b> Update Success.');
						$location.path('user');
					}else{
						vm.service.alertMessage('<b>Warning:</b> Email Existing. Please use other email.');
					}
				});
			}
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