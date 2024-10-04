<?php

/**
 * Fired during plugin activation
 *
 * @link       https://spotlightstudios.co.uk/
 * @since      2.0.0
 *
 * @package    Ss_Toolkit
 * @subpackage Ss_Toolkit/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package    Ss_Toolkit
 * @subpackage Ss_Toolkit/includes
 * @author     Spotlight <info@spotlightstudios.co.uk>
 */
class Ss_Toolkit_Activator {

	public function __construct() {
		do_action( 'activate' );
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    2.0.0
	 */
	public static function activate() {
		add_option( 'ss_login', 0);
		add_option( 'ss_dashboard_widget', 0);
		add_option( 'ss_shortcodes', 0);
		add_option( 'ss_removal_prevent', 0);
		add_option( 'ss_access_toolkit', 0);
		add_option( 'ss_api', '');
		add_option( 'ss_rss_feed_link', 1);
		add_option( 'ss_background_image', '');
		add_option( 'ss_rss_feed_link_promotion', 1);
		add_option( 'ss_head_foot_content', 0);
		add_option( 'ss_header_content', '');
		add_option( 'ss_footer_content', '');
		add_option( 'ss_custom_functions', 0);
		add_option(	'ss_custom_functions_value', '');
		add_option( 'ss_google_map_api', '');
		add_option( 'ss_duplicate_post_page', 0);
		add_option( 'ss_default_email_settings', 0);
		add_option( 'ss_default_email_value', 0);
		add_option( 'ss_disable_outgoing_emails_settings', 0);
	}
}
