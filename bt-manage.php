<?php
	require_once("lib/sqlite/sqlite.class.php");
	$buttons = new sqlite(dirname(__FILE__) . "/data/sbc.sqlite", "buttons");
	if ($_GET['method'] == "post" && isset($_POST['button_id']) && !isset($_GET['id'])):
		$id = $_POST['button_id'];
		$name = $_POST['bt_name'];
		if ($buttons->count_rows("setting='bt_name' AND value='{$name}'") != 0):
			die("The name '{$name}' already exists. Please enter an unique name.");
		endif;
		foreach ($_POST as $field=>$value):
			$buttons->update_option($field, $value, $id);
		endforeach;
		echo "New button added. Continue add another button or <a href='?page=simple-buttons'>view all buttons</a>";
	elseif ($_GET['method'] == "edit" && isset($_GET['id'])):
		require_once("pages/new.php");
	elseif ($_GET["method"] == "post" && isset($_GET['id'])):
		$id = $_GET['id'];
		foreach ($_POST as $field=>$value):
			$buttons->update_option($field, $value, $id);
		endforeach;
		echo "Button '{$_POST['bt_name']}' saved. Continue edit this button or <a href='?page=simple-buttons'>view all buttons</a>";
	elseif ($_GET['method'] == "delete" && isset($_GET['id'])):
		$id = $_GET['id'];
	?>
		<h2>Delete button "<?php echo $buttons->get_option("bt_name", "", $id); ?>"?</h2>
		<div style="padding:<?php echo $buttons->get_option("bt_font_size", "12", $id); ?>px 0;"><a
			href="<?php echo $buttons->get_option("bt_link", "", $id); ?>"
			style="padding:10px;text-decoration:none;<?php echo $buttons->get_option("bt_css", "", $id); ?>"
		>
			<?php echo $buttons->get_option("bt_text", "button", $id); ?>
		</a></div>
		<form method="post" action="?page=simple-buttons">
			<input type="hidden" name="method" value="delete" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="submit" value="Yes" class="button button-primary" />
			<a href="?page=simple-buttons" class="button">No</a>
		</form>
	<?php endif; ?>