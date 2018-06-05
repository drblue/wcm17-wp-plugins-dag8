<?php
/**
 * Adds My_Weather_Widget widget.
 */
class My_Weather_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'My_Weather_Widget', // Base ID
			'My Weather Widget', // Name
			[
				'description' => __('My Weather Widget', 'text_domain'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$city = $instance['city'];
		$country = $instance['country'];

		// start widget
		echo $args['before_widget'];

		// widget title
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		/**
		 * get todays weather and display it
		 *
		 * @todo: get these values from this widget instance's settings
		 */
		echo owm_todays_forecast($city, $country);

		// end widget
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Current Weather', 'text_domain');
		}

		if (isset($instance['city'])) {
			$city = $instance['city'];
		} else {
			$city = __('Lund', 'text_domain');
		}

		if (isset($instance['country'])) {
			$country = $instance['country'];
		} else {
			$country = __('SE', 'text_domain');
		}

		?>

			<!-- title -->
			<p>
				<label for="<?php echo $this->get_field_name('title'); ?>">
					<?php _e('Title:'); ?>
				</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>"
					type="text"
					value="<?php echo esc_attr($title); ?>"
				/>
			</p>

			<!-- city -->
			<p>
				<label for="<?php echo $this->get_field_name('city'); ?>">
					<?php _e('City:'); ?>
				</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('city'); ?>"
					name="<?php echo $this->get_field_name('city'); ?>"
					type="text"
					value="<?php echo esc_attr($city); ?>"
				/>
			</p>

			<!-- country -->
			<p>
				<label for="<?php echo $this->get_field_name('country'); ?>">
					<?php _e('Country:'); ?>
				</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('country'); ?>"
					name="<?php echo $this->get_field_name('country'); ?>"
					type="text"
					value="<?php echo esc_attr($country); ?>"
				/>
			</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['city'] = (!empty($new_instance['city'])) ? strip_tags($new_instance['city']) : 'Lund';
		$instance['country'] = (!empty($new_instance['country'])) ? strip_tags($new_instance['country']) : 'SE';

		return $instance;
	}

} // class My_Weather_Widget
