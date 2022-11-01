<?php
/**
 * @link              https://pontetlabs.com
 * @since             1.0.0
 * @package           Hide_Admin_Notices
 *
 * @wordpress-plugin
 * Plugin Name:       Hide Admin Notices
 * Plugin URI:        https://pontetlabs.com/hide-admin-notices
 * Description:       Hide – or show – WordPress Dashboard Notices, Messages, Update Nags etc. ... for everything!
 * Version:           1.2.2
 * Author:            PontetLabs
 * Author URI:        https://pontetlabs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hide-admin-notices
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define path to this file constant.
 *
 * @since    1.0.0
 */
define( 'HIDE_ADMIN_NOTICES_PLUGIN_FILE', __FILE__ );

require plugin_dir_path( HIDE_ADMIN_NOTICES_PLUGIN_FILE ) . 'includes/class-hide-admin-notices.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_hide_admin_notices() {
	$plugin = new Hide_Admin_Notices();
	$plugin->run();
}

run_hide_admin_notices();
