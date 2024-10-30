<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.mingrana.com/
 * @since             1.0.0
 * @package           Mingrana_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       Mingrana WP to Blockchain
 * Plugin URI:        https://www.mingrana.com/plugin-wp
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.4
 * Author:            Mingrana Bring to Chain
 * Author URI:        https://www.mingrana.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mingrana-wp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINGRANA_WP_VERSION', '1.0.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mingrana-wp-activator.php
 */
function activate_mingrana_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mingrana-wp-activator.php';
	Mingrana_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mingrana-wp-deactivator.php
 */
function deactivate_mingrana_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mingrana-wp-deactivator.php';
	Mingrana_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mingrana_wp' );
register_deactivation_hook( __FILE__, 'deactivate_mingrana_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mingrana-wp.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-mingrana-server.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mingrana_wp() {

	$plugin = new Mingrana_Wp();
	$plugin->run();

}
run_mingrana_wp();



