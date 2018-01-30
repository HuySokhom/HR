app.config([
	'$stateProvider',
	'$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {
		$urlRouterProvider.otherwise('/account');
		$stateProvider.
			state('/manage', {
				url: '/manage',
				templateUrl: 'ext/ng/app/account/partials/property.html',
                controller: 'property_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type == 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			.state('/manage/post', {
				url: '/manage/post',
				templateUrl: 'ext/ng/app/account/partials/property_post.html',
				controller: 'property_post_ctrl',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type == 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('/account');
							}
						}
					]
				}
			})
			.state('duplicate', {
				url: '/duplicate/:id',
				templateUrl: 'ext/ng/app/account/partials/property_post.html',
				controller: 'property_post_ctrl',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type == 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			
			.state('manage_edit', {
				url: '/manage/edit/:id',
				templateUrl: 'ext/ng/app/account/partials/property_post.html',
				controller: 'property_post_ctrl',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type == 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			.state('/account', {
				url: '/account',
				templateUrl: 'ext/ng/app/account/partials/account.html',
                controller: 'account_ctrl',
				controllerAs: 'vm'
			})
			.state('/account/edit', {
				url: '/account/edit',
				templateUrl: 'ext/ng/app/account/partials/account_edit.html',
				controller: 'account_edit_ctrl',
				controllerAs: 'vm'
			})
			/**
			 * Start Route for Create CV
			 */
			.state('manage_cv', {
				url: '/manage-cv',
				templateUrl: 'ext/ng/app/account/partials/cv.html',
                controller: 'cv_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type != 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('/account');
							}
						}
					]
				}
			})
			.state('manage_cv_post', {
				url: '/manage-cv/post',
				templateUrl: 'ext/ng/app/account/partials/cv_post.html',
				controller: 'cv_post_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type != 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			.state('manage_cv_edit', {
				url: '/manage-cv/edit/:id',
				templateUrl: 'ext/ng/app/account/partials/cv_post.html',
				controller: 'cv_post_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type != 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			.state('manage_cv_detail', {
				url: '/manage-cv/detail/:id',
				templateUrl: 'ext/ng/app/account/partials/cv_detail.html',
				controller: 'cv_detail_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type != 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('account');
							}
						}
					]
				}
			})
			.state('plan', {
				url: '/plan/:id',
				templateUrl: 'ext/ng/app/account/partials/plan.html',
				controller: 'plan_ctrl as vm',
				resolve: {
					getDetail: [
						'Restful',
						function (Restful) {
							return Restful.get('api/UserSession').success(function(data){
								return data;
							});
						}
					],
					detailResult: [ '$q', '$timeout', '$state', 'getDetail',
						function ($q, $timeout, $state, getDetail) {
							//console.log(getDetail.data.user_type);
							if (getDetail.data.user_type == 'normal') {
								// Prevent migration to default state
								event.preventDefault();
								$state.go('/account');
							}
						}
					]
				}
			})
		;
		$urlRouterProvider.otherwise('/account');
	}
]);
