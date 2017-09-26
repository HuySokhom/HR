app.controller(
	'cv_post_ctrl', [
	'$scope'
	, 'Restful'
	, 'Services'
	, '$stateParams'
	, '$state'
	, function ($scope, Restful, Services, $stateParams, $state){
		var vm = this;
		vm.service = new Services();
		var url = "api/Session/User/PostCV/";
		
		// init setting
		vm.initSetting = function(){
			Restful.get('api/Session/Customer/').success(function(data){
				console.log(data);
				vm.model = data.elements[0];
			});
			Restful.get("api/Country").success(function(data){
				vm.countries = data.elements;
			});
			Restful.get("api/Location").success(function(data){
				vm.locations = data.elements;
			});
		};
		vm.initSetting();
		// save functionality
		vm.save = function(){
			// set object to save into news
			var data = {
				
			};
			vm.disabled = true;
			Restful.post(url, data).success(function (data) {
				vm.disabled = false;
				vm.service.alertMessage('<b>Complete: </b>Save Success.');
				$state.go('manage_cv');
				console.log(data);
			});
		};
	}
]);