app.controller(
	'cv_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, 'Upload'
	, '$timeout'
	, '$location'
	, 'alertify'
	, '$state'
	, function ($scope, Restful, Services, Upload, $timeout, $location, $alertify, $state){
		var vm = this;
		vm.service = new Services();
		vm.filter = {pagination: 'yes'};
		var url = 'api/Session/User/PostCV/';

		Restful.get("api/Category").success(function(data){
			vm.categoryList = data;
		});
		vm.init = function(){
			Restful.get(url, vm.filter).success(function(data){
				vm.cv_post = data;
				// console.log(data);
				vm.totalItems = data.count;
			});
		};
		vm.init();
		vm.disabled = true;

		vm.edit = function(id){
			$state.go('manage_cv_edit', {id: id});
		};

		vm.refreshDate = function(params){
			Restful.patch(url + params.id).success(function(data){
				vm.init();
				vm.service.alertMessage('<strong>Complete: </strong> Refresh Success.');
			});
		};

		vm.promote = function(params){
			var data = { products_promote: params.products_promote, name: "promote_product"};
			Restful.patch(url + params.id, data).success(function(data){
				console.log(data);
				if(data == 'success'){
					vm.service.alertMessage('<strong>Complete: </strong> Update Status Success.');
				}else if (data == 'limit'){
					vm.service.alertMessagePromt('<strong>Warning: </strong> Your Plan Has Limit Boost Property.');
				}else{
					vm.service.alertMessagePromt('<strong>Warning: </strong> Please Upgrade Your Plan To Boost Property.');
				}
				vm.init();
			});
		};

		vm.updateStatus = function(params){
			params.status == 1 ? params.status = 0 : params.status = 1;
			var data = { status: params.status, name: "update_status"};
			var url = 'api/Session/User/PostCV/' + params.id;
			Restful.patch(url, data).success(function(data){
				vm.init();
				vm.service.alertMessage('<strong>Complete: </strong> Update Status Success.');
			});
		};

		vm.link = function(id){
			window.open('-p-' + id + '.html','_blank');
		};

		vm.remove = function(id){
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("<b>Waring: </b>" +
						"Are you sure want to delete this cv?", function (ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
					Restful.delete( url + id ).success(function(data){
						vm.disabled = true;
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						vm.init();
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
			vm.init();
		};
		/**
		 * start functionality pagination
		 */
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 10 * ( vm.currentPage - 1 );
			vm.filter.start = vm.pageSize;
			vm.init();
		};
	}
]);