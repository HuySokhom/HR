app.controller(
	'product_edit_ctrl', [
	'$scope'
	, 'Restful'
	, '$stateParams'
	, 'Services'
	, '$location'
	, 'alertify'
	, 'Upload'
	, '$timeout'
	, function ($scope, Restful, $stateParams, Services, $location, $alertify, Upload, $timeout){
		var vm = this;
		vm.tinymceOptions = {};
		vm.disabled = true;
		vm.propertyTypes = ["Part-Time", "Full-Time"];
		vm.genders = ["Male", "Female", "Both"];

		var url = 'api/Product/';
		vm.service = new Services();

		vm.init = function(params){
			Restful.get(url + $stateParams.id, params).success(function(data){
                vm.model = data.elements[0];
                console.log(vm.model);
			});
            Restful.get("api/Category").success(function(data){
                vm.categoryList = data;
            });
            Restful.get("api/Location").success(function(data){
                vm.locations = data;
            });
		};
		vm.init();

		// update functionality
		vm.save = function(){
			// set object to save into news
			var data = {
				products: {
					products_image: $scope.image,
					products_image_thumbnail: $scope.image_thumbnail,
					categories_id: $scope.categories_id,
					province_id: $scope.province_id,
					district_id: $scope.district_id,
					village_id: $scope.commune_id,
					products_price: $scope.price,
					products_kind_of: $scope.property_type,
					bed_rooms: $scope.bed_rooms,
					bath_rooms: $scope.bath_rooms,
					number_of_floors: $scope.number_of_floors,
					products_promote: $scope.property_plan,
					map_lat: $scope.marker.coords.latitude,
					map_long: $scope.marker.coords.longitude,
				},
				products_description: [
					{
						products_name: $scope.title_en,
						products_description: $scope.content_en,
						language_id: 1
					},
					{
						products_name: $scope.title_kh,
						products_description: $scope.content_kh,
						language_id: 2
					}
				],
				products_image: $scope.optionalImage
			};
            vm.disabled = false;

			Restful.put(url + $stateParams.id, data).success(function (data) {
                vm.disabled = true;
				console.log(data);
                vm.service.alertMessage('<b>Complete: </b>Update Success.');
				$location.path('product');
			});
		};

		//functionality upload
		vm.uploadPic = function(file, type) {
			// validate on if image option limit with 8 photo.
			if(type == 'optional') {
				if(vm.optionalImage.length >= 8){
					return vm.service.alertMessagePromt('<b>Warning: </b>We limit image upload only 8 photo.');
				}
			}
			if (file) {
				file.upload = Upload.upload({
					url: 'api/ImageUpload',
					data: {file: file, username: $scope.username},
				});
				file.upload.then(function (response) {
					$timeout(function () {
						file.result = response.data;
						if(type == 'feature_image') {
                            vm.image = response.data.image;
                            vm.image_thumbnail = response.data.image_thumbnail;
						}
						if(type == 'optional') {
							var option = {
								image: response.data.image,
								image_thumbnail: response.data.image_thumbnail
							};
                            vm.optionalImage.push(option);
						}
					});
				}, function (response) {
					if (response.status > 0)
						$scope.errorMsg = response.status + ': ' + response.data;
				}, function (evt) {
					// Math.min is to fix I	E which reports 200% sometimes
					file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
				});
			}
		};

		vm.back = function($event){
			$event.preventDefault();
			$location.path('/product');
		};

	}
]);