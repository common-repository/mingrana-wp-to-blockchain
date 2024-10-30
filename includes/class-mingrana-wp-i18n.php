<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 * @author     Mingrana SL <info@mingrana.com>
 */
class Mingrana_Wp_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mingrana-wp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
