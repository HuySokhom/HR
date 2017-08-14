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
		
		var currentPage = $state.current.name;
		if(currentPage == 'salary_range.edit'){
			Restful.get('api/SalaryRange/' + $stateParams.id).success(function(data){
				vm.model = data.elements[0];
				console.log(data);
			});
		}

		vm.save = function(){
			console.log(vm.model);
			if (!$scope.modelForm.$valid) {
                $anchorScroll();
                return;
            }
			vm.disabled = false;
			Restful.post('api/SalaryRange', vm.model).success(function (data) {
				console.log(data);
				vm.service.alertMessage('Complete Save Success.');
				$state.go('salary_range');
			}).finally( function(data){
				console.log(data);
				vm.disabled = true;
			});
		};

	}
]);