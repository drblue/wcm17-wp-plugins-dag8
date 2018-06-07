function miww_get_todays_forecast(widget_id, city, country) {
	var $ = jQuery;
	console.log("Will get miww_get_todays_forecast for " + city + ", " + country);

	$.post(
		miww_ajax_obj.ajax_url, // url to post to ('http://plugins.test/wp-admin/admin-ajax.php')
		{
			action: 'miww_get_todays_forecast',
			city: city,
			country: country,
		}
	)
	.done(function (data) {
		// do something when we get data successfully back from miww
		console.log('miww_get_todays_forecast got data back for ' + city + ', ' + country, data);

		// add data to .miww_todays_forecast
		$('#' + widget_id + ' .miww_todays_forecast').html(data);
	})
	.fail(function (error) {
		// do some error handling when we fail to get data from miww
		console.error('miww_get_todays_forecast error', error);
	});
}

jQuery(document).ready(function($) {
	console.log("This is miww-script.js being loaded");
});
