app.config([
	'$stateProvider',
	'$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {
		$stateProvider.
			state('/manage', {
				url: '/manage',
				templateUrl: 'ext/ng/app/account/partials/property.html',
                controller: 'property_ctrl'
			})
			.state('/manage/post', {
				url: '/manage/post',
				templateUrl: 'ext/ng/app/account/partials/property_post.html',
				controller: 'property_post_ctrl'
			})
			.state('/manage/edit/:id', {
				url: '/manage/edit/:id',
				templateUrl: 'ext/ng/app/account/partials/property_edit.html',
				controller: 'property_edit_ctrl'
			})
			.state('/account', {
				url: '/account',
				templateUrl: 'ext/ng/app/account/partials/account.html',
                controller: 'account_ctrl'
			})
			.state('/account/edit', {
				url: '/account/edit',
				templateUrl: 'ext/ng/app/account/partials/account_edit.html',
				controller: 'account_edit_ctrl'
			})
		;
		$urlRouterProvider.otherwise('/account');
	}
]);
