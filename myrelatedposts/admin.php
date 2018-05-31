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
