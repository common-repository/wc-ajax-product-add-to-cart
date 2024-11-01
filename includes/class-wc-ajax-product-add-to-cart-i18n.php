<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       webpigment.com
 * @since      1.0.0
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/includes
 * @author     m1tk00 <mitko.kockovski@gmail.com>
 */
class Wc_Ajax_Product_Add_To_Cart_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-ajax-product-add-to-cart',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
