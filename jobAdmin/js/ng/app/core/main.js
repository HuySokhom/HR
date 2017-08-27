var app = angular.module(
    'main',
    [
        'ui.router'
        , 'ui.bootstrap'
        , 'ngSanitize'
        , 'ui.tinymce'
        , 'ngFileUpload'
        , 'ngAlertify'
        , 'ui.select'
        , 'ds.clock'
        , 'ui.calendar'
    ]
);
// range with number
app.filter('rangeNumber', function () {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 1; i <= total; i++) {
        //if(i <= 9 ){

        //}
        input.push(i);
        }
        return input;
    };
});

/**
 * customer list directive
 */
app.directive('customerListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                ngModel: '=ngModel',
                required: '@required',
                ngChange: '&',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            template: '<ui-select theme="select2"\
                                    style="width: 100%;"\
                                    reset-search-input="false"\
                                    data-ng-model="vm.localSelected"\
                                    data-ng-change="ngChange()"\
                                    name="user"\
                                    required>\
                            <ui-select-match placeholder="Search User">\
                                {{$select.selected.company_name}}\
                            </ui-select-match>\
                            <ui-select-choices repeat="u.id as u in vm.customerList"\
                                                refresh="vm.bindCustomerList($select.search)"\
                                                refresh-delay="0">\
                                <div data-ng-bind-html="u.company_name | highlight: $select.search"></div>\
                            </ui-select-choices>\
                        </ui-select>\
            ',
            controller: 'customerListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);
/**
 * controller for customer list drop down
 */
app.controller('customerListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;
        vm.localSelected = $scope.ngModel ? $scope.ngModel : '';
        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.ngModel != newValue) {
                $scope.ngModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('ngModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });
        vm.customerList = [];
        vm.bindCustomerList = function (filterText) {
            var params = {type:'agency', search_name: filterText, status: 1};
            return Restful.get("api/Customer", params).success(function(data){
				vm.customerList = data.elements;
				console.log(data);
			});
        }
    }
]);



/**
 * categories list directive
 */
app.directive('categoriesListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                ngModel: '=ngModel',
                required: '@required',
                ngChange: '&',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            template: '<ui-select theme="select2"\
                                    style="width: 100%;"\
                                    reset-search-input="false"\
                                    data-ng-model="vm.localSelected"\
                                    data-ng-change="ngChange()"\
                                    name="user"\
                                    required>\
                            <ui-select-match placeholder="Search Categories">\
                                {{$select.selected.detail[0].categories_name}}\
                            </ui-select-match>\
                            <ui-select-choices repeat="u.categories_id as u in vm.categoryList.elements | filter: $select.search"\
                                                refresh-delay="0">\
                                <div data-ng-bind-html="u.detail[0].categories_name | highlight: $select.search"></div>\
                            </ui-select-choices>\
                        </ui-select>\
            ',
            controller: 'categoriesListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);
/**
 * controller for customer list drop down
 */
app.controller('categoriesListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;
        vm.localSelected = $scope.ngModel ? $scope.ngModel : '';
        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.ngModel != newValue) {
                $scope.ngModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('ngModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });
        vm.categoryList = [];
        vm.bindCategoriesList = function (filterText) {
            var params = {type:'agency', search_name: filterText, status: 1};
            return Restful.get("api/Category").success(function(data){
                vm.categoryList = data;
			});
        };
        vm.bindCategoriesList();
    }
]);