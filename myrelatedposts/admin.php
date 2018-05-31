<?php

function mrp_options_page_html() {
	// check user capabilities
	if (!current_user_can('manage_options')) {
		return;
	}
	?>
		<div class="wrap">
			<h1><?= esc_html(get_admin_page_title()); ?></h1>

			<form action="options.php" method="post">
				<?php
				// output security fields for the registered setting "myrelatedposts_options"
				settings_fields('myrelatedposts_options');

				// output setting sections and their fields
				// (sections are registered for "myrelatedposts", each field is registered to a specific section)
				do_settings_sections('myrelatedposts');

				// output save settings button
				submit_button('Save Settings');
				?>
			</form>
		</div>
	<?php
}

function mrp_options_page() {
	add_submenu_page(
		'tools.php',					// menu slug to add submenu to
		'My Related Posts Options',		// option page title
		'My Related Posts',				// menu title
		'manage_options',				// capability required for this menu option to be accessible
		'myrelatedposts',				// slug for our options page
		'mrp_options_page_html'			// function that outputs our options
	);
}
add_action('admin_menu', 'mrp_options_page');

function mrp_admin_init() {
	add_settings_section("myrelatedposts_options", "Related Posts Settings", null, "myrelatedposts");

	add_settings_field("mrp_shortcode_title", "Default Title for [related_posts]", "mrp_options_shortcode_title", "myrelatedposts", "myrelatedposts_options");
	add_settings_field("mrp_add_to_posts", "Automatically add related posts to all blog posts?", "mrp_options_add_to_posts", "myrelatedposts", "myrelatedposts_options");

	register_setting("myrelatedposts_options", "mrp_shortcode_title");
	register_setting("myrelatedposts_options", "mrp_add_to_posts");
}
add_action('admin_init', 'mrp_admin_init');

function mrp_options_shortcode_title() {
	?>
		<input type="text" name="mrp_shortcode_title" id="mrp_shortcode_title" value="<?php echo get_option('mrp_shortcode_title'); ?>" />
	<?php
}

function mrp_options_add_to_posts() {
	?>
		<input type="checkbox" name="mrp_add_to_posts" value="1" <?php checked(1, get_option('mrp_add_to_posts'), true); ?> />
	<?php
}
