<?php
/*
Plugin Name: My Weather Widget
Description: This plugin adds a widget for displaying todays weather for a user specified location.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

require(plugin_dir_path(__FILE__) . '/openweathermap.php');
require(plugin_dir_path(__FILE__) . '/My_Weather_Widget.php');

function mww_widget_init() {
	register_widget('My_Weather_Widget');
}
add_action('widgets_init', 'mww_widget_init');
