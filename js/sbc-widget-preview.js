jQuery(document).ready(function($) {
	$("body").on("change", ".sbc_widget_buttons", function() {
		$.getScript(currentPath + "/js/sbc-widget-preview.js");
		$.get(currentPath + "/sbc-widget-preview.php", {id: $(this).val()}, function(data) {
			$(".sbc_widget_preview").html(data);
		});
	});
	$(".widget-inside").show();
});