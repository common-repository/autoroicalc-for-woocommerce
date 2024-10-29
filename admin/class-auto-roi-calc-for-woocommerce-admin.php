<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://autoroicalc.com
 * @since      1.0.0
 *
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Auto_Roi_Calc_For_Woocommerce
 * @subpackage Auto_Roi_Calc_For_Woocommerce/admin
 * @author     AutoROICalc <support@autoroicalc.com>
 */
class Auto_Roi_Calc_For_Woocommerce_Admin {

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
   * Adds filters and actions to add a new WooCommerce settings tab for AutoROICalc settings.
   *
   * @since    1.0.0
   * @param      string    $plugin_name  The name of this plugin.
   * @param      string    $version      The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;

    add_filter( 'woocommerce_settings_tabs_array', array($this, 'woo_add_settings_tab' ) , 50);
    add_action( 'woocommerce_settings_tabs_auto_roi_calc', array($this, 'woo_get_settings') );
    add_action( 'woocommerce_update_options_auto_roi_calc', array($this, 'woo_set_settings') );
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() { }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() { }

  /**
   * Add WooCommerce settings tab.
   *
   * @since    1.0.0
   */
  public static function woo_add_settings_tab($tabs) {
    $tabs['auto_roi_calc'] = __('AutoROICalc', 'auto-roi-calc-for-woocommerce');
    return $tabs;
  }

  /**
   * Get AutoROICalc settings.
   *
   * @since    1.0.0
   */
  public static function woo_get_settings() {
    woocommerce_admin_fields( self::woo_settings() );
  }

  /**
   * Set AutoROICalc settings.
   *
   * @since    1.0.0
   */
  public static function woo_set_settings() {
    woocommerce_update_options( self::woo_settings() );
  }

  /**
   * Display and handle AutoROICalc settings.
   * Both for getting and setting the settings.
   *
   * @since    1.0.0
   */
  public static function woo_settings() {
    global $wpdb;
    $meta_keys = $wpdb->get_col("
      SELECT DISTINCT meta_key
      FROM {$wpdb->postmeta}
      WHERE meta_key NOT LIKE '\_%'
      ORDER BY meta_key
    ");
    $meta_field_options = array();
    foreach ($meta_keys as $key) {
      $meta_field_options[$key] = $key;
    }

    $settings = array(
      'section_title' => array(
        'name'     => __( 'AutoROICalc', 'auto-roi-calc-for-woocommerce' ),
        'type'     => 'title',
        'desc'     => __(
                        'Please update your settings let we can automatically calculate and collect your WooCommerce orders performace.',
                        'auto-roi-calc-for-woocommerce'
                      ),
        'id'       => 'auto_roi_calc_section_title'
      ),
      'section_api' => array(
        'name' => __( 'API Credentials', 'auto-roi-calc-for-woocommerce' ),
        'type' => 'title',
        'desc' => __( 'Please provide your AutoROICalc API credentials.', 'auto-roi-calc-for-woocommerce' ),
        'id'   => 'auto_roi_calc_section_api',
      ),
      'api_user' => array(
        'name' => __( 'API User Name', 'auto-roi-calc-for-woocommerce' ),
        'type' => 'text',
        'desc' => __( 'Your AutoROICalc API User Name (e-mail).', 'auto-roi-calc-for-woocommerce' ),
        'id'   => 'auto_roi_calc_api_user'
      ),
      'api_pass' => array(
        'name' => __( 'API Password', 'auto-roi-calc-for-woocommerce' ),
        'type' => 'text',
        'desc' => __( 'Your AutoROICalc API Password.', 'auto-roi-calc-for-woocommerce' ),
        'id'   => 'auto_roi_calc_api_password'
      ),
      'section_end_api' => array(
        'type' => 'sectionend',
        'id'   => 'auto_roi_calc_section_api',
      ),
      'section_meta' => array(
        'name' => __( 'Purchasing Price', 'auto-roi-calc-for-woocommerce' ),
        'type' => 'title',
        'desc' => __(
                      'Select your product purchasing price (cost of goods) meta field. This is for calculating your orders profit.',
                      'auto-roi-calc-for-woocommerce'
                    ),
        'id'   => 'auto_roi_calc_section_meta',
      ),
      'meta_field'    => array(
        'name'     => __( 'Purchasing Price Meta Field', 'auto-roi-calc-for-woocommerce' ),
        'type'     => 'select',
        'desc'     => __( 'Select a WooCommerce product purchasing price meta field.', 'auto-roi-calc-for-woocommerce' ),
        'id'       => 'auto_roi_calc_product_purchasing_price_meta_field',
        'options'  => $meta_field_options,
      ),
      'section_end_meta' => array(
        'type' => 'sectionend',
        'id'   => 'auto_roi_calc_section_meta',
      )
    );

    return apply_filters( 'auto_roi_calc_settings', $settings );
  }

}