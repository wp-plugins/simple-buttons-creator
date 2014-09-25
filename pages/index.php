<?php
	$buttons = ["Button Name 1", "Button Name 2"];
?>
<div class="wrap">
	<h2>
		Premade Buttons
		<a href="?page=sbc-new" class="add-new-h2">Add new</a>
	</h2>
	<table class="wp-list-table widefat">
		<tr>
			<th>Name</th>
			<th>Preview</th>
			<th>Manage</th>
		</tr>
		<?php foreach ($buttons as $button): ?>
			<?php 
				$id = str_replace(" ", "_", $button);
			?>
			<tr>
				<td><label for="<?php echo $id; ?>"><?php echo $button; ?></label></td>
				<td><a href="#">Button</a></td>
				<td>
					<a href="#">Edit</a>
					|
					<a href="#">Delete</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="manage"></div>
</div>