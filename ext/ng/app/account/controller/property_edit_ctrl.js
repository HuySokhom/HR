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
			Restful.get(url + $stateParams.id, params).success(function(data){
				// console.log(data);
				$scope.model = data.elements[0];

			});
		};
		$scope.init();		

		/***************** update functionality *******************/
		$scope.save = function(){
			console.log( $scope.model);
			$scope.disabled = true;
			Restful.put(url + $stateParams.id, $scope.model).success(function (data) {
				// console.log(data);
				$scope.disabled = false;
				$scope.service.alertMessage('<b>Complete: </b>Update Success.');
				$location.path('manage');
			});
		};

		$scope.back = function($event){
			$event.preventDefault();
			$location.path('/manage');
		};
	}
]);