<?php
/*
Plugin Name: WooCommerce Accepted Payment Methods
Plugin URI: http://jameskoster.co.uk
Description: Alows you display which payment methods your online store accepts.
Author: jameskoster
Author URI: http://jameskoster.co.uk

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain('wc_apm', false, dirname( plugin_basename( __FILE__ ) ) . '/');
	
	/**
	 * Accepted Payment Methods class
	 **/
	if ( ! class_exists( 'wc_apm' ) ) {
	 
		class WC_apm {
			
			public function __construct() { 
				
				// Init settings
				$this->settings = array(
					array( 
						'name' => __( 'Accepted Payment Methods', 'woocommerce-accepted-payment-methods' ), 
						'type' => 'title', 
						'desc' => 'To display the selected payment methods you can use the built in widget, the <code>[woocommerce_accepted_payment_methods]</code> shortcode or the <code>&lt;?php wc_accepted_payment_methods(); ?&gt;</code> template tag.
', 
						'id' => 'wc_apm_options' 
					),
					array(  
						'name' 		=> __( 'Label', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Displayed before the list of accepted payment methods. Leave blank to not display a label.', 'wc_apm' ),
						'id' 		=> 'wc_apm_label',
						'std'		=> '',
						'type' 		=> 'text'
					),
					array(  
						'name' 		=> __( 'American Express', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Display the American Express logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_american_express',
						'type' 		=> 'checkbox'
					),
					array(  
						'name' 		=> __( 'Google', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Display the Google logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_google',
						'type' 		=> 'checkbox'
					),
					array(  
						'name' 		=> __( 'MasterCard', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Display the MasterCard logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_mastercard',
						'type' 		=> 'checkbox'
					),
					array(  
						'name' 		=> __( 'PayPal', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Display the PayPal logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_paypal',
						'type' 		=> 'checkbox'
					),
					array(  
						'name' 		=> __( 'Visa', 'woocommerce-accepted-payment-methods' ),
						'desc_tip' 	=> __( 'Display the Visa logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_visa',
						'type' 		=> 'checkbox'
					),
					array( 'type' => 'sectionend', 'id' => 'wc_apm_options' ),
				);
				
				// Default options
				add_option( 'wc_apm_label', '' );
				add_option( 'wc_apm_american_express', 'no' );
				add_option( 'wc_apm_american_google', 'no' );
				add_option( 'wc_apm_american_mastercard', 'no' );
				add_option( 'wc_apm_american_paypal', 'no' );
				add_option( 'wc_apm_american_visa', 'no' );
				
				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( &$this, 'admin_settings' ), 20);
				add_action( 'woocommerce_update_options_catalog', array( &$this, 'save_admin_settings' ) );
				add_action( 'get_header', array( &$this, 'setup_styles' ) );

				
			}
					    
	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/ 

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}
			
			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			// Setup styles
			function setup_styles() {
				wp_enqueue_style( 'apm-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
			}
			
		}		
		$WC_apm = new WC_apm();
	}

	/**
	 * Frontend functions
	 */
	// Template tag
	if ( ! function_exists( 'wc_accepted_payment_methods' ) ) {
		function wc_accepted_payment_methods() {
			$label 		= get_option( 'wc_apm_label' );
			$amex 		= get_option( 'wc_apm_american_express' );
			$google 	= get_option( 'wc_apm_google' );
			$mastercard = get_option( 'wc_apm_mastercard' );
			$paypal 	= get_option( 'wc_apm_paypal' );
			$visa 		= get_option( 'wc_apm_visa' );

			// Display
			if ( $label !== '' ) { echo '<h3>' . $label . '</h3>'; }
			echo '<ul class="accepted-payment-methods">';
				if ( $amex == "yes" ) { echo '<li class="american-express"><span>American Express</span></li>'; }
				if ( $google == "yes" ) { echo '<li class="google"><span>Google</span></li>'; }
				if ( $mastercard == "yes" ) { echo '<li class="mastercard"><span>MasterCard</span></li>'; }
				if ( $paypal == "yes" ) { echo '<li class="paypal"><span>PayPal</span></li>'; }
				if ( $visa == "yes" ) { echo '<li class="visa"><span>Visa</span></li>'; }
			echo '</ul>';
		}
	}

	// The shortcode
	add_shortcode( 'woocommerce_accepted_payment_methods', 'wc_accepted_payment_methods' );

	// The widget
	class Accepted_Payment_Methods extends WP_Widget {

		function Accepted_Payment_Methods() {
			// Instantiate the parent object
			parent::__construct( false, 'Accepted Payment Methods' );
		}

		function widget( $args, $instance ) {
			// Widget output
			extract( $args );
			echo $before_widget;
			wc_accepted_payment_methods();
			echo $after_widget;
		}

	}

	function apm_register_widgets() {
		register_widget( 'Accepted_Payment_Methods' );
	}

	add_action( 'widgets_init', 'apm_register_widgets' );

}