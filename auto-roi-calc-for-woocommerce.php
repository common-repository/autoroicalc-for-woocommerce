<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://autoroicalc.com
 * @since             1.0.0
 * @package           Auto_Roi_Calc_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       AutoROICalc for WooCommerce
 * Plugin URI:        https://autoroicalc.com
 * Description:       Enhance your WooCommerce store's sales reporting and gain valuable insights into the ROI of your marketing efforts. Effortlessly track the profitability of your orders, factoring in the cost of goods sold. Make data-driven decisions to optimize your marketing channels and boost your bottom line.
 * Version:           1.0.0
 * Author:            AutoROICalc
 * Author URI:        https://autoroicalc.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       auto-roi-calc-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * Currently plugin version.
 */
define( 'AUTO_ROI_CALC_FOR_WOOCOMMERCE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-auto-roi-calc-for-woocommerce-activator.php
 */
function auto_roi_calc_for_woocommerce_activate() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-roi-calc-for-woocommerce-activator.php';
  Auto_Roi_Calc_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-auto-roi-calc-for-woocommerce-deactivator.php
 */
function auto_roi_calc_for_woocommerce_deactivate() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-roi-calc-for-woocommerce-deactivator.php';
  Auto_Roi_Calc_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'auto_roi_calc_for_woocommerce_activate' );
register_deactivation_hook( __FILE__, 'auto_roi_calc_for_woocommerce-deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-auto-roi-calc-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 * 
 * The plugin is intented to be used with WooCommerce.
 * Thus we do not run the plugin in WooCommerce is not installed.
 *
 * @since    1.0.0
 */
function auto_roi_calc_for_woocommerce_run() {

  if ( 
    in_array( 
      'woocommerce/woocommerce.php', 
      apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
    ) 
  ) {
    $plugin = new Auto_Roi_Calc_For_Woocommerce();
    $plugin->run();
  }

}
auto_roi_calc_for_woocommerce_run();
