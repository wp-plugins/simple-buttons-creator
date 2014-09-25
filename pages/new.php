<?php
	function bt_preview() {
?>
			<!-- Button preview area -->
		<div class="bt_button">
			<a href='#'>Button</a>
		</div>
<?php
	}

	$buttons = new sqlite("sbc", "buttons");
	$num_buttons = $buttons->count_rows("setting='bt_css'");
	$buttonNum = $num_buttons + 1;	// Assign the new button a number by increment of 1 from the total number of buttons currently in the database
	$fields = array("bt_bg_color", "bt_txt_color", "bt_font_size", "bt_bold", "bt_italic",  "bt_border_radius", "bt_text", "bt_link", "bt_css");	// Set the predefined fields array to get data from the database later
?>
<div class="wrap">	
<h2>New Button</h2>
			<!-- Setting up button area -->		
<form class="bt_button_form">

		<input type="hidden" name="button_id" value="<?php echo $buttonNum; ?>" />

		<div class="bt_general">	
			<p class="general_section_bt"><a>General Settings</a></p>
			<div class="bt_general_section">
				<p>
					<label>Name: <input type="text" name="bt_name" class="bt_name" placeholder="An unique name for the new button" /></label>
				</p>
				<p>
					<label>Button text: <input type="text" name="bt_text" class="bt_text" /></label>
				</p>
				<p>
					<label>Link target (note that the link can't be previewed in the Preview Areas): <input type="text" name="bt_link" class="bt_link" placeholder="http://" /></label>
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
						<input type="text" name="bt_bg_color" class="bt_bg_color" data-default-color="#FFF" /></label>
					</p>
					<p>
						<label>Text color: <br />
						<input type='text' name="bt_txt_color" class='bt_txt_color' data-default-color="#FFF" /></label>
					</p>
				</div>
				
				<!-- TODO: If possible, add the style settings for the button hover state here -->
				
				<hr /> <!-- Separate button colors properties -->
								
					<!-- General style settings for the button, such as bold, italic, button text, etc -->
				<div class="bt_link">
					<p>
						<label>Font size: <input type="number" name="bt_font_size" class="bt_font_size" placeholder="Please enter a number" /></label>
						<div class='notNum'>Please enter a number.</div>
					</p>
					<p>
						<label><input type="checkbox" class="bt_bold" name="bt_bold" value="bold" /> Bold</label> |
						<label><input type="checkbox" class="bt_italic" name="bt_italic" value="italic" /> Italic</label>
					</p>
					<p>
						<label>Border radius: <input type="number" name="bt_border_radius" class="bt_border_radius" placeholder="Please enter a number" /></label>
						<div class="notNum">Please enter a number.</div>
					</p>
				</div>
				
			</div> <!-- .bt_basic_settings -->					
		</div> <!-- .bt_basics -->
		
		<div class="advanced_settings_bt">
		
			<p class="advanced_section_bt"><a>CSS code (Advanced)</a></p>
			
			<div class="advanced_section bt_section">
							
				<label>The above settings have been closed. The code will not be updated (by updating the values in the above Basic Settings) once custom CSS has been added. <br /><br /><textarea rows="10" class="bt_css" name="bt_css" placeholder="CSS code goes here"></textarea></label>

			</div>	<!-- .advanced_section -->
		</div> <!-- .advanced_settings_bt -->
		
		<p class="bt_save">
			<input type="submit" class="button button-primary" value="Add" name="add" />
		</p>
		
			<!-- Output the status for saving into the database -->
		<div class="bt_status"></div>
		
					
	<!-- TODO: Add a list of saved button styles here -->
	
</form>
<?php bt_preview(); ?>
</div>
