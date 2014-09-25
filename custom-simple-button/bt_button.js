jQuery(document).ready(function($) {
	
	// $(".widget-inside").css("display", "block"); //temp code
	
		// The main json object for the plugin 
	var bt_button = {
		changeColor: function(input, css) {	// This function is used to add color picker to the specified text field and output the result to the preview area
			$(input).wpColorPicker({
				defaultColor: "#FFF",
				change: function(event, ui) {
					$(".bt_button a").css(css, $(this).val());
					bt_button.outputStyle();
				}
			});
		},
		changeStyle: function(checkbox, css, hover, out) {	// This function is used to apply the checkmark fields to the preview area
			$(checkbox).on("click", function() {
				if ($(this).prop("checked") == true) {
					$(".bt_button a").css(css, hover);
				} else {
					$(".bt_button a").css(css, out);
				}
				bt_button.outputStyle();
			});
		},
			// TODO: Make sure to add additional style property to the bt_style variable if adding more styles in the future
		outputStyle: function() {	// This function outputs the CSS code for the preview button to the CSS code textbox
			var bt_style = $(".bt_button a").css(["background-color", "color", "font-weight", "font-style", "font-size", "border-radius"]),
				  bt_css = "";
			$.each(bt_style, function(pro, val) {
				bt_css += pro + ": " + val + ";\n";
			});
			$(".bt_css").html(bt_css);
		},
		showHide: function(title, content) {	// This function is used to hide the other sections and show only active section
			$(title + " a").on("click", function() {
				if ($(content).css("display") == "none") {
					$(".bt_section").slideUp();
					$(content).slideDown();
				}
			});
		}
	};

	bt_button.showHide(".saved_bt_title", ".saved_bt");
	bt_button.showHide(".basic_section_bt", ".bt_basic_settings");	
	bt_button.showHide(".advanced_section_bt", ".advanced_section");
	
		// Output bt_saved.php content to the saved_bt section
	$(".saved_bt").load(path + "bt_saved.php");
	
		// When the document is loaded, show the first two section if there is no saved button. Otherwise, just show first section
	$.get(path + "bt_saved.php", function(data) {
		if (data.toLowerCase().search("upcoming") == -1 && data != '') {
			$(".bt_basic_settings").hide();
			$(".bt_save").hide();
			
		}
	});
		
	bt_button.changeColor(".bt_bg_color", "background-color");
	bt_button.changeColor(".bt_txt_color", "color");
	
	bt_button.changeStyle(".bt_bold", "font-weight", "bold", "normal");
	bt_button.changeStyle(".bt_italic", "font-style", "italic", "normal");
	
		// This function is executed when the font size text field changes
	$(".bt_font_size").on("input", function() {
		$(".bt_button a").css("font-size", $(this).val() + "px");	// Font-size property is applied to the preview area
		$(".bt_button").css("height", parseInt($(this).val()) + 20 +  "px");	// Add an additional 20px height to the current font size to properly display the updated button in the preview area
		$(".bt_button").css("margin-top", $(this).val() + "px");	// Add margin-top to the preview area in order to contain the updated button inside the preview area
		bt_button.outputStyle();
	});
	
		// This function is executed when the border radius text field for the button changes
	$(".bt_border_radius").on("input", function() {
		$(".bt_button a").css("border-radius", $(this).val() + "px");	// Make sure to change the background color for the preview button to other than white to preview the changes
		bt_button.outputStyle();
	});
	
		// This function is executed when the button text field changes
	$(".bt_text").on("input", function() {
		$(".bt_button a").html($(this).val());	// Change the text of the button in the preview area
	});
		
		// This function iis executed when the CSS code in the textarea changes
	$(".bt_css").on("input", function() {
		$(".bt_button a").attr("style", $(this).val());		// Apply the CSS code in textarea to the preview button as in-line style
	});
		// Hides the default widget save button for this widget
	$(".widget-control-save").each(function() {
		if ($(this).attr("id").search("brasscove") != -1) {
			$(this).hide();
		}
	});
			
	$(".bt_save .button-primary").on("click", function(e) {
		var form;	// Store the form element location depending on the current page
		if (window.location.href.search("widgets") == -1) {
			form = $(this).parent().parent();
		} else {
			form = $(this).parent().parent().parent().parent();
		}
		e.preventDefault();
		$.post(path + "bt_data.php", form.serialize(), function(data) {
			$(".bt_status").html(data);
		});
	});
	
	var loaded = false;
	$(document).on("click", ".bt_bg_color", function() {
		if (loaded == false) {
			$.getScript(path + "bt_button.js");
		}
		loaded = true;
	});
	
		// Fixes the done button for the UI dialog in Page Builder
	$(".ui-dialog .ui-button:contains('done')").live("click", function() {
		$(".ui-button[title=close]").click();
	});
	
});