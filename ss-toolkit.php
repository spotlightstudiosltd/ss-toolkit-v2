<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://spotlightstudios.co.uk/
 * @since             2.0.0
 * @package           Ss_Toolkit
 *
 * @wordpress-plugin
 * Plugin Name:       SS Toolkit
 * Plugin URI:        https://spotlightstudios.co.uk/
 * Description:       This plugin has a few tools, primarily to advertise our service, provide Spotlight Branding throughout the client experience, and provide some useful tools that we integrate into most of our websites.
 * Version:           2.0.5
 * Author:            Spotlight
 * Author URI:        https://spotlightstudios.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ss-toolkit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 2.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SS_TOOLKIT_VERSION', '2.0.5' );

// add_filter( 'auto_update_plugin', '__return_true' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ss-toolkit-activator.php
 */
function activate_ss_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ss-toolkit-activator.php';
	Ss_Toolkit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ss-toolkit-deactivator.php
 */
function deactivate_ss_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ss-toolkit-deactivator.php';
	Ss_Toolkit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ss_toolkit' );
register_deactivation_hook( __FILE__, 'deactivate_ss_toolkit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ss-toolkit.php';

require_once plugin_dir_path( __FILE__ ) . 'config.php';
require plugin_dir_path( __FILE__ ) . 'update.php';
$update = new ToolkitGitHubPluginUpdater(SLUG,GITHUBUSERNAME,GITHUBPROJECTREPO,ACCESSTOKEN);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_ss_toolkit() {

	$plugin = new Ss_Toolkit();
	$plugin->run();

}
run_ss_toolkit();



