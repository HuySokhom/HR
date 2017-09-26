app.controller(
	'account_ctrl', [
	'$scope'
	, 'Restful'
	, function ($scope, Restful){
		var vm = this;
		var url = 'api/Session/Customer/';
		$scope.language_id = $('#language_id').val();
		$scope.init = function(params){
			Restful.get(url, params).success(function(data){
				console.log(data);
				vm.account = data.elements[0];
			});
		};
		$scope.init();

	}
]);