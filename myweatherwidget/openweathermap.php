<?php

define('OWM_API_KEY', '5ae275d1a0023fc435486dc31a45cd67');

function owm_todays_forecast($city, $country) {
	$response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&appid=" . OWM_API_KEY);
	$output = "";

	if ($response['response']['code'] === 200) {
		// all ok
		$forecast = json_decode($response['body']);
		$output = "The temperature in {$city}, {$country} is currently {$forecast->main->temp} K.";

	} else {
		$output .= "Something went very wrong, didn't get OK back from query.";
	}

	return $output;
}
