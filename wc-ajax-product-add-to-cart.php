<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              webpigment.com
 * @since             1.0
 * @package           Wc_Ajax_Product_Add_To_Cart
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Single Product Ajax add to cart
 * Plugin URI:        https://wordpress.org/plugins/wc-ajax-product-add-to-cart/
 * Description:       Working with all known product types, such as woocommerce subscriptions, woocommerce bulk products, variable products, grouped products.
 * Version:           1.2.1
 * Author:            Webpigment
 * Author URI:        webpigment.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-ajax-product-add-to-cart
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_PROD_AJAX_TO_CART_VER', '1.1.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-ajax-product-add-to-cart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_ajax_product_add_to_cart() {

	$plugin = new Wc_Ajax_Product_Add_To_Cart();
	$plugin->run();

}
run_wc_ajax_product_add_to_cart();
