<?php
/*
Plugin Name: My Related Posts
Description: This plugin adds a shortcode for displaying related posts for the current post.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

define('SHORTCODE_TAG', 'related_posts');
require("My_Related_Posts_Widget.php");

function mrp_widget_init() {
	register_widget('My_Related_Posts_Widget');
}
add_action('widgets_init', 'mrp_widget_init');

function mrp_init() {
	if (!shortcode_exists(SHORTCODE_TAG)) {
		add_shortcode(SHORTCODE_TAG, 'mrp_related_posts_shortcode');
	}
}
add_action('init', 'mrp_init');

// function that runs when shortcode [related_posts] is encountered
function mrp_related_posts_shortcode($user_atts) {
	$output = "<h2>Related Posts</h2>";
	$output .= mrp_get_related_posts($user_atts);

	return $output;
}

// get related posts and return an unordered html-list
function mrp_get_related_posts($user_atts = []) {
	// initialize output variable
	$output = "";

	// get current post and current post's categories
	$post = get_queried_object(); // have to use get_queried_object instead of get_post as a widget is _outside_ of the main loop
	$categories = get_the_category($post->ID);

	// get categories from current post
	$category_ids = [];
	foreach ($categories as $category) {
		$category_ids[] = $category->term_id;
	}

	// set default attribute categories to false so we can check if it has been changed
	$default_atts = [
		'categories' => false,
	];

	// merge any attributes the user has specified with our default attributes
	$atts = shortcode_atts($default_atts, $user_atts, SHORTCODE_TAG);

	// if the attribute categories isn't false-y here (since it can be an empty string from our widget), we know the user has specified the attribute
	if ($atts['categories'] != false) {
		// split string in $atts['categories'] on "," character to an array
		$category_ids = explode(',', $atts['categories']);
	}

	// output category ids to get posts from for debugging
	//$output .= "<pre>category_ids = " . print_r($category_ids, true) . "</pre>";

	// get posts related to the current post
	$related_posts = new WP_Query([
		'category__in' => $category_ids, // array
		'post__not_in' => [$post->ID],
		'posts_per_page' => 3,
	]);

	// did we get any posts at all back?
	if ($related_posts->have_posts()) {
		// yey, lots of posts
		$output .= "<ul>";
		while ($related_posts->have_posts()) {
			// get next post from list of posts
			$related_posts->the_post();

			// get post title and link
			$post_title = get_the_title();
			$post_url = get_the_permalink();

			// append link to related post to output
			$output .= "<li><a href='{$post_url}'>{$post_title}</a></li>";
		}
		$output .= "</ul>";
	} else {
		// nope, no posts
		$output .= "Sorry, no related posts found.";
	}

	return $output;
}
