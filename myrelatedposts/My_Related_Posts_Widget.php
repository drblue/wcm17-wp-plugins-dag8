<?php
/**
 * Adds My_Related_Posts_Widget widget.
 */
class My_Related_Posts_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'My_Related_Posts_Widget', // Base ID
			'My Related Posts Widget', // Name
			array( 'description' => __( 'My Related Posts Widget', 'text_domain' ), ) // Args
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
		// check if we are on a single post, otherwise bail
		if (!is_single() && empty($instance['categories'])) {
			return;
		}

		$title = apply_filters( 'widget_title', $instance['title'] );

		// start widget
		echo $args['before_widget'];

		// widget title
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// related posts
		echo mrp_get_related_posts(['categories' => $instance['categories']]);

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
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Related Posts', 'text_domain' );
		}

		$categories = $instance['categories'];

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

		<!-- categories -->
		<p>
			<label for="<?php echo $this->get_field_name( 'categories' ); ?>">
				<?php _e( 'Categories:' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id( 'categories' ); ?>"
				name="<?php echo $this->get_field_name( 'categories' ); ?>"
				type="text"
				value="<?php echo esc_attr( $categories ); ?>"
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
		$instance['categories'] = ( !empty( $new_instance['categories'] ) ) ? strip_tags( $new_instance['categories'] ) : '';

		return $instance;
	}

} // class My_Related_Posts_Widget
