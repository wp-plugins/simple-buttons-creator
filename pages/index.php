<?php
	$buttons = new sqlite(dirname(dirname(__FILE__)) . "/data/sbc.sqlite", "buttons");
	if (isset($_POST['method']) && $_POST['method'] == "delete" && isset($_POST['id'])):
		$buttons->remove_option("", $_POST['id']);
	endif;
	$buttonsCount = $buttons->count_rows("setting='bt_name'");
	$id = $buttons->show_id("bt_name");

		// Initialize the fields value
	$fields = array("name", "css", "fontsize", "text", "link");
	foreach ($fields as $field):
		$$field = '';
	endforeach;

	for ($j = 0; $j < $buttonsCount; $j++):
		$i = $id[$j];
		$name[] = $buttons->get_option("bt_name", "", $i);
		$css[] = $buttons->get_option("bt_css", "", $i);
		$fontsize[] = $buttons->get_option("bt_font_size", "", $i);
		$empty_text = $buttons->get_option("bt_text", "", $i);
		$text[] =  (empty($empty_text)) ? "button" : $buttons->get_option("bt_text", "", $i);
		$link[] = $buttons->get_option("bt_link", "", $i);
	endfor;
?>
<div class="wrap">
	<h2>
		Buttons
		<a href="?page=sbc-new" class="add-new-h2">Add new</a>
	</h2>
	<table class="wp-list-table widefat">
		<tr>
			<th>Name</th>
			<th>Preview</th>
			<th>Manage</th>
		</tr>
		<?php if (!is_array($name) || sizeof($name) == 0): ?>
			<tr>
				<td colspan='3'>No button has been created.</td>
			</tr>
		<?php
		else:
			for ($i = 0; $i < sizeof($name); $i++):
		?>
				<tr>
					<td><?php echo $name[$i]; ?></td>
					<td style="font-size:<?php echo $fontsize[$i]; ?>px"><a style="padding:10px;<?php echo $css[$i]; ?>" href="<?php echo $link[$i]; ?>"><?php echo $text[$i]; ?></a></td>
					<td>
						<a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&method=edit&id=<?php echo $id[$i]; ?>">Edit</a>
						|
						<a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&method=delete&id=<?php echo $id[$i]; ?>">Delete</a>
					</td>
				</tr>
		<?php
			endfor;
		endif;
		?>
	</table>
	<div class="manage"></div>
</div>