app.controller(
	'job_seeker_ctrl', [
	'$scope'
	, 'Restful'
	, function ($scope, Restful){
		var params = {pagination: 'yes', user_type: 'normal', is_publish: 'yes'};
		var url = 'api/Employers/';
		$scope.init = function(params){
			Restful.get(url, params).success(function(data){
				$scope.data = data;
				console.log(data);
				$scope.totalItems = data.count;
			});
		};
		$scope.init(params);

		$scope.renderLink = function(id, link){
			var replace = link.toLowerCase().split(' ').join('_');
			var url = replace + '-i-' + id + '.html';
			return url;
		};
		/**
		 * start functionality pagination
		 */
		$scope.currentPage = 1;
		//get another portions of data on page changed
		$scope.pageChanged = function() {
			$scope.pageSize = 10 * ( $scope.currentPage - 1 );
			params.start = $scope.pageSize;
			$scope.init(params);
		};
	}
]);