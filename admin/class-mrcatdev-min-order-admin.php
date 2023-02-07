<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mrcatdev.com
 * @since      1.0.0
 *
 * @package    Mrcatdev_Min_Order
 * @subpackage Mrcatdev_Min_Order/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mrcatdev_Min_Order
 * @subpackage Mrcatdev_Min_Order/admin
 * @author     Hossein Shourabi <hoseinshurabi@gmail.com>
 */
class Mrcatdev_Min_Order_Admin {

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

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mrcatdev_Min_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mrcatdev_Min_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mrcatdev-min-order-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mrcatdev_Min_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mrcatdev_Min_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mrcatdev-min-order-admin.js', array( 'jquery' ), $this->version, false );

	}

	function wc_minimum_order_amount() {
		// Set this variable to specify a minimum order value

		$minimum = intval(get_option( 'wc_order_min_field' ));
		if(empty($minimum)) $minimum=0;

		if ( WC()->cart->subtotal < $minimum ) {

			if( is_cart() ) {

				wc_print_notice(
					sprintf( 'حداقل مبلغ سفارش شما باید %s باشد، متاسفانه مبلغ سفارش شما %s است. ' ,

						wc_price( $minimum ),
							wc_price( WC()->cart->subtotal )
					), 'error'
				);

			} else {

				wc_add_notice(
					sprintf( 'حداقل مبلغ سفارش شما باید %s باشد، متاسفانه مبلغ سفارش شما %s است. ' ,
							wc_price( $minimum ),
						wc_price( WC()->cart->subtotal )

					), 'error'
				);

			}
		}
	}

	function disable_checkout_button_no_shipping() {

		$minimum = intval(get_option( 'wc_order_min_field' ));
		if(empty($minimum)) $minimum=0;

		if (WC()->cart->total < $minimum ) {
			remove_action('woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout',20 );
		}
	}


	// Add custom tab to WooCommerce settings
	function add_my_custom_tab( $settings_tabs ) {
		$settings_tabs['my_tab'] = __( 'محدودیت سفارش', 'mrcatdev-min-order' );
		return $settings_tabs;
	}

	// Add custom fields to the custom tab in WooCommerce settings
	function add_my_custom_fields() {
		woocommerce_admin_fields( array($this, 'get_my_custom_settings')() );
	}

  // Define the custom settings fields
	function get_my_custom_settings() {
		$settings = array(
			'section_title' => array(
			'name' => __( 'محدودیت سفارش', 'mrcatdev-min-order' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'wc_my_custom_section_title'
			),
			'order_min_field' => array(
			'name' => __( 'حداقل مبلغ برای ثبت سفارش', 'mrcatdev-min-order' ),
			'type' => 'number',
			'desc' => __( 'مبلغ به تومان می باشد', 'mrcatdev-min-order' ),
			'id' => 'wc_order_min_field'
			),

			'section_end' => array(
			'type' => 'sectionend',
			'id' => 'wc_my_custom_section_end'
			)
		);
		return apply_filters( 'my_custom_settings', $settings );

	}

  // Save custom fields in WooCommerce settings
	function save_my_custom_fields() {
		woocommerce_update_options( array($this, 'get_my_custom_settings')() );
	}

}
