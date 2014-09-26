<?php
	require_once("lib/sqlite/sqlite.class.php");
	if (isset($_GET['id'])):
		$buttons = new sqlite($_SERVER['DOCUMENT_ROOT'] . "/wp-content/data", "sbc", "buttons");
		$id = $_GET['id'];
?>
		<div
			style="padding: <?php echo $buttons->get_option("bt_font_size", "10", $id); ?>px"
		>
			<a
				href="<?php echo $buttons->get_option("bt_link", "#", $id); ?>"
				style="padding:10px;<?php echo $buttons->get_option("bt_css", "", $id); ?> "
			>
				<?php echo $buttons->get_option("bt_text", "button", $id); ?>
			</a>
		</div>
<?php
	endif;
?>