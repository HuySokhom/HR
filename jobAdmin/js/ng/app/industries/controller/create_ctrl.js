app.controller(
	'industries_create_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$state'
	, '$anchorScroll'
	, '$stateParams'
	, function ($scope, Restful, Services, $state, $anchorScroll, $stateParams){
		var vm = this;
		vm.disabled = true;
		vm.service = new Services();
		vm.model = {};

		var currentPage = $state.current.name;
		if(currentPage == 'industries.edit'){
			Restful.get('api/Industries/' + $stateParams.id).success(function(data){
				vm.model = data.elements[0];
				console.log(data);
			});
			vm.title = "Edit Industry";
		}else{
			vm.title = "Create Industry";
		}

		vm.save = function(){
			console.log(vm.leason);
			if (!$scope.leasonForm.$valid) {
                $anchorScroll();
                return;
            }
			vm.disabled = false;
			if(currentPage == 'industries.edit'){
				Restful.put('api/Industries', vm.model).success(function (data) {
					console.log(data);
					vm.service.alertMessage('Update Success.');
					$state.go('industries');
				}).finally( function(data){
					console.log(data);
					vm.disabled = true;
				});
			}else{
				Restful.post('api/Industries', vm.model).success(function (data) {
					console.log(data);
					vm.service.alertMessage('Complete Save Success.');
					$state.go('industries');
				}).finally( function(data){
					console.log(data);
					vm.disabled = true;
				});
			}
		};


	}
]);