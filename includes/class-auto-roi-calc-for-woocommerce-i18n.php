<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://autoroicalc.com
 * @since      1.0.0
 *
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/includes
 * @author     AutoROICalc <support@autoroicalc.com>
 */
class Auto_Roi_Calc_For_Woocommerce_i18n {

  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.0.0
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain(
      'auto-roi-calc-for-woocommerce',
      false,
      dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
    );
  }

}