<?php
	if (isset($_GET['name'])):
		$name = $_GET['name'];
		$name = str_replace("_", " ", $name);
	endif;
?>
<input type="button" class="editButton" value="Edit <?php  echo $name; ?>" />