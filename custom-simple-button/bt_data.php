<?php
	require_once("sqlite.class.php");
	$db = new sqlite("simple_button");
		// Store the POST value for each form field to a variable
	$fields = array("bt_button"=>"", "bt_bg_color"=>"", "bt_txt_color"=>"", "bt_font_size"=>"", "bt_bold"=>"", "bt_italic"=>"",  "bt_border_radius"=>"", "bt_text"=>"", "bt_link"=>"", "bt_css"=>"");
	$data = array();
	foreach ($fields as $field=>$empty):
		foreach ($_POST as $variable=>$value):
			if ($field == $variable):
				$data[$variable] = $value;
			endif;
		endforeach;
	endforeach;
				
	$db->update_option($data, "bt_button='" . $data['bt_button'] . "'");
	
	echo "<div id='message' class='updated'>Successfully saved!</div>";
?>