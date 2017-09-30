app.controller(
	'product_edit_ctrl', [
	'$scope'
	, 'Restful'
	, '$stateParams'
	, '$state'
	, 'Services'
	, '$location'
	, 'alertify'
	, 'Upload'
	, '$timeout'
	, function ($scope, Restful, $stateParams, $state, Services, $location, $alertify, Upload, $timeout){
		var vm = this;
		vm.tinymceOptions = {};
		vm.disabled = true;
		vm.propertyTypes = ["Part-Time", "Full-Time"];
		vm.genders = ["Male", "Female", "Both"];
		vm.model = {
			product: {
				products_close_date: new Date(moment().add(1, 'months'))
			},
			product_description: {}
		};
		vm.format = 'yyyy/MM/dd';
		var url = 'api/Product/';
		vm.service = new Services();

		vm.init = function(){
			if($state.current.name != 'product_post'){
				console.log($state.current.name);
				Restful.get(url + $stateParams.id).success(function(data){
					vm.model.product = data.elements[0];
					// vm.model.product.products_close_date = moment(vm.model.product.products_close_date).format("YYYY-MM-DD");
					console.log(data);
					vm.customer = {id: vm.model.product.customers_id, company_name: vm.model.product.company_name};
					vm.model.product_description = data.elements[0].product_detail[0];
				});
			}
            // Restful.get("api/Category").success(function(data){
            //     vm.categoryList = data;
			// });
			Restful.get("api/SalaryRange").success(function(data){
                vm.salaryList = data;
			});
			
			//  Restful.get("api/Industries").success(function(data){
            //     vm.industriesList = data;
            // });
            Restful.get("api/Location").success(function(data){
                vm.locations = data;
            });
		};
		vm.init();
		vm.bindCustomerList = function(text){
			Restful.get("api/Customer", {type:'agency', search_name: text}).success(function(data){
				vm.customerList = data.elements;
				console.log(data);
			});
		};
		// update functionality
		vm.save = function(){
			// var d = vm.model.product.products_close_date.getDate();
			// var m =  vm.model.product.products_close_date.getMonth();
			// m += 1;  
			// var y = vm.model.product.products_close_date.getFullYear();
			// vm.model.product.products_close_date = y+ "-" + m + "-" + d;
            vm.disabled = false;
			console.log(vm.model);
			vm.model.product.customers_id = vm.customer.id;
			if($state.current.name == 'product_post'){
				Restful.post(url, vm.model).success(function(data){
					vm.disabled = true;
					console.log(data);
					vm.service.alertMessage('<b>Complete: </b>Save Success.');
					$location.path('product');
				});
			}else{
				Restful.put(url + $stateParams.id, vm.model).success(function (data) {
					vm.disabled = true;
					console.log(data);
					vm.service.alertMessage('<b>Complete: </b>Update Success.');
					$location.path('product');
				});
			}
		};

		vm.back = function($event){
			$event.preventDefault();
			$location.path('/product');
		};
		vm.open = function() {
			vm.opened = true;
		};

	}
]);