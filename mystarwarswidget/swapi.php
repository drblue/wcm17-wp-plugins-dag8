<?php

function swapi_films() {
	$response = wp_remote_get('https://swapi.co/api/films/');
	$output = "";

	if ($response['response']['code'] === 200) {
		// all ok
		$body = json_decode($response['body']);

		$output .= "<ul>";

		/**
		 * sort films based on episode_id
		 */
		$films = $body->results;
		$episodes = array_map(function($film) {
			return $film->episode_id;
		}, $films);

		array_multisort($episodes, SORT_NUMERIC, $films);

		// loop through all results
		foreach ($films as $film) {
			$output .= "<li>{$film->title} <i>{$film->release_date}</i></li>";
		}
		$output .= "</ul>";

	} else {
		$output .= "Something went very wrong, didn't get OK back from query.";
	}

	return $output;
}

function swapi_people() {
	$response = wp_remote_get('https://swapi.co/api/people/');
	$output = "";

	if ($response['response']['code'] === 200) {
		// all ok
		$body = json_decode($response['body']);

		$output .= "<ul>";
		// loop through all results
		foreach ($body->results as $person) {
			$output .= "<li>{$person->name} <i>{$person->birth_year}</i></li>";
		}
		$output .= "</ul>";

	} else {
		$output .= "Something went very wrong, didn't get OK back from query.";
	}

	return $output;
}
