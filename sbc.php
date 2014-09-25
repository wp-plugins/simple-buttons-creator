<?php
/**
 * Plugin Name: Simple Buttons Creator
 * Plugin URI: @TODO: Fill this out after uploaded to the wordpress plugins repo
 * Description: A simple way to create buttons with most customizable options available. After a button is created, you can use a Simple Buttons Creator widget to display the button onto the page. This plugin has been tested with <a href="http://wordpress.org/plugins/siteorigin-panels/">Page Builder by SiteOrigin</a>.
 @TODO: Test the plugin with Page Builder by SiteOrigin once the development is done
 * Version: 1.0
 * Author: Robby Chen
 * Author URI: http://blog.robbychen.com
 @TODO: Change the Author URI to http://robbychen.com once the homepage redesign is done
 * License: GPL2
 */
 
require_once("lib/sqlite/sqlite.class.php");

class simpleButtons {

    private $options;

   public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action("admin_enqueue_scripts", array($this, "add_universal_scripts"));
        	// Load the admin scripts only within the pages for this plugin
        if (strstr($_SERVER['QUERY_STRING'], "simple-buttons") || strstr($_SERVER['QUERY_STRING'], "sbc-new")):
	        add_action("admin_enqueue_scripts", array($this, "add_admin_scripts"));
			add_action("admin_head", array($this, "js_vars"));
		endif;
		if (strstr($_SERVER['QUERY_STRING'], "sbc-new")):
			add_action("admin_enqueue_scripts", array($this, "bt_button_scripts"));
		endif;
        
        add_action("wp_enqueue_scripts", array($this, "add_universal_scripts"));
        
    }

    public function add_plugin_page() {
		add_menu_page( "Simple Buttons Creator", "Simple Buttons Creator", "manage_options", "simple-buttons", array($this, "create_admin_page"));
		add_submenu_page("simple-buttons", "Add a new button", "Add New Button", "manage_options", "sbc-new", array($this, "add_new_page"));
    }

    public function create_admin_page() {
		require_once("pages/index.php");
    }
    
    public function add_new_page() {
    	require_once("pages/new.php");
    }
    
    	// Load the following scripts in both backend and frontend
    public function add_universal_scripts() {
	    wp_enqueue_style("sbc_style", plugins_url("css/style.css", __FILE__));
    }
    
    	// Load the following scripts only in the backend
    public function add_admin_scripts() {
    	$test = exec("ping -c 1 google.com", $output);	// Test to see if it's online
	    wp_enqueue_style("sbc_admin_style", plugins_url("css/admin.css", __FILE__));
	    if ($test):
	    	wp_enqueue_script("sbc_admin_angular_js", "https://ajax.googleapis.com/ajax/libs/angularjs/1.2.23/angular.min.js", "", true);
	    else:
		    wp_enqueue_script("sbc_admin_angular_js", plugins_url("lib/angular/angular.min.js", __FILE__), "", true);
		endif;
	    wp_enqueue_script("sbc_admin_angular_app", plugins_url("js/app.js", __FILE__), array("sbc_admin_angular_js"));
	    wp_enqueue_script("sbc_admin_angular_controller", plugins_url("js/controllers.js", __FILE__), array("sbc_admin_angular_js", "sbc_admin_angular_app"));
	    wp_enqueue_script("sbc_admin_script", plugins_url("js/script.js", __FILE__), array("jquery"));
    }
    
    public function bt_button_scripts() {
	    wp_enqueue_style("bt_button_style", plugins_url("css/bt_button.css", __FILE__));
	    wp_enqueue_script("bt_button_script", plugins_url("js/bt_button.js", __FILE__), array("jquery"));
    }
    
    public function post_processing() {
	    var_dump($_POST);
    }
    
    	// Pass the Wordpress variable values to JavaScript
    public function js_vars() {
?>
		<script>
			var currentPath = "<?php echo plugins_url("", __FILE__); ?>";
		</script>
<?php
    }
    
}

if( is_admin() )
    $sbc = new simpleButtons();
    
?>