var app = angular.module(
	'main',
	[
	 	'ui.router'
		, 'ui.bootstrap'
		, 'ngSanitize'
		, 'ui.tinymce'
		, 'ngFileUpload'
		, 'ngCookies'
		, 'ngAlertify'
		, 'moment-picker'
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


app.config(['momentPickerProvider', function (momentPickerProvider) {
	momentPickerProvider.options({
		/* Picker properties */
		locale:        'en',
		format:        'L LTS',
		minView:       'decade',
		maxView:       'minute',
		startView:     'year',
		autoclose:     true,
		today:         false,
		keyboard:      false,

		/* Extra: Views properties */
		leftArrow:     '&larr;',
		rightArrow:    '&rarr;',
		yearsFormat:   'YYYY',
		monthsFormat:  'MMM',
		daysFormat:    'D',
		hoursFormat:   'HH:[00]',
		minutesFormat: moment.localeData().longDateFormat('LT').replace(/[aA]/, ''),
		secondsFormat: 'ss',
		minutesStep:   5,
		secondsStep:   1
	});
}]);