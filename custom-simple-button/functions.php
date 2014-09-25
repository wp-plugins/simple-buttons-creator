<?php
	require_once("buttonStyles.php");
		
	function bt_widgets_init(){
		register_widget( 'bt_button' );
	}
	
	function bt_button_scripts() {
		wp_enqueue_style("bt_button", plugins_url("bt_button.css", __FILE__));
		wp_enqueue_script("bt_button", plugins_url("bt_button.js", __FILE__), array("jquery", "wp-color-picker"));
	}
	
	function bt_button_style() {
		wp_enqueue_style("bt_button", plugins_url("bt_button.css", __FILE__));
	}
?>