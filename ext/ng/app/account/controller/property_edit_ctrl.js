app.controller(
	'property_edit_ctrl', [
	'$scope'
	, 'Restful'
	, '$stateParams'
	, 'Services'
	, '$location'
	, 'alertify'
	, '$log'
	, 'Upload'
	, '$timeout'
	, function ($scope, Restful, $stateParams, Services, $location, $alertify, $log, Upload, $timeout){
		// init tiny option
		$scope.tinymceOptions = {
		};
		$scope.disabled = true;
		$scope.propertyTypes = ["Part-Time", "Full-Time"];
		$scope.genders = ["Male", "Female", "Both"];
		// init category
		$scope.initCategory = function(){
			Restful.get("api/Category").success(function(data){
				$scope.categoryList = data;
			});
			Restful.get("api/Location").success(function(data){
				$scope.provinces = data;
			});
		};
		$scope.initCategory();

		var url = 'api/Session/User/ProductPost/';
		$scope.service = new Services();

		$scope.init = function(params){
			Restful.get(url + $stateParams.id, params).success(function(data){console.log(data);
				$scope.optionalImage = data.elements[0].image_detail;
				$scope.district_id = data.elements[0].district_id;
				$scope.province_id = data.elements[0].province_id;
				$scope.property_type = data.elements[0].products_kind_of;
				$scope.bed_rooms = data.elements[0].bed_rooms;
				$scope.bath_rooms = data.elements[0].bath_rooms;
				$scope.number_of_floors = data.elements[0].number_of_floors;
				$scope.image_thumbnail = data.elements[0].products_image_thumbnail;
				$scope.image = data.elements[0].products_image;
				$scope.price = data.elements[0].products_price;
				$scope.categories_id = data.elements[0].categories_id;
				$scope.commune_id = data.elements[0].village_id;
				$scope.title_en = data.elements[0].product_detail[0].products_name;
				$scope.title_kh = data.elements[0].product_detail[1].products_name;
				$scope.content_en = data.elements[0].product_detail[0].products_description;
				$scope.content_kh = data.elements[0].product_detail[1].products_description;
				$scope.longitude = data.elements[0].map_long;
				$scope.latitude = data.elements[0].map_lat;

			});
		};
		$scope.init();		

		/***************** update functionality *******************/
		$scope.save = function(){
			// set object to save into news
			var data = {
				products: {
					products_image: $scope.image,
					map_lat: $scope.marker.coords.latitude,
					map_long: $scope.marker.coords.longitude,
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
			$scope.disabled = true;

			Restful.put(url + $stateParams.id, data).success(function (data) {
				$scope.disabled = false;
				$scope.service.alertMessage('<b>Complete: </b>Update Success.');
				$location.path('manage_property');
			});
		};

		$scope.back = function($event){
			$event.preventDefault();
			$location.path('/manage');
		};
	}
]);