<?php
/*
Plugin Name: My Related Posts
Description: This plugin adds a shortcode for displaying related posts for the current post.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

define('SHORTCODE_TAG', 'related_posts');

function mrp_init() {
	if (!shortcode_exists(SHORTCODE_TAG)) {
		add_shortcode(SHORTCODE_TAG, 'mrp_related_posts_shortcode');
	}
}
add_action('init', 'mrp_init');

function mrp_related_posts_shortcode($user_atts) {
	// initialize output variable
	$output = "";

	// get current post and current post's categories
	$post = get_post();
	$categories = get_the_category();

	$category_ids = [];
	foreach ($categories as $category) {
		$category_ids[] = $category->term_id;
	}

	$default_atts = [
		'categories' => false,
	];
	$atts = shortcode_atts($default_atts, $user_atts, SHORTCODE_TAG);
	if ($atts['categories'] !== false) {
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
	}

	return $output;
}
