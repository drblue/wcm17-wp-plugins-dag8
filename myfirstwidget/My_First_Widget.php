<?php
/**
 * Adds My_First_Widget widget.
 */
class My_First_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'My_First_Widget', // Base ID
			'My First Widget', // Name
			array( 'description' => __( 'My First Widget', 'text_domain' ), ) // Args
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
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		// widget title
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// textarea
		if (!empty($instance['textarea'])) {
			?>
				<i><?php echo wpautop($instance['textarea']); ?></i>
			<?php
		}

		// button text
		if (!empty($instance['button_text']) && $instance['show_link']) {
			?>
				<a href="<?php echo $instance['button_link']; ?>" class="btn btn-primary" role="button"><?php echo $instance['button_text']; ?></a>
			<?php
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New Heading', 'text_domain' );
		}

		$textarea = (!empty($instance['textarea']) ? $instance['textarea'] : "");
		$show_link = (!empty($instance['show_link']) ? $instance['show_link'] : "");
		$button_text = (!empty($instance['button_text']) ? $instance['button_text'] : "");
		$button_link = (!empty($instance['button_link']) ? $instance['button_link'] : "");

		?>
		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>

		<!-- textarea -->
		<p>
			<label for="<?php echo $this->get_field_name( 'textarea' ); ?>">
				<?php _e( 'Textarea:' ); ?>
			</label>

			<textarea
				cols=30
				rows=8
				class="widefat"
				id="<?php echo $this->get_field_id( 'textarea' ); ?>"
				name="<?php echo $this->get_field_name( 'textarea' ); ?>"><?php echo esc_attr( $textarea ); ?></textarea>
		</p>

		<!-- show link? -->
		<p>
			<label for="<?php echo $this->get_field_name( 'show_link' ); ?>">
				<?php _e( 'Show link:' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id( 'show_link' ); ?>"
				name="<?php echo $this->get_field_name( 'show_link' ); ?>"
				type="checkbox"
				<?php if ($show_link) { ?> checked <?php } ?>
			/>
		</p>

		<!-- button text -->
		<p>
			<label for="<?php echo $this->get_field_name( 'button_text' ); ?>">
				<?php _e( 'Button text:' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id( 'button_text' ); ?>"
				name="<?php echo $this->get_field_name( 'button_text' ); ?>"
				type="text"
				value="<?php echo esc_attr( $button_text ); ?>"
			/>
		</p>

		<!-- button link -->
		<p>
			<label for="<?php echo $this->get_field_name( 'button_link' ); ?>">
				<?php _e( 'Button link:' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id( 'button_link' ); ?>"
				name="<?php echo $this->get_field_name( 'button_link' ); ?>"
				type="text"
				value="<?php echo esc_attr( $button_link ); ?>"
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
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['textarea'] = strip_tags($new_instance['textarea']);
		$instance['show_link'] = $new_instance['show_link'];
		$instance['button_text'] = strip_tags($new_instance['button_text']);
		$instance['button_link'] = strip_tags($new_instance['button_link']);

		return $instance;
	}

} // class My_First_Widget
