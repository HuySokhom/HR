app.controller(
	'product_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$location'
	, 'alertify'
	, '$timeout'
	, function ($scope, Restful, Services, $location, $alertify, $timeout){
		var vm = this;
		vm.service = new Services();
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
		var params = {};
		var url = 'api/Product/';
		function init(params){
			Restful.get(url, params).success(function(data){
				vm.products = data;
				vm.totalItems = data.count;
				console.log(data);
			});
			// Restful.get("api/Category").success(function(data){
			// 	vm.categoryList = data;
			// });
			// Restful.get("api/Customer", {type: 'agency'}).success(function(data){
			// 	vm.customerList = data;
			// });
		};
		init(params);

		vm.edit = function(params){
			console.log(params);
			$location.path('/product/edit/' + params.id);
		};

		vm.remove = function(id){
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("Are you sure you want to delete this product?", function (ev) {
					ev.preventDefault();
					Restful.delete( url + id, params ).success(function(data){
						vm.disabled = true;
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						//vm.products.elements.splice($index, 1);
						init(params);
					});
				}, function(ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
				});
		};

		vm.edit = function(id){
			$location.path("/product/edit/" + id);
		};

		vm.refreshDate = function(param){
			Restful.patch(url + param.id).success(function(data){
				init(params);
			});
		};

		vm.updateStatus = function(params){
			params.is_publish == 1 ? params.is_publish = 0 : params.is_publish = 1;
			var data = { status: params.is_publish, name: "update_status"};
			Restful.patch(url + params.id, data).success(function(data){console.log(data);
				vm.service.alertMessage('<strong>Complete: </strong> Update Status Success.');
			});
		};

		vm.link = function(id){
			window.open('-p-' + id + '.html','_blank');
		};
		// search functionality
		vm.search = function(){
			console.log('search');
			$timeout(function() {				
				params.search_title = vm.search_title;
				params.id = vm.id;
				params.type = vm.category_id;
				params.sort_by = vm.sort_by;
				params.customer_id = vm.customer_id ? vm.customer_id.id : '';
				init(params);
			}, 50);
		};
		/**
		 * start functionality pagination
		 */
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 10 * ( vm.currentPage - 1 );
			params.start = vm.pageSize;
			init(params);
		};
	}
]);