<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mrcatdev.com
 * @since      1.0.0
 *
 * @package    Mrcatdev_Min_Order
 * @subpackage Mrcatdev_Min_Order/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mrcatdev_Min_Order
 * @subpackage Mrcatdev_Min_Order/includes
 * @author     Hossein Shourabi <hoseinshurabi@gmail.com>
 */
class Mrcatdev_Min_Order_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mrcatdev-min-order',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
