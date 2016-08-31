app.controller(
	'property_post_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, '$timeout'
	, '$log'
	, function ($scope, Restful, Services, $location, Upload, $timeout, $log){
		$scope.service = new Services();
		// init tiny option
		$scope.tinymceOptions = {
			
		};
		$scope.optionalImage = [];
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
		$scope.disabled = true;
		// functional for init district
		$scope.initDistrict = function(id){
			Restful.get("api/District/" + id).success(function(data){
				$scope.districts = data;
				$scope.communes = '';
			});
		};
		// functional for init Commune
		$scope.initCommune = function(id){
			Restful.get("api/Village/" + id).success(function(data){
				$scope.communes = data;
			});
		};
		// save functionality
		$scope.save = function(){
			// set object to save into news
			var data = {
				products: {
					categories_id: $scope.categories_id,
					province_id: $scope.province_id,
					products_close_date: $scope.expire_date,
					salary: $scope.salary,
					number_of_hire: $scope.number_of_hire,
					gender: $scope.gender,
					products_kind_of: $scope.job_type,
				},
				products_description: [
					{
						products_name: $scope.title,
						products_description: $scope.description,
						benefits: $scope.benefits,
						skill: $scope.requirement,
						language_id: 1
					}
				]
			};
			$scope.disabled = false;
			console.log(data);
			Restful.post("api/Session/User/ProductPost", data).success(function (data) {
				$scope.disabled = true;
				console.log(data);
				$scope.service.alertMessage('<b>Complete: </b>Save Success.');
				$location.path('manage');
			});
		};

		$scope.back = function($event){
			$event.preventDefault();
			$location.path('/manage');
		};


	}
]);