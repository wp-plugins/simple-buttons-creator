<?php

class sbc_widget extends WP_Widget {

	var $buttons;	// Stores the SQLite database object

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$this->buttons = new sqlite($_SERVER['DOCUMENT_ROOT'] . "/wp-content/data", "sbc", "buttons");
		parent::__construct(
			'sbc_widget',
			__('Simple Buttons Creator', 'sbc_widget'),
			array( 'description' => __( 'Choose from a list of created simple buttons to be used in the widget', 'sbc_widget' ))
		);
		add_action("wp_enqueue_scripts", array($this, "widget_scripts"));
	}
	
	/**
	 * Front-end inclusion of widget styles and scripts
	 *
	 * Include any styles and scripts related to the widget
	 */
	 public function widget_scripts() {
		 wp_enqueue_style("sbc_buttons", plugins_url("css/sbc_widget.css", __FILE__));
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
    echo $args['before_widget'];
		if ( ! empty( $instance['button_select'] ) ) {
			$button = $instance['button_select'];
			$bt_css = $this->buttons->get_option("bt_css", "", $button);
			$bt_txt_color = "color: " . $this->buttons->get_option("bt_txt_color", "", $button) . " !important;";
?>
			<div class="sbc_buttons sbc_<?php echo $button; ?>">
				<a href="<?php echo $this->buttons->get_option("bt_link", "#", $button); ?>"
					 style="padding: 10px; <?php echo $bt_css . $bt_txt_color; ?>">
					<?php echo $this->buttons->get_option("bt_text", "Button", $button); ?>
				</a>
			</div>
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
		$fields = array("button_select"=>"1");
		foreach ($fields as $field=>$default):
			if (isset($instance[$field])):
				$$field = $instance[$field];
			else:
				$$field = __($default, "sbc_widget");
			endif;
		endforeach;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'buttons' ); ?>"><?php _e( 'Select a button to be displayed:', 'sbc_widget' ); ?></label> 
			<select class="widefat sbc_widget_buttons" id="<?php echo $this->get_field_id("button_select"); ?>" name="<?php echo $this->get_field_name("button_select"); ?>">
				<option>Select a button</option>
				<?php
					$button_id = $this->buttons->show_id("bt_name");
					foreach ($button_id as $button_name):
						$selected = (esc_attr($button_select) == $button_name) ? "selected" : "";
						echo "<option {$selected} value='{$button_name}'>" . $this->buttons->get_option("bt_name", "", $button_name) . "</option>";
					endforeach;
				?>
			</select>
			<div class="widefat sbc_widget_preview">
				<div style="padding: <?php echo $this->buttons->get_option("bt_font_size", "10", $button_select); ?>px">
					<a
						href="<?php echo $this->buttons->get_option("bt_link", "#", $button_select); ?>"
						style="padding:10px; <?php echo $this->buttons->get_option("bt_css", " ", $button_select); ?>">
							<?php echo $this->buttons->get_option("bt_text", "", $button_select); ?>
					</a>
				</div>
			</div>
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
		$instance['button_select'] = ( ! empty( $new_instance['button_select'] ) ) ? strip_tags( $new_instance['button_select'] ) : '';

		return $instance;
	}

}

function register_sbc_widget() {
    register_widget( 'sbc_widget' );
}

add_action("widgets_init", "register_sbc_widget");