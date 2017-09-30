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
		var url = "api/CV/";
		vm.model = null;
		// init setting
		vm.initSetting = function(){
			if($state.current.name == 'cv.edit'){
				vm.model = {};
				Restful.get(url + $stateParams.id).success(function(data){
					console.log(data);
					var model = data.elements[0];
					vm.id = model.id;
					vm.model.country = model.country_id;
					vm.model.id = model.customer_id;
					vm.model.customers_address = model.present_address;
					vm.model.customers_telephone = model.phone_number;
					vm.model.customers_email_address = model.email;
					vm.apply_for = model.apply_for;
					vm.model.company_name = model.full_name;
					vm.function = model.function;
					vm.salary_expected = model.salary_expected;
					vm.model.cover_summary = model.summary;
					vm.model.customers_gender = model.gender;
					vm.model.customers_dob = model.dob;
					vm.model.nationality = model.nationality;
					vm.model.religion = model.religion;
					vm.model.health = model.health;
					vm.model.marital_status = model.marital_status;
					vm.model.state_city = model.state_city;
					vm.model.working_history = model.working_history;
					vm.model.experience = model.experience;
					vm.prefer_location = model.prefer_location;
					vm.cover_summary = model.cover_letter_summary;
					vm.model.summary = model.summary;
					vm.model.photo = model.photo;
					vm.model.skill_title = model.current_position;
					vm.model.country_id = model.country_id;
				});
			}
			Restful.get("api/Country").success(function(data){
				vm.countries = data.elements;
			});
			Restful.get("api/Location").success(function(data){
				vm.locations = data.elements;
			});
			Restful.get("api/Category").success(function(data){
				vm.categoryList = data;
			});
		};
		vm.initSetting();
		// save functionality
		vm.save = function(){
			// set object to save into news
			var data = {
				present_address: vm.model.customers_address,
				phone_number: vm.model.customers_telephone,
				email: vm.model.customers_email_address,
				apply_for: vm.apply_for,
				function: vm.function,
				salary_expected: vm.salary_expected,
				current_position: vm.model.skill_title,
				cover_letter_summary: vm.cover_summary,
				full_name: vm.model.company_name,
				gender: vm.model.customers_gender,
				dob: vm.model.customers_dob,
				nationality: vm.model.nationality,
				religion: vm.model.religion,
				health: vm.model.health,
				marital_status: vm.model.marital_status,
				country_id: vm.model.country_id,
				state_city: vm.model.state_city,
				working_history: vm.model.working_history,
				experience: vm.model.experience,
				prefer_location: vm.prefer_location,
				summary: vm.model.summary,
				photo: vm.model.photo,
				customer_id: vm.model.id
			};
			vm.disabled = true;
			if(vm.id){
				Restful.put(url + $stateParams.id, data).success(function (data) {
					vm.disabled = false;
					vm.service.alertMessage('<b>Complete: </b>Update Success.');
					$state.go('cv');
					console.log(data);
				});
			}else{
				Restful.post(url, data).success(function (data) {
					vm.disabled = false;
					vm.service.alertMessage('<b>Complete: </b>Save Success.');
					$state.go('cv');
					console.log(data);
				});
			}
		};
	}
]);