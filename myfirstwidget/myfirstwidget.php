<?php
/*
Plugin Name: My First Widget
Description: This is my first widget plugin. It will probably do some very fancy stuff.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

require('My_First_Widget.php');

// Register Foo_Widget widget
function mfw_init() {
	register_widget('My_First_Widget');
}
add_action('widgets_init', 'mfw_init');
