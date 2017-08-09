app.controller(
	'salary_range_create_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$state'
	, 'Upload'
	, '$timeout'
	, '$anchorScroll'
	, '$stateParams'
	, function ($scope, Restful, Services, $state, Upload, $timeout, $anchorScroll, $stateParams){
		var vm = this;
		vm.disabled = true;
		vm.service = new Services();
		// init tiny option
		vm.tinymceOptions = {
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern media"
			],
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor emoticons",
			image_advtab: true,
			paste_data_images: true
		};
		vm.leason = {};

		var currentPage = $state.current.name;
		if(currentPage == 'leason.edit'){
			Restful.get('api/Leason/' + $stateParams.id).success(function(data){
				vm.leason = data.elements[0];
				console.log(data);
			});
		}

		vm.save = function(){
			console.log(vm.leason);
			if (!$scope.leasonForm.$valid) {
                $anchorScroll();
                return;
            }
			vm.disabled = false;
			Restful.post('api/Leason', vm.leason).success(function (data) {
				console.log(data);
				vm.service.alertMessage('Complete Save Success.');
				$state.go('leason');
			}).finally( function(data){
				console.log(data);
				vm.disabled = true;
			});
		};

		//functionality upload
		vm.uploadPic = function(file) {
			if (file) {
				file.upload = Upload.upload({
					url: 'api/FileUpload',
					data: {file: file},
				});console.log(file);
				file.upload.then(function (response) {
					$timeout(function () {
						console.log(response);
						file.result = response.data;
						vm.leason.file_leason = response.data.file;
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