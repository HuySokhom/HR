app.controller(
	'property_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, 'Upload'
	, '$timeout'
	, '$location'
	, 'alertify'
	, function ($scope, Restful, Services, Upload, $timeout, $location, $alertify){
		var vm = this;
		vm.service = new Services();
		var params = {pagination: 'yes'};
		var url = 'api/Session/User/ProductPost/';
		vm.init = function(params){
			Restful.get(url, params).success(function(data){
				vm.products_post = data;
				// console.log(data);
				vm.totalItems = data.count;
			});
			Restful.get("api/Category").success(function(data){
				vm.categoryList = data;
			});
		};
		vm.init();
		vm.disabled = true;

		vm.edit = function(id){
			$location.path("/manage/edit/" + id);
		};

		vm.refreshDate = function(params){
			Restful.patch('api/Session/User/ProductPost/' + params.products_id).success(function(data){
				vm.init();
				vm.service.alertMessage('<strong>Complete: </strong> Update Product Refresh Success.');
			});
		};

		vm.promote = function(params){console.log(params);
			var data = { products_promote: params.products_promote, name: "promote_product"};
			Restful.patch('api/Session/User/ProductPost/' + params.products_id, data).success(function(data){
				// console.log(data);
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
			params.products_status == 1 ? params.products_status = 0 : params.products_status = 1;
			var data = { status: params.products_status, name: "update_status"};
			Restful.patch('api/Session/User/ProductPost/' + params.products_id, data).success(function(data){
				vm.service.alertMessage('<strong>Complete: </strong> Update Status Success.');
			});
		};

		vm.link = function(id){
			window.open('-p-' + id + '.html','_blank');
		};

		vm.remove = function($index, id){
			$alertify.okBtn("Ok")
				.cancelBtn("Cancel")
				.confirm("<b>Waring: </b>" +
						"Are you sure want to delete this product.", function (ev) {
					// The click event is in the
					// event variable, so you can use
					// it here.
					ev.preventDefault();
					Restful.delete( url + id ).success(function(data){
						vm.disabled = true;
						vm.service.alertMessage('<strong>Complete: </strong>Delete Success.');
						vm.products_post.elements.splice($index, 1);
						vm.init(params);
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
			params.search_title = vm.search_title;
			params.id = vm.id;
			params.type = vm.category_id;
			vm.init(params);
		};
		/**
		 * start functionality pagination
		 */
		vm.currentPage = 1;
		//get another portions of data on page changed
		vm.pageChanged = function() {
			vm.pageSize = 10 * ( vm.currentPage - 1 );
			params.start = vm.pageSize;
			vm.init(params);
		};
	}
]);