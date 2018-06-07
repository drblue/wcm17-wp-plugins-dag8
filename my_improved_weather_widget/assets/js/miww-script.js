jQuery(document).ready(function($) {
	console.log("This is miww-script.js being loaded");

	// get every instance of this widget that exists on the current page
	var weather_widgets = $('.widget_my_improved_weather_widget');

	// loop over each widget
	$.each(weather_widgets, function(index, widget) {
		// do something with every single widget
		var todays_forecast = $(widget).find('.miww_todays_forecast');

		var widget_city = todays_forecast.data('city');
		var widget_country = todays_forecast.data('country');

		console.log("I want todays forecast for city " + widget_city + " and country " + widget_country);

		// get todays forecast
		$.post(
			miww_ajax_obj.ajax_url, // url to post to ('http://plugins.test/wp-admin/admin-ajax.php')
			{
				action: 'miww_get_todays_forecast',
				city: widget_city,
				country: widget_country,
			}
		)
		.done(function (data) {
			// do something when we get data successfully back from miww
			console.log('miww_get_todays_forecast got data back', data);

			// add data to .miww_todays_forecast
			$(widget).find('.miww_todays_forecast').html(data);
		})
		.fail(function (error) {
			// do some error handling when we fail to get data from miww
			console.error('miww_get_todays_forecast error', error);
		});

		// done

	});


});
