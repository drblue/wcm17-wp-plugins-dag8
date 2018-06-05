<?php
/*
Plugin Name: My Improved Weather Widget
Description: This plugin adds a widget for displaying todays weather for a user specified location.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

require(plugin_dir_path(__FILE__) . '/openweathermap.php');
require(plugin_dir_path(__FILE__) . '/class-My_Improved_Weather_Widget.php');

function miww_widget_init() {
	register_widget('My_Improved_Weather_Widget');
}
add_action('widgets_init', 'miww_widget_init');

function miww_enqueue_scripts() {
	wp_enqueue_script('miww-script', plugin_dir_url(__FILE__) . 'assets/js/miww-script.js', ['jquery'], '0.1', true);

	wp_localize_script('miww-script', 'miww_ajax_obj', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'miww_enqueue_scripts');

function miww_ajax_get_todays_forecast() {
	// get forecast for Lund
	echo owm_todays_forecast('Lund', 'SE');

	// screw this guys, I'm going höme
	wp_die();
}
add_action('wp_ajax_miww_get_todays_forecast', 'miww_ajax_get_todays_forecast');
add_action('wp_ajax_nopriv_miww_get_todays_forecast', 'miww_ajax_get_todays_forecast');
