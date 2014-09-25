<?php
/*
Plugin Name: Custom Simple Button
Plugin URI: http://blog.robbychen.com/
Description: Design and create a simple button in a widget
Author: Robby Chen
Author URI: http://blog.robbychen.com/
Version: 1.0
License: GPLv2
*/

/* Includes all the functions for this plugin */
require_once("functions.php");

/* Includes classes used for the plugin */
require_once("sqlite.class.php");

/* This section includes all the add_action hooks for this plugin  */
add_action("widgets_init", "bt_widgets_init");
add_action("admin_enqueue_scripts", "bt_button_scripts");
add_action("wp_enqueue_scripts", "bt_button_style");
?>