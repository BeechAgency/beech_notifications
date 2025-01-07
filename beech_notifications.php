<?php
/*
Plugin Name:       Beech Notifications
Plugin URI:        https://beech.agency
Description:       Create notifications on your site without ads, bloat, and junk typically found in popup and notification plugins.
Version:           1.4
Requires at least: 6.5
Requires PHP: 7.2
Author:            Beech Agency
Author URI:        https://github.com/beechagency/
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:       beech_notifications
Domain Path:       /languages
*/

/**
 * @link              https://github.com/beechagency/
 * @since             1.4
 * @package           Beech_notifications
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BEECH_NOTIFICATIONS_VERSION', '1.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-beech_notifications-activator.php
 */
function activate_beech_notifications() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-beech_notifications-activator.php';
	Beech_notifications_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-beech_notifications-deactivator.php
 */
function deactivate_beech_notifications() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-beech_notifications-deactivator.php';
	Beech_notifications_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_beech_notifications' );
register_deactivation_hook( __FILE__, 'deactivate_beech_notifications' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-beech_notifications.php';

/**
 * Require the updater because we want it to update from GitHub
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-beech_notifications-updater.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_beech_notifications() {
	$plugin = new Beech_notifications();
	$plugin->run();

	$updater = new Beech_notifications_updater(__FILE__);
	$updater->set_username( 'BeechAgency' );
	$updater->set_repository( 'beech_notifications' );
	$updater->initialize();
}
run_beech_notifications();
