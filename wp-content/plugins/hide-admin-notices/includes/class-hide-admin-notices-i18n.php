<?php

/**
 * Define the internationalization functionality
 *
 * @link       https://pontetlabs.com
 * @since      1.0.0
 *
 * @package    Hide_Admin_Notices
 * @subpackage Hide_Admin_Notices/includes
 */

/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    Hide_Admin_Notices
 * @subpackage Hide_Admin_Notices/includes
 * @author     PontetLabs <hi@pontetlabs.com>
 */
class Hide_Admin_Notices_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'hide-admin-notices',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
