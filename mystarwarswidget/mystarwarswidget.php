<?php
/*
Plugin Name: My Star Wars Widget
Description: This plugin adds a widget for displaying various trivia about Star Wars.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

require(plugin_dir_path(__FILE__) . '/swapi.php');
require(plugin_dir_path(__FILE__) . '/My_Star_Wars_Widget.php');

function msw_widget_init() {
	register_widget('My_Star_Wars_Widget');
}
add_action('widgets_init', 'msw_widget_init');
