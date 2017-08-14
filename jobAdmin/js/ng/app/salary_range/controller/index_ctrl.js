app.controller(
	'salary_range_ctrl', [
	'$scope'
	, 'Restful'
	, '$state'
	, 'Services'
	, 'alertify'
	, function ($scope, Restful, $state, Services, $alertify){
		var vm = this;
		vm.service = new Services();
		vm.params = {};
		var url = 'api/SalaryRange/';
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
				vm.model = data;
				vm.totalItems = data.count;
			});
		};
		vm.init(vm.params);

		vm.updateStatus = function(params){
			console.log(params);
			params.status === 1 ? params.status = 0 : params.status = 1;
			Restful.patch(url + params.id, params ).success(function(data) {
				console.log(data);
				vm.service.alertMessage('<strong>Success: </strong>Update Success.');
			});
		};

		// remove functionality
		vm.remove = function(id, $index){
			vm.index = $index;
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("Are you sure want to delete this record?", function (ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
					Restful.delete( url + id ).success(function(data){
						vm.disabled = true;
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						vm.init(vm.params);
					});
				}, function(ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
				});

		};
		// search functionality
		vm.search = function(){
			vm.params.search_title = vm.search_title;
			vm.params.id = vm.id;
			vm.init(vm.params);
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
