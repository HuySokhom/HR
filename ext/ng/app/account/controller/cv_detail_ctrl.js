app.controller(
	'cv_detail_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$stateParams'
	, '$state'
	, function ($scope, Restful, Services, $stateParams, $state){
		var vm = this;
		vm.service = new Services();
		var url = "api/Session/User/PostCV/";
		vm.model = {};
		// init setting
		vm.init = function(){
			Restful.get(url + $stateParams.id).success(function(data){
				// console.log(data);
				vm.model = data.elements[0];
			});
		};
		vm.init();
	}
]);