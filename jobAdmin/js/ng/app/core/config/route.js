app.config([
	'$stateProvider',
	'$urlRouterProvider',
	'$locationProvider',
	function($stateProvider, $urlRouterProvider, $locationProvider) {
		
		$stateProvider
			.state('/', {
				url: '/',
				templateUrl: 'js/ng/app/index/partials/index.html',
				controller: 'index_ctrl as vm'
			})
			.state('/content', {
				url: '/content',
				templateUrl: 'js/ng/app/content/partials/index.html',
				controller: 'content_ctrl as vm'
			})
			.state('/customer_expire', {
				url: '/customer_expire',
				templateUrl: 'js/ng/app/report_customer_expire/partials/index.html',
				controller: 'report_customer_expire_ctrl as vm'
			})
			.state('/customer_plan', {
				url: '/customer_plan',
				templateUrl: 'js/ng/app/customer_plan/partials/index.html',
				controller: 'customer_plan_ctrl as vm'
			})
			.state('/news', {
				url: '/news',
				templateUrl: 'js/ng/app/news/partials/news.html',
				controller: 'news_ctrl as vm'
			})
			.state('/news/post', {
				url: '/news/post',
				templateUrl: 'js/ng/app/news/partials/news_post.html',
				controller: 'news_post_ctrl as vm'
			})
			.state('/news/edit/:id', {
				url: '/news/edit/:id',
				templateUrl: 'js/ng/app/news/partials/news_edit.html',
				controller: 'news_edit_ctrl as vm'
			})
			.state('/news_type', {
				url: '/news_type',
				templateUrl: 'js/ng/app/news/partials/type.html',
                controller: 'type_ctrl'
			})
			.state('/news_type/edit:id', {
				url: '/news_type/edit/:id',
				templateUrl: 'js/ng/app/news/partials/type_edit.html',
				controller: 'type_edit_ctrl as vm'
			})
			.state('/news_type/post', {
				url: '/news_type/post',
				templateUrl: 'js/ng/app/news/partials/type_post.html',
				controller: 'type_post_ctrl as vm'
			})
			.state('/slider', {
				url: '/slider',
				templateUrl: 'js/ng/app/image_slider/partials/index.html',
				controller: 'image_slider_ctrl as vm'
			})
			.state('/user', {
				url: '/user',
				templateUrl: 'js/ng/app/user/partials/index.html',
				controller: 'user_ctrl as vm'
			})
			.state('user_create', {
				url: '/user/create',
				templateUrl: 'js/ng/app/user/partials/user_edit.html',
				controller: 'user_edit_ctrl as vm'
			})
			.state('/user/edit/:id', {
				url: '/user/edit/:id',
				templateUrl: 'js/ng/app/user/partials/user_edit.html',
				controller: 'user_edit_ctrl as vm'
			})
			.state('/location', {
				url: '/location',
				templateUrl: 'js/ng/app/location/partials/location.html',
				controller: 'location_ctrl as vm'
			})
			.state('/district', {
				url: '/district',
				templateUrl: 'js/ng/app/location/partials/district.html',
				controller: 'district_ctrl as vm'
			})
			.state('/village', {
				url: '/village',
				templateUrl: 'js/ng/app/location/partials/village.html',
				controller: 'village_ctrl as vm'
			})
			.state('/category', {
				url: '/category',
				templateUrl: 'js/ng/app/category/partials/index.html',
				controller: 'category_ctrl as vm'
			})
			.state('/product', {
				url: '/product',
				templateUrl: 'js/ng/app/product/partials/index.html',
				controller: 'product_ctrl as vm'
			})
			.state('product_post', {
				url: '/product/post',
				templateUrl: 'js/ng/app/product/partials/product_edit.html',
				controller: 'product_edit_ctrl as vm'
			})
			.state('/product/edit/:id', {
				url: '/product/edit/:id',
				templateUrl: 'js/ng/app/product/partials/product_edit.html',
				controller: 'product_edit_ctrl as vm'
			})
			.state('/popular_location', {
				url: '/popular_location',
				templateUrl: 'js/ng/app/search_location/partials/index.html',
				controller: 'search_popular_ctrl as vm'
			})
			/**
			 * Route for Salary Range
			 */
			.state('salary_range', {
                url: '/salary_range',
                template: '<div ui-view></div>',
                redirectTo: 'salary_range.list'
            })
			.state('salary_range.list', {
				url: '',
				templateUrl: 'js/ng/app/salary_range/partials/index.html',
				controller: 'salary_range_ctrl as vm'
			})
			.state('salary_range.create', {
				url: '/create',
				templateUrl: 'js/ng/app/salary_range/partials/create.html',
				controller: 'salary_range_create_ctrl as vm'
			})
			.state('salary_range.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/salary_range/partials/create.html',
				controller: 'salary_range_create_ctrl as vm'
			})
			
			/**
			 * Route CV List
			 */
			.state('cv', {
                url: '/cv',
                template: '<div ui-view></div>',
                redirectTo: 'cv.list'
            })
			.state('cv.list', {
				url: '',
				templateUrl: 'js/ng/app/cv/partials/cv.html',
				controller: 'cv_ctrl as vm'
			})
			.state('cv.detail', {
				url: '/detail/:id',
				templateUrl: 'js/ng/app/cv/partials/cv_detail.html',
				controller: 'cv_detail_ctrl as vm'
			})
			.state('cv.create', {
				url: '/create',
				templateUrl: 'js/ng/app/cv/partials/cv_post.html',
				controller: 'cv_post_ctrl as vm'
			})
			.state('cv.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/cv/partials/cv_post.html',
				controller: 'cv_post_ctrl as vm'
			})
			/**
			 * Route for Industries
			 */
			.state('industries', {
                url: '/industries',
                template: '<div ui-view></div>',
                redirectTo: 'industries.list'
            })
			.state('industries.list', {
				url: '',
				templateUrl: 'js/ng/app/industries/partials/index.html',
				controller: 'industries_ctrl as vm'
			})
			.state('industries.create', {
				url: '/create',
				templateUrl: 'js/ng/app/industries/partials/create.html',
				controller: 'industries_create_ctrl as vm'
			})
			.state('industries.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/industries/partials/create.html',
				controller: 'industries_create_ctrl as vm'
			})
			.state('advertisement', {
				url: '/advertisement',
				templateUrl: 'js/ng/app/advertising_banner/partials/index.html',
				controller: 'advertising_banner_ctrl as vm'
			})
			.state('plan', {
				url: '/plan',
				templateUrl: 'js/ng/app/plan/partials/index.html',
				controller: 'plan_ctrl as vm'
			})
		;
		$urlRouterProvider.otherwise('/');
		// use the HTML5 History API to remove # url
		// $locationProvider.html5Mode(true);
	}
]);

app.run(['$rootScope', '$state', function($rootScope, $state) {

	$rootScope.someData = "hello";

    $rootScope.$on('$stateChangeStart', function(evt, to, params) {
      if (to.redirectTo) {
        evt.preventDefault();
        $state.go(to.redirectTo, params, {location: 'replace'})
      }
    });
}]);