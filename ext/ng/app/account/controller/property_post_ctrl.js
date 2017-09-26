app.controller(
	'property_post_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'Upload'
	, '$timeout'
	, '$log'
	, '$stateParams'
	, '$state'
	, function ($scope, Restful, Services, $location, Upload, $timeout, $log, $stateParams, $state){
		var vm = this;
		$scope.service = new Services();
		$scope.rangeSalary = [];
		$scope.propertyTypes = ["Part-Time", "Full-Time"];
		$scope.genders = ["Male", "Female", "Both"];
		var url = "api/Session/User/ProductPost/";
		$scope.init = function(params){
			if($state.current.name == "manage_edit"){
				Restful.get(url + $stateParams.id, params).success(function(data){
					console.log(data);
					var model = data.elements[0];
					vm.id = model.id;
					$scope.categories_id = model.categories_id;
					$scope.province_id = model.province_id;
					$scope.expire_date = model.products_close_date;
					$scope.salary = model.salary_id;
					$scope.number_of_hire = model.number_of_hire;
					$scope.gender = model.gender;
					$scope.job_type = model.products_kind_of;
					$scope.title = model.product_detail[0].products_name;
					$scope.description = model.product_detail[0].products_description;
					$scope.benefits = model.product_detail[0].benefits;
					$scope.requirement = model.product_detail[0].skill;
				});
			}
		};
		$scope.init();	

		// init category
		$scope.initSetting = function(){
			Restful.get("api/Category").success(function(data){
				$scope.categoryList = data;
			});
			Restful.get("api/Location").success(function(data){
				$scope.provinces = data;
			});
			Restful.get("api/SalaryRange").success(function(data){
				$scope.rangeSalary = data.elements;
			});
		};
		$scope.initSetting();
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
		$scope.expire_date = moment().add(1, 'month').format("YYYY-MM-DD");
		// save functionality
		$scope.save = function(){
			// set object to save i
			var data = {
				products: {
					categories_id: $scope.categories_id,
					province_id: $scope.province_id,
					products_close_date: $scope.expire_date,
					salary_id: $scope.salary,
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
			if(!vm.id){				
				Restful.post(url, data).success(function (data) {
					$scope.disabled = true;
					$scope.service.alertMessage('<b>Complete: </b>Save Success.');
					$location.path('manage');
					console.log(data);
				});
			}else{
				Restful.put(url + vm.id, data).success(function (data) {
					console.log(data);
					$scope.disabled = true;
					$scope.service.alertMessage('<b>Complete: </b>Update Success.');
					$location.path('manage');
				});
			}
		
		};

		$scope.back = function($event){
			$event.preventDefault();
			$location.path('/manage');
		};

		$scope.dateOptions = {
			dateDisabled: disabled,
			formatYear: 'yy',
			minDate: new Date(),
			startingDay: 1
		};
		$scope.format = "yyyy/MM/dd";
		$scope.open = function() {
			$scope.opened = true;
		};
		
		// Disable weekend selection
		function disabled(data) {
			var date = data.date,
				mode = data.mode;
			return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
		}
	}
]);