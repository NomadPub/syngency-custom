<?php

/**
 * Syngency WordPress plugin - bootstrap file
 *
 * @link              https://posewellmodels.com
 * @since             1.0.0
 * @package           Syngency
 *
 * @syngency-wordpress-plugin
 * Plugin Name:       Syngency (Posewell Models Custom)
 * Plugin URI:        https://posewellmodels.com
 * Description:       Custom version for Posewell Models - Displays Syngency divisions, models, and galleries
 * Version:           1.4.1-posewell-1
 * Author:            Posewell Models (based on Syngency)
 * Author URI:        https://posewellmodels.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       syngency
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Disable automatic updates for this custom plugin
 */
add_filter( 'auto_update_plugin', function( $update, $plugin ) {
	if ( isset( $plugin->plugin ) && strpos( $plugin->plugin, 'syngency/syngency.php' ) !== false ) {
		return false;
	}
	return $update;
}, 10, 2 );

/**
 * Remove update notifications for this custom plugin
 */
add_filter( 'pre_set_site_transient_update_plugins', function( $value ) {
	if ( isset( $value->response['syngency/syngency.php'] ) ) {
		unset( $value->response['syngency/syngency.php'] );
	}
	return $value;
} );

/**
 * The code that runs during plugin activation.
 */
function activate_syngency() {
    // Register the rewrite rules for portfolio URLs
    add_rewrite_rule(
        '^divisions/([^/]+)/portfolios/([^/]+)/?$',
        'index.php?pagename=$matches[1]&model=$matches[2]',
        'top'
    );
    
    // Flush rewrite rules to ensure the new rules are written to the database
    flush_rewrite_rules( true );
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_syngency() {

}

register_activation_hook( __FILE__, 'activate_syngency' );
register_deactivation_hook( __FILE__, 'deactivate_syngency' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-syngency.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_syngency() {

	$plugin = new Syngency();
	$plugin->run();

}
run_syngency();
