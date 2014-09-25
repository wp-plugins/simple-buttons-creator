<?php
	if (isset($_POST['button_id'])):
		foreach ($_POST as $style=>$value):
			echo $style . ": " . $value . "<br />";
		endforeach;
	endif;
?>