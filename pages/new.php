<?php
	function bt_preview($css, $text, $link) {
?>
			<!-- Button preview area -->
		<div class="bt_button">
			<a href='<?php echo $link; ?>' style="<?php echo $css; ?>"><?php echo $text; ?></a>
		</div>
<?php
	}

	$buttons = new sqlite($_SERVER['DOCUMENT_ROOT'] . "/wp-content/data", "sbc", "buttons");
	$id = $buttons->show_id("bt_name");
	$num_buttons = 0;
		// Determine the biggest group_id and assign the num_buttons variables to the biggest one
	if (!empty($id)):
		foreach ($id as $buttonNum):
			if ($num_buttons < $buttonNum):
				$num_buttons = $buttonNum;
			endif;
		endforeach;
	endif;

	$buttonNum = $num_buttons + 1;	// Assign the new button a number by increment of 1 from the total number of buttons currently in the database
	$fields = array("bt_name", "bt_bg_color", "bt_txt_color", "bt_font_size", "bt_bold", "bt_italic",  "bt_border_radius", "bt_text", "bt_link", "bt_css");	// Set the predefined fields array to get data from the database later
	foreach ($fields as $field):
		if (isset($_GET["method"]) && $_GET["method"] == "edit"):
			$$field = $buttons->get_option($field, "", $_GET['id']);
			$bt_text  = $buttons->get_option("bt_text", "button", $_GET['id']);
			$buttonNum = $_GET['id'];
			$submit = "Submit";
		else:
			$$field = "";
			$bt_text = "button";
			$buttonNum = $buttonNum;
			$submit = "Add";
		endif;
	endforeach;
?>
<div class="wrap">	
<h2>
	<?php echo (isset($_GET['id'])) ? "Edit '{$bt_name}' Button" : "New Button"; ?>
	<a href="?page=simple-buttons" class="add-new-h2">View all</a>
</h2>
			<!-- Setting up button area -->		
<form class="bt_button_form">

			<!-- Output the status for saving into the database -->
		<div class="bt_status"></div>

		<input type="hidden" name="button_id" class="button_id" value="<?php echo $buttonNum; ?>" />

		<div class="bt_general">	
			<p class="general_section_bt"><a>General Settings</a></p>
			<div class="bt_general_section">
				<p>
					<label>Name: <input type="text" name="bt_name" class="bt_name" placeholder="An unique name for the new button" value="<?php echo $bt_name; ?>" <?php echo (empty($bt_name)) ? "" : "readonly"; ?> /></label>
				</p>
				<p>
					<label>Button text: <input type="text" name="bt_text" class="bt_text" value="<?php echo $bt_text; ?>" /></label>
				</p>
				<p>
					<label>Link target (note that the link can't be previewed in the Preview Areas): <input type="text" name="bt_link" class="bt_link" placeholder="http://" value="<?php echo $bt_link; ?>" /></label>
				</p>
			</div>
		</div>
								
		<div class="bt_basics">

			<p class="basic_section_bt"><a>Basic Settings</a></p>
			
			<div class="bt_basic_settings bt_section">
						
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
								
					<!-- General style settings for the button, such as bold, italic, button text, etc -->
				<div class="bt_link">
					<p>
						<label>Font size: <input type="number" name="bt_font_size" class="bt_font_size" placeholder="Please enter a number" value="<?php echo $bt_font_size; ?>" /></label>
						<div class='notNum'>Please enter a number.</div>
					</p>
					<p>
						<label><input type="checkbox" class="bt_bold" name="bt_bold" value="bold" <?php echo (empty($bt_bold)) ? "" : "checked"; ?> /> Bold</label> |
						<label><input type="checkbox" class="bt_italic" name="bt_italic" value="italic" <?php echo (empty($bt_italic)) ? "" : "checked"; ?> /> Italic</label>
					</p>
					<p>
						<label>Border radius: <input type="number" name="bt_border_radius" class="bt_border_radius" placeholder="Please enter a number" value="<?php echo $bt_border_radius; ?>" /></label>
						<div class="notNum">Please enter a number.</div>
					</p>
				</div>
				
			</div> <!-- .bt_basic_settings -->					
		</div> <!-- .bt_basics -->
		
		<div class="advanced_settings_bt">
		
			<p class="advanced_section_bt"><a>CSS code (Advanced)</a></p>
			
			<div class="advanced_section bt_section">
							
				<label>The above settings have been closed. The code will not be updated (by updating the values in the above Basic Settings) once custom CSS has been added. <br /><br /><textarea rows="10" class="bt_css" name="bt_css" placeholder="CSS code goes here"><?php echo $bt_css; ?></textarea></label>

			</div>	<!-- .advanced_section -->
		</div> <!-- .advanced_settings_bt -->
		
		<p class="bt_save">
			<input type="submit" class="button button-primary" value="<?php echo $submit; ?>" name="<?php echo $submit; ?>" />
		</p>
								
</form>
<?php bt_preview($bt_css, $bt_text, $bt_link); ?>
</div>
