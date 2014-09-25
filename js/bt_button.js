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
				  bt_css = $(".bt_css").html();
			$.each(bt_style, function(pro, val) {
				if (bt_css.search(pro) != -1) {	// Replace the style value if specified style already exists in the bt_css textbox instead of adding another style property
					var styles = bt_css.split("\n");
					for (var i = 0; i < styles.length; ++i) {
						var pnv = styles[i].split(": ");
						if (pnv[0] == pro) {
							pnv[1] = val + "; ";
							styles[i] = pnv.join(": ");
						}
					}
					bt_css = styles.join("\n");
				} else {
					bt_css += pro + ": " + val + ";\n";
				}
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
		},
		validateNum: function(inputField) {
			var notNum = $(inputField).parent().parent().next(".notNum");
			if ($.isNumeric($(inputField).val()) == false) {
				notNum.css({"display": "block", "font-weight": "bold"}).addClass("error");
			} else {
				notNum.css("display", "none");
			}
		}
	};

	bt_button.showHide(".basic_section_bt", ".bt_basic_settings");	
	bt_button.showHide(".advanced_section_bt", ".advanced_section");
				
	bt_button.changeColor(".bt_bg_color", "background-color");
	bt_button.changeColor(".bt_txt_color", "color");
	
	bt_button.changeStyle(".bt_bold", "font-weight", "bold", "normal");
	bt_button.changeStyle(".bt_italic", "font-style", "italic", "normal");
	
		// This function is executed when the font size text field changes
	$(".bt_font_size").on("input", function() {
		$(".bt_button a").css("font-size", $(this).val() + "px");	// Font-size property is applied to the preview area
		$(".bt_button").css("height", parseInt($(this).val()) + 20 +  "px");	// Add an additional 20px height to the current font size to properly display the updated button in the preview area
		$(".bt_button").css("margin-top", $(this).val() + "px");	// Add margin-top to the preview area in order to contain the updated button inside the preview area
		bt_button.validateNum(".bt_font_size");
		bt_button.outputStyle();
	});
	
		// This function is executed when the border radius text field for the button changes
	$(".bt_border_radius").on("input", function() {
		$(".bt_button a").css("border-radius", $(this).val() + "px");	// Make sure to change the background color for the preview button to other than white to preview the changes
		bt_button.validateNum(".bt_border_radius");
		bt_button.outputStyle();
	});
	
		// This function is executed when the button text field changes
	$(".bt_text").on("input", function() {
		$(".bt_button a").html($(this).val());	// Change the text of the button in the preview area
	});
		
		// This function is executed when the CSS code in the textarea changes
	$(".bt_css").on("input", function() {
		$(".bt_button a").attr("style", $(this).val());		// Apply the CSS code in textarea to the preview button as in-line style
	});
	
	$(".bt_button_form").submit(function(e) {
		e.preventDefault();
		var required = ["bt_name"],
			  requiredFields = ["Name"],
			  error = "";
		for (i=0; i < required.length; ++i) {
			if ($("." + required[i]).val() === "") {
				error += requiredFields[i] + " field is required.<br />";
			}
		}
		if (error === "") {
			$.post(currentPath + "/bt-manage.php" + window.location.search + "&method=post", $(this).serialize(), function(data) {
				
				if (data.search("unique") != -1)
					$(".bt_status").removeClass("updated").addClass("error").html(data);
				else
					$(".bt_status").removeClass("error").addClass("updated").html(data);
				
				if (data.search("added") != -1)
					$(".button_id").val(parseInt($(".button_id").val()) + 1);
			});
		} else {
			$(".bt_status").removeClass("updated").addClass("error").html(error);
		}
		$(window).scrollTop(0);
	});

});