<?php
/**
 * Plugin Name: WPML SEO
 * Plugin URI: https://wpml.org/
 * Description: Multilingual support for popular SEO plugins
 * Author: OnTheGoSystems
 * Author URI: http://www.onthegosystems.com/
 * Version: 2.0.1
 * Plugin Slug: wp-seo-multilingual
 *
 * @package wpml/wpseo
 */

use WPML\WPSEO\Loaders as YoastSEOLoaders;
use WPML\WPSEO\RankMathSEO\Loaders as RankMathSEOLoaders;

// Check if we are already active.
if ( defined( 'WPSEOML_VERSION' ) ) {
	return;
}

define( 'WPSEOML_VERSION', '2.0.0' );
define( 'WPSEOML_PLUGIN_PATH', dirname( __FILE__ ) );

/**
 * We need to do the redirection checks before wordpress-seo loads.
 * To resolve this we move ourselves first in the plugins list.
 * By using priority 1 we will go after WPML core.
 */
function wpml_wpseo_loads_first() {
	$path    = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );
	$plugins = get_option( 'active_plugins' );
	$key     = array_search( $path, (array) $plugins, true );
	if ( $plugins && $key ) {
		array_splice( $plugins, $key, 1 );
		array_unshift( $plugins, $path );
		update_option( 'active_plugins', $plugins );
	}
}
add_action( 'activated_plugin', 'wpml_wpseo_loads_first', 1 );

if ( ! class_exists( 'WPML_Core_Version_Check' ) ) {
	require_once WPSEOML_PLUGIN_PATH . '/vendor/wpml-shared/wpml-lib-dependencies/src/dependencies/class-wpml-core-version-check.php';
}

if ( ! WPML_Core_Version_Check::is_ok( WPSEOML_PLUGIN_PATH . '/wpml-dependencies.json' ) ) {
	return;
}

require_once WPSEOML_PLUGIN_PATH . '/vendor/autoload.php';

// We have to do this early because wordpress-seo does it early too.
if ( apply_filters( 'wpml_setting', false, 'setup_complete' ) ) {
	$redirector = new WPML_WPSEO_Redirection();
	if ( $redirector->is_redirection() ) {
		add_filter( 'wpml_skip_convert_url_string', '__return_true' );
	}
}

/**
 * Initialize plugin when WPML has loaded.
 */
function wpml_wpseo_init() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		$actions_filters_loader = new WPML_Action_Filter_Loader();
		$actions_filters_loader->load( YoastSEOLoaders::get( WPSEO_VERSION ) );
	}

	if ( defined( 'RANK_MATH_VERSION' ) ) {
		$actions_filters_loader = new WPML_Action_Filter_Loader();
		$actions_filters_loader->load( RankMathSEOLoaders::get() );
	}
}
add_action( 'wpml_loaded', 'wpml_wpseo_init' );
