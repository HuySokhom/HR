app.controller(
	'lesson_ctrl', [
	'$scope'
	, 'Restful'
	, function ($scope, Restful){
		var vm = this;
		vm.params = {pagination: 'yes'};
		var url = 'api/Leason/';
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
				vm.data = data;
				//console.log(data);
				vm.totalItems = data.count;
			});
		};
		vm.init(vm.params);

		vm.renderLink = function(id, link){
			var replace = link.replace(/[^a-zA-Z ]/g, "_");
			replace = replace.toLowerCase().split(' ').join('_');
			var url = replace + '-le-' + id + '.html';
			return url;
		};
		/**
		 * start functionality pagination
		 */
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 10 * ( vm.currentPage - 1 );
			vm.params.start = vm.pageSize;
			vm.init(vm.params);
		};
	}
]);