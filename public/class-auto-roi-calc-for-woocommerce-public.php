<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://autoroicalc.com
 * @since      1.0.0
 *
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/public
 * @author     AutoROICalc <support@autoroicalc.com>
 */
class Auto_Roi_Calc_For_Woocommerce_Public {

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
   * @var      string    $version        The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   * Hooks onto the woocommerce_checkout_create_order action to calculate
   * and report the order performance.
   *
   * @since    1.0.0
   * @param      string    $plugin_name The name of the plugin.
   * @param      string    $version     The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
    add_action( 'woocommerce_checkout_create_order', array( $this, 'report'), 10, 1 );
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() { }

  /**
   * Register the JavaScript for the public-facing side of the site.
   * Registers the AutoROICalc JavaScript module for web events tracking.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_enqueue_script(
      $this->plugin_name . '-js',
      plugin_dir_url( __FILE__ ) . 'js/auto-roi-calc.js',
      array(),
      '1.1.1',
      false
    );
    wp_enqueue_script(
      $this->plugin_name,
      plugin_dir_url( __FILE__ ) . 'js/auto-roi-calc-for-woocommerce-public.js',
      array( 'jquery' ),
      $this->version,
      false
    );
  }

  /**
   * Calculates and reports the order performance.
   * Takes the order items and fees into the profit calculation.
   *
   * @since    1.0.0
   */
  public static function report( $order ) {
    if (
      !get_option('auto_roi_calc_api_user') ||
      !get_option('auto_roi_calc_api_password') ||
      !get_option('auto_roi_calc_product_purchasing_price_meta_field'))
    {
      return;
    }

    // Retrieves marketing sources determined by the AutoROICalc JavaScript module
    $sources = isset($_COOKIE['arc_sources']) ? sanitize_text_field($_COOKIE['arc_sources']) : 'not set';
    $sources = explode('|', $sources);
    // AutoROICalc accepts max 6 record sources
    $sources = array_slice($sources, 0, 6);
    // Limit each source to a maximum of 256 characters
    $sources = array_map(function ($source) {
      return mb_substr($source, 0, 256);
    }, $sources);
    $sources = array_map('esc_html', $sources);

    $total = round( $order->get_total(), 2 );
    $profit = 0;

    // Items
    foreach ($order->get_items() as $item_id => $item) {
      $product = $order->get_product_from_item($item);
      if (!$product) {
        continue;
      }
      $purchasingPrice = get_post_meta(
        $item->get_product_id(),
        get_option('auto_roi_calc_product_purchasing_price_meta_field'), true
      );
      $purchasingPrice = $purchasingPrice ? floatval($purchasingPrice) : 0;
      $qty = $item->get_quantity();
      $price = $product->get_price();
      $itemProfit = ($price - $purchasingPrice) * $qty;
      $profit += $itemProfit;
    }

    // Fees
    foreach ($order->get_items('fee') as $item_id => $item_fee) {
      $feeTotal = $item_fee->get_total();
      $profit += $feeTotal;
    }

    $records = array(
      array(
        'date' => date('Y-m-d'),
        'time' => date("H:i:s"),
        'type' => 'transactionRevenue',
        'activity' => 'closed',
        'desc' => time(),
        'source' => $sources,
        'value' => round($total, 2)
      ),
      array(
        'date' => date('Y-m-d'),
        'time' => date("H:i:s"),
        'type' => 'transactions',
        'activity' => 'closed',
        'desc' => time(),
        'source' => $sources,
        'value' => 1
      ),
      array(
        'date' => date('Y-m-d'),
        'time' => date("H:i:s"),
        'type' => 'transactionProfit',
        'activity' => 'closed',
        'desc' => time(),
        'source' => $sources,
        'value' => round($profit, 2)
      )
    );

    // Sends the collected data to AutoROICalc
    $url = 'https://autoroicalc.com/api/auto-roi-calc/v1/add-records/';
    $user = get_option('auto_roi_calc_api_user');
    $pass = get_option('auto_roi_calc_api_password');

    $request = array(
      'body' => json_encode($records),
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Basic ' . base64_encode("$user:$pass"),
      ),
      'user-agent' => 'WordPress/' . get_bloginfo('version'),
      'timeout' => 15,
      'sslverify' => true,
      'blocking' => true
    );

    $response = wp_remote_post($url, $request);
    if (is_wp_error($response)) {
      $order->update_meta_data('autoRoiCalcResponse', $response->get_error_message());
    }
    else {
      $order->update_meta_data('autoRoiCalcResponse', wp_remote_retrieve_body($response));
    }
    $order->save();
  }

}
