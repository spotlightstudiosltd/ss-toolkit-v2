<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://spotlightstudios.co.uk/
 * @since      2.0.0
 *
 * @package    Ss_Toolkit
 * @subpackage Ss_Toolkit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ss_Toolkit
 * @subpackage Ss_Toolkit/admin
 * @author     Spotlight <info@spotlightstudios.co.uk>
 */
class Ss_Toolkit_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since	 2.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ss_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ss_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		function get_current_admin_page_slug() {
		    // Check if we are in the admin area
		    if ( is_admin() && isset( $_GET['page'] ) ) {
		        return sanitize_text_field( $_GET['page'] );
		    }
		    return false;
		}

		// Usage
		$current_page = get_current_admin_page_slug();
		if ( $current_page === 'ss-toolkit' ) {
		    // Your code for ss-toolkit page
		    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ss-toolkit-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ss_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ss_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ss-toolkit-admin.js', array( 'jquery' ), $this->version, false );


	}

}
