<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       webpigment.com
 * @since      1.0.0
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/admin
 * @author     m1tk00 <mitko.kockovski@gmail.com>
 */
class Wc_Ajax_Product_Add_To_Cart_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function add_plugin_settings( $fields ){
		$fields[] = array(
			'title' => __( 'Product page Ajax', 'woocommerce' ),
			'type'  => 'title',
			'desc'  => '',
			'id'    => $this->plugin_name,
		);
		$fields[] = array(
			'title'           => __( 'Product page ajax', 'woocommerce' ),
			'desc'            => __( 'Enable add to cart ajax on product page', 'woocommerce' ),
			'id'              => $this->plugin_name . '_enabled',
			'default'         => 'no',
			'type'            => 'checkbox',
			'checkboxgroup'   => 'start',
		);
		$fields[] = array(
			'title'           => __( 'Add loading animation', 'woocommerce' ),
			'desc'            => __( 'Enable BlockUI loading animation, like the one at checkout.', 'woocommerce' ),
			'id'              => $this->plugin_name . '_blockui',
			'default'         => 'no',
			'type'            => 'checkbox',
			'checkboxgroup'   => 'start',
		);
		$fields[] = array(
			'type' => 'sectionend',
			'id'   => $this->plugin_name,
		);
		return $fields;
	}
}
