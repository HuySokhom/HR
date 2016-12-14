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
            vm.disabled = false;

			Restful.put(url + $stateParams.id, vm.model).success(function (data) {
                vm.disabled = true;
				console.log(data);
                vm.service.alertMessage('<b>Complete: </b>Update Success.');
				$location.path('product');
			});
		};

		vm.back = function($event){
			$event.preventDefault();
			$location.path('/product');
		};

	}
]);