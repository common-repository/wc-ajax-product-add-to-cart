<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       webpigment.com
 * @since      1.0.0
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/includes
 * @author     m1tk00 <mitko.kockovski@gmail.com>
 */
class Wc_Ajax_Product_Add_To_Cart {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wc_Ajax_Product_Add_To_Cart_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.1.0';
		}
		$this->plugin_name = 'wc-ajax-product-add-to-cart';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wc_Ajax_Product_Add_To_Cart_Loader. Orchestrates the hooks of the plugin.
	 * - Wc_Ajax_Product_Add_To_Cart_i18n. Defines internationalization functionality.
	 * - Wc_Ajax_Product_Add_To_Cart_Admin. Defines all hooks for the admin area.
	 * - Wc_Ajax_Product_Add_To_Cart_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-ajax-product-add-to-cart-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-ajax-product-add-to-cart-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-ajax-product-add-to-cart-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc-ajax-product-add-to-cart-public.php';

		$this->loader = new Wc_Ajax_Product_Add_To_Cart_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wc_Ajax_Product_Add_To_Cart_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wc_Ajax_Product_Add_To_Cart_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wc_Ajax_Product_Add_To_Cart_Admin( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'wp_ajax_wc_prod_ajax_to_cart', $plugin_admin, 'process_add_to_cart' );
		// $this->loader->add_action( 'wp_ajax_nopriv_wc_prod_ajax_to_cart', $plugin_admin, 'process_add_to_cart' );
		$this->loader->add_action( 'woocommerce_products_general_settings', $plugin_admin, 'add_plugin_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wc_Ajax_Product_Add_To_Cart_Public( $this->get_plugin_name(), $this->get_version() );
		
		if( get_site_option( 'wc-ajax-product-add-to-cart_enabled', 'no' ) === 'yes' ) {
			
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_action( 'woocommerce_after_add_to_cart_button', $plugin_public, 'add_ajax_action' );
			$this->loader->add_action( 'woocommerce_before_main_content', $plugin_public, 'display_site_notice' );
			$this->loader->add_action( 'woocommerce_add_to_cart_fragments', $plugin_public, 'get_site_notice' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wc_Ajax_Product_Add_To_Cart_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
