app.controller(
	'product_info_ctrl', [
	'$scope'
	, '$sce'
	, 'Restful'
	, function ($scope, $sce, Restful){
		var vm = this;
		var url = 'api/CV/';
		vm.init = function(){
			vm.loading = true;
			Restful.get(url).success(function(data){
				vm.data = data.elements;
				console.log(vm.data);
			});
		};
		vm.init();
		
	}
]);