<?php

class sbc_widget extends WP_Widget {
	private $data;
	private $num_buttons;
	function __construct() {
		parent::__construct(
			'bt-button',
			__( 'Custom Simple Buttons', 'bc-button' ),	// The name of the plugin and its slug
			array(
				'description' => __( 'Design and create a simple button', 'bc-button' ),	// The description of the plugin
			)
		);
		$this->data = new sqlite("simple_button", "", "button","bt_button_id char(255), bt_bg_color char(255), bt_txt_color char(255), bt_font_size int, bt_bold char(255), bt_italic char(255),  bt_border_radius int, bt_text char(255), bt_link char(255), bt_css txt");
		add_action("admin_head", array($this, "variables"));
	}
	
		// variables() function provides Wordpress related variables to JavaScript
	function variables() {
?>
		<script type="text/javascript">
			var path = "<?php echo plugin_dir_url(__FILE__); ?>";
		</script>
<?php
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		$this->preview();
		echo $args['after_widget'];
	}

	function update($new, $old){
			// This is intentionally left blank in case need to use the core WordPress database
		return $new;
	}
	
		// Output the  preview button 
	function preview() {
		$id ="bt_button_id='" . $this->num_buttons . "';";

		$css = $this->data->get_option("bt_css", $id);	// Get CSS information from database in order to initialize the preview area from the database if available
		$fontSize = $this->data->get_option("bt_font_size", $id);	// Initialize the fontsize veriable in order to preset the style for the preview button's parent element
		$height = $fontSize + 20;	// Height for the parent element
		$text = $this->data->get_option("bt_text", $id, "Button");	// Set the text for the preview button
		$link = $this->data->get_option("bt_link", $id, "#");
		$preset = ($fontSize != "") ? "height: {$height}px; margin-top:{$fontSize}px" : "";
?>
			<!-- Button preview area -->
		<div class="bt_button" style="<?php echo $preset; ?>">
			<a href='<?php echo $link; ?>' style="<?php echo $css; ?>"><?php echo $text; ?></a>
		</div>
<?php
	}
		
		// Output the settings for the widget to the corresponding widget in the widgets section in the admin

	function form( $instance ) {
		$id ="bt_button_id='" . $this->num_buttons . "';";
		$fields = array("bt_bg_color", "bt_txt_color", "bt_font_size", "bt_bold", "bt_italic",  "bt_border_radius", "bt_text", "bt_link", "bt_css");	// Set the predefined fields array to get data from the database later
		foreach ($fields as $field):
			$$field = $this->data->get_option($field, $id);
		endforeach;
		
			// Set the wrapper tag depending on the current page
		if (strstr($_SERVER['REQUEST_URI'], "widget")):
			$wrapper = "div";
		else:
			$wrapper = "form";
		endif;
		
		var_dump($_POST);
?>

<b>Note:</b> Please refresh the browser if this widget was just added for it to work correctly.

			<!-- This feature will be hidden until the next release -->
		<!-- <div class="saved_bt_section">
			<p class="saved_bt_title"><a>Saved Buttons</a></p>
			<div class="saved_bt bt_section"></div>
		</div> -->
		
			<!-- Setting up button area -->		
		<<?php echo $wrapper; ?> class="bt_button_form">
										
				<div class="bt_basics">

					<p class="basic_section_bt"><a>Basic Settings</a></p>
					
					<div class="bt_basic_settings bt_section">
					
						<?php $this->preview(); ?>
					
							<!-- The style settings for the button default state -->
						<div class="bt_active">
							<p>
								<label>Background color: <br />
								<input type="text" name="bt_bg_color" class="bt_bg_color" data-default-color="#FFF" value="<?php echo $bt_bg_color; ?>" /></label>
							</p>
							<p>
								<label>Text color: <br />
								<input type='text' name="bt_txt_color" class='bt_txt_color' data-default-color="#FFF" value="<?php echo $bt_txt_color; ?>" /></label>
							</p>
						</div>
						
						<!-- TODO: If possible, add the style settings for the button hover state here -->
						
						<hr /> <!-- Separate button colors properties -->
						
						<?php $this->preview(); ?>
						
							<!-- General style settings for the button, such as bold, italic, button text, etc -->
						<div class="bt_link">
							<p>
								<label>Font size: <input type="number" name="bt_font_size" class="bt_font_size" value="<?php echo $bt_font_size; ?>" placeholder="Please enter a number" /></label>
							</p>
							<p>
								<label><input type="checkbox" class="bt_bold" name="bt_bold" value="bold" <?php echo (empty($bt_bold)) ? "" : "checked"; ?> /> Bold</label> |
								<label><input type="checkbox" class="bt_italic" name="bt_italic" value="italic" <?php echo (empty($bt_italic)) ? "" : "checked"; ?> /> Italic</label>
							</p>
							<p>
								<label>Border radius: <input type="number" name="bt_border_radius" class="bt_border_radius" value="<?php echo $bt_border_radius; ?>" placeholder="Please enter a number" /></label>
							</p>
							
							<hr /> <!-- Separate button styles proproties -->
							
							<?php $this->preview(); ?>
							
							<p>
								<label>Button text: <input type="text" name="bt_text" class="bt_text" value="<?php echo $bt_text; ?>" /></label>
							</p>
							<p>
								<label>Link target (note that the link can't be previewed in the Preview Areas): <input type="text" name="bt_link" class="bt_link" placeholder="http://" value="<?php echo $bt_link; ?>" /></label>
							</p>
						</div>
						
					</div> <!-- .bt_basic_settings -->					
				</div> <!-- .bt_basics -->
				
				<div class="advanced_settings_bt">
				
					<p class="advanced_section_bt"><a>CSS code (Advanced)</a></p>
					
					<div class="advanced_section bt_section">
					
						<?php $this->preview(); ?>
						
						<label>The above settings have been closed. The code will not be updated (by updating the values in the above settings) once custom CSS has been added. <br /><br /><textarea rows="10" class="bt_css" name="bt_css" placeholder="CSS code goes here"><?php echo $bt_css; ?></textarea></label>

					</div>	<!-- .advanced_section -->
				</div> <!-- .advanced_settings_bt -->
				
				<p class="bt_save">
					<input type="submit" class="button button-primary" value="Save" name="save" />
				</p>
				
					<!-- Output the status for saving into the database -->
				<p class="bt_status"></p>
				
							
			<!-- TODO: Add a list of saved button styles here -->
			
		</<?php echo $wrapper; ?>>
<?php
	}
}
?>
