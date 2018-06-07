<?php

define('OWM_API_KEY', '5ae275d1a0023fc435486dc31a45cd67');

function owm_todays_forecast($city, $country) {
	$response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&appid=" . OWM_API_KEY);
	$output = "";

	if (is_wp_error($response)) {
		$error_messages = [];
		foreach ($response->errors as $error) {
			$error_message = implode(', ', $error);
			array_push($error_messages, $error_message);
		}

		return "Critical error: " . implode(", ", $error_messages);
	}

	if ($response['response']['code'] === 200) {
		// all ok

		// decode forecast into php object
		$forecast = json_decode($response['body']);

		// convert temperature to celsius
		$temp = kelvin_to_celsius($forecast->main->temp);

		// round temperature to 1/10 degree
		$temp = round($temp, 1);

		// extract current weather conditions
		$current_conditions = [];
		foreach($forecast->weather as $condition) {
			array_push($current_conditions, $condition->main);
		}

		$output .= "Temperature: {$temp} C<br />";
		$output .= "Wind: {$forecast->wind->speed} m/s at {$forecast->wind->deg} degrees<br />";
		$output .= "Conditions: " . implode(" | ", $current_conditions) . "<br />";

	} else {
		if (!empty($response->body)) {
			$error = json_decode($response->body);
			if ($error->message) {
				$error_msg = $error->message;
			}
		} else {
			$error_msg = $response['response']['message'];
		}

		if (!empty($error_msg)) {
			$output .= "Something went wrong: {$error_msg}";
		} else {
			$output .= "Something went very wrong, didn't get OK back from query and unknown error occured.";
		}
	}

	return $output;
}

function kelvin_to_celsius($degrees_kelvin) {
	return $degrees_kelvin - 273.15;
}
