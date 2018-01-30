app.controller(
	'plan_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$stateParams'
	, '$state'
	, function ($scope, Restful, Services, $stateParams, $state){
		var vm = this;
		vm.service = new Services();
		var url = "api/Session/User/ProductPost/";
		// init category
		vm.initSetting = function(){
			Restful.get("api/Plan").success(function(data){
				vm.plans = data;console.log(data);
			});
		};
		vm.initSetting();
		vm.back = function($event){
			$event.preventDefault();
			$state.go('/manage');
		};

		vm.selectPlan = function(rangeIndex){
			vm.selected = true;
			vm.plans.elements.map(function(item, index){
				if(rangeIndex === index){
					vm.promotionId = item.id;
					item.selected = true;
				}else{
					item.selected = false;
				}
			});
		};

		vm.updatePlan = function(){
			vm.disabled = true;
			Restful.post("api/Session/User/Plan/" + $stateParams.id, {promote_id: vm.promotionId}).success(function (data) {
				// console.log(data);
				vm.disabled = false;
				vm.service.alertMessage('<b>Complete: </b>Update Success.');
				$state.go('/manage');
			});
		};
	}
]);