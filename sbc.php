<?php
/**
 * Plugin Name: Simple Buttons Creator
 * Plugin URI: https://wordpress.org/plugins/simple-buttons-creator/
 * Description: A simple way to create buttons with many customizable options available. After a button is created, you can use a Simple Buttons Creator widget to display the button onto the page. This plugin has been tested with <a href="http://wordpress.org/plugins/siteorigin-panels/">Page Builder by SiteOrigin</a>.
 * Version: 1.03.1
 * Author: Robby Chen
 * Author URI: http://blog.robbychen.com
 * @todo  Change the Author URI to http://robbychen.com once the homepage redesign is done
 * License: GPL2
 */
 
require_once("lib/sqlite/sqlite.class.php");

require_once("sbc-widget.php");

class simpleButtons {

    private $options;

   public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action("admin_enqueue_scripts", array($this, "add_universal_scripts"));
        	// Load the admin scripts only within the pages for this plugin
        if (strstr($_SERVER['QUERY_STRING'], "simple-buttons") || strstr($_SERVER['QUERY_STRING'], "sbc-new")):
	        add_action("admin_enqueue_scripts", array($this, "add_admin_scripts"));
					add_action("admin_enqueue_scripts", array($this, "bt_button_scripts"));
				endif;
        
        add_action("wp_enqueue_scripts", array($this, "add_universal_scripts"));
		
				add_action("admin_enqueue_scripts", array($this, "sbc_widget_scripts"));
				add_action("admin_head", array($this, "js_vars"));
        
    }

    public function add_plugin_page() {
			add_menu_page( "Simple Buttons Creator", "Simple Buttons Creator", "manage_options", "simple-buttons", array($this, "create_admin_page"), plugin_dir_url(__FILE__) . "img/btn-20x20.png");
			add_submenu_page("simple-buttons", "Add a new button", "Add New Button", "manage_options", "sbc-new", array($this, "add_new_page"));
    }

    public function create_admin_page() {
    	if (isset($_GET['method']) && ($_GET['method'] == 'edit' || $_GET['method'] == "delete")):
			require_once("bt-manage.php");
		else:
			require_once("pages/index.php");
    	endif;
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
	    wp_enqueue_style("sbc_admin_style", plugins_url("css/admin.css", __FILE__));
			wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script("sbc_admin_script", plugins_url("js/script.js", __FILE__), array("jquery", "wp-color-picker"));
    }
    
    public function bt_button_scripts() {
	    wp_enqueue_style("bt_button_style", plugins_url("css/bt_button.css", __FILE__));
	    wp_enqueue_script("bt_button_script", plugins_url("js/bt_button.js", __FILE__), array("jquery"));
    }
    
    public function sbc_widget_scripts() {
	    wp_enqueue_script("sbc_widget_script", plugins_url("js/sbc-widget-preview.js", __FILE__));
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