<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       webpigment.com
 * @since      1.0.0
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wc_Ajax_Product_Add_To_Cart
 * @subpackage Wc_Ajax_Product_Add_To_Cart/public
 * @author     m1tk00 <mitko.kockovski@gmail.com>
 */
class Wc_Ajax_Product_Add_To_Cart_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	protected function is_enabled() {
		if( get_site_option( 'wc-ajax-product-add-to-cart_enabled', 'no' ) === 'yes' && ( is_product() || is_ajax() ) ) {
			return true;
		}
		return false;
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if( ! $this->is_enabled() ) {
			return ;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Ajax_Product_Add_To_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Ajax_Product_Add_To_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-ajax-product-add-to-cart-public.js', array( 'jquery' ), $this->version, false );
		$blockui = get_site_option( 'wc-ajax-product-add-to-cart_enabled', 'no' ) == 'yes' ? 1 : 0;
		wp_localize_script( $this->plugin_name, 'wc_prod_ajax_to_cart', array( 'ajax_url' => site_url() . '?wc-ajax=get_refreshed_fragments', 'enable_blockui' => $blockui ) );
	     wp_enqueue_script( $this->plugin_name );
	}


	/**
	 * Adding the hidden action name field.
	 */
	public function add_ajax_action(){
		if( ! $this->is_enabled() ) {
			return ;
		}
		global $product;
		?>
			<input type="hidden" name="action" value="wc_prod_ajax_to_cart" />
		<?php
		// Make sure we have the add-to-cart avaiable as button name doesn't submit via ajax.
		if( $product->is_type( 'simple' ) ) {
			?>
			<input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>"/>
			<?php
		}
	}

	/** 
	 * Add container to refresh notice.
	 */
	public function display_site_notice(){
		if( ! $this->is_enabled() ) {
			return ;
		}
		?>
		<div class="wc_prod_ajax_to_cart">
			<?php 
			if ( is_ajax() ) {
				wc_print_notices(); 
				wc_clear_notices();
			}
			?>
		</div>
		<?php
	}
	/**
	 * Add site notices in fragment.
	 *
	 * @param array  $fragments Site framgents.
	 * @return array $fragments Site framgents.
	 */
	public function get_site_notice( $fragments ){
		if( $this->is_enabled() ) {
			ob_start();
			$this->display_site_notice();
			$data = ob_get_clean();
			$fragments['.wc_prod_ajax_to_cart'] = $data;
		}
		return $fragments;
	}

}
