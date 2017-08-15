app.controller(
	'user_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, 'alertify'
	, '$location'
	, function ($scope, Restful, Services, $alertify, $location){
		var vm = this;
		vm.service = new Services();
		var url = 'api/Customer/';
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
				vm.users = data;
				vm.totalItems = data.count;
			});
		};
		vm.init();
		vm.sortType = [
			{
				id: 0,
				name: 'Free Plan'
			},
			{
				id: 1,
				name: 'Basic Plan'
			},
			{
				id: 2,
				name: 'Premium Plan'
			},
			{
				id: 3,
				name: 'Pro Plan'
			},
		];
		vm.updateStatus = function(params){
			params.is_agency == 1 ? params.is_agency = 0 : params.is_agency = 1;
            var data = {
                agency: 'yes',
                is_agency: params.is_agency
            };
			Restful.patch(url + params.id, data ).success(function(data) {
				vm.service.alertMessage('<strong>Success: </strong>Update Success.');
			});
		};

		vm.updateStatusApprove = function(params){
			params.is_publish == 1 ? params.is_publish = 0 : params.is_publish = 1;
			var data = {
				approve: 'yes',
                is_publish: params.is_publish
			};
			Restful.patch(url + params.id, data).success(function(data) {
				vm.service.alertMessage('<strong>Success: </strong>Update Success.');
			});
		};

		// remove functionality
		vm.remove = function(id, $index){
			vm.id = id;
			vm.index = $index;

			$alertify.okBtn("Ok")
					.cancelBtn("Cancel")
					.confirm("Are you sure want to delete this news?", function (ev) {
						// The click event is in the
						// event variable, so you can use
						// it here.
						ev.preventDefault();
						Restful.delete( url + vm.id ).success(function(data){
							vm.disabled = true;
							vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
							vm.init();
							//vm.news.elements.splice(vm.index, 1);
							//$('#message').modal('hide');
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
			params.search_name = vm.search_name;
			params.id = vm.id;
			params.type = vm.type;
			params.plan = vm.property_plan;
			console.log(params);
			vm.init(params);
		};
		// edit functionality
		vm.edit = function(id){
			$location.path('/user/edit/' + id);
		};

		/**
		 * start functionality pagination
		 */
		var params = {};
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 10 * ( vm.currentPage - 1 );
			params.start = vm.pageSize;
			vm.init(params);
		};
	}
]);