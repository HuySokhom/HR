app.controller(
	'job_seeker_ctrl', [
	'$scope'
	, '$sce'
	, 'Restful'
	, function ($scope, $sce, Restful){
		var vm = this;
		Restful.get('api/Category').success(function(data){
			vm.functionList = data.elements;
		});
		var params = {pagination: 'yes', user_type: 'normal', is_publish: 'yes'};
		var url = 'api/CV/';
		vm.init = function(params){
			vm.loading = true;
			Restful.get(url, params).success(function(data){
				vm.data = data;
				// console.log(data);
				vm.loading = false;
				vm.totalItems = data.count;
			});
		};
		vm.init(params);
		vm.search = function(){
			params.function = vm.function;
			params.apply_for = vm.search_name;
			vm.init(params);
		};

		// vm.view = function(params){
		// 	vm.model = angular.copy(params);
		// 	vm.model.cover_letter_summary = $sce.trustAsHtml(params.cover_letter_summary);
		// 	vm.model.experience = $sce.trustAsHtml(params.experience);
		// 	vm.model.summary = $sce.trustAsHtml(params.summary);
		// 	vm.model.working_history = $sce.trustAsHtml(params.working_history);
		// 	// console.log(vm.model);
		// 	// $("#cv").modal("show");
		// };

		// $scope.renderLink = function(id, link){
		// 	var replace = link.toLowerCase().split(' ').join('_');
		// 	var url = replace + '-i-' + id + '.html';
		// 	return url;
		// };
		/**
		 * start functionality pagination
		 */
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 40 * ( vm.currentPage - 1 );
			params.start = vm.pageSize;
			vm.init(params);
		};
		vm.getFullName = function(text){
			var str = text;
			str = str.replace(/\s+/g, '-').toLowerCase();
			return str;
		};

		// var doc = new jsPDF();
		// var specialElementHandlers = {
		// 	'#editor': function (element, renderer) {
		// 		return true;
		// 	}
		// };
		
		// vm.download = function(){
		// 	doc.fromHTML($('#content').html(), 15, 15, {
		// 		'width': 170,
		// 			'elementHandlers': specialElementHandlers
		// 	});
		// 	doc.save('sample-file.pdf');
		// };
	}
]);