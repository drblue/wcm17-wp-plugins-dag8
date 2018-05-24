<?php
/*
Plugin Name: My First Plugin
Description: This is my first plugin. It currently adds [show_latest_posts] shortcode to show the three latest posts. Very fancy.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

function mfp_init() {
	function mfp_show_latest_posts_shortcode($user_atts) {
		$default_atts = [
			'posts' => 3,
			'title' => 'Latest posts',
		];
		$atts = shortcode_atts($default_atts, $user_atts, 'show_latest_posts');
		/*
			$atts = [
				'posts' => 5,
				'title' => 'Senaste inlägg',
			];
		*/

		$latest_posts = new WP_Query([
			'posts_per_page' => $atts['posts'],
		]);

		$output = "<h2>{$atts['title']}</h2>";
		// $output = "<h2>" . $atts['title'] . "</h2>";	// identiskt med ovan rad men lättare att göra fel med alla punkter och fnuttar

		if ($latest_posts->have_posts()) {
			$output .= "<ul>";
			while ($latest_posts->have_posts()) {
				$latest_posts->the_post();
				$post_title = get_the_title();
				$post_url = get_the_permalink();
				$output .= "<li><a href='{$post_url}'>{$post_title}</a></li>";
			}
			$output .= "</ul>";
		} else {
			$output .= "No latest posts available.";
		}
		return $output;
	}
	if (!shortcode_exists('show_latest_posts')) {
		add_shortcode('show_latest_posts', 'mfp_show_latest_posts_shortcode');
	}
}
add_action('init', 'mfp_init');
