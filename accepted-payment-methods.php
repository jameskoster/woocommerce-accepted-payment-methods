<?php
/*
Plugin Name: WooCommerce Accepted Payment Methods
Plugin URI: http://jameskoster.co.uk/tag/accepted-payment-methods/
Version: 0.2.2
Description: Allows you display which payment methods your online store accepts.
Author: jameskoster
Tested up to: 3.5
Author URI: http://jameskoster.co.uk
Text Domain: woocommerce-accepted-payment-methods
Domain Path: /languages/

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Localisation
 */
load_plugin_textdomain( 'woocommerce-accepted-payment-methods', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * Accepted Payment Methods class
	 **/
	if ( ! class_exists( 'WC_apm' ) ) {

		class WC_apm {

			public function __construct() {

				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'Accepted Payment Methods', 'woocommerce-accepted-payment-methods' ),
						'type' => 'title',
						'desc' => sprintf( __( 'To display the selected payment methods you can use the built in widget, the %s shortcode or the %s template tag.', 'woocommerce-accepted-payment-methods' ), '<code>[woocommerce_accepted_payment_methods]</code>', '<code>&lt;?php wc_accepted_payment_methods(); ?&gt;</code>' ),
						'id' => 'wc_apm_options'
					),
					array(
						'name' 		=> __( 'American Express', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the American Express logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_american_express',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Google', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Google logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_google',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'MasterCard', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the MasterCard logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_mastercard',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'PayPal', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the PayPal logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_paypal',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Visa', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Visa logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_visa',
						'type' 		=> 'checkbox'
					),
					array( 'type' => 'sectionend', 'id' => 'wc_apm_options' ),
				);

				// Default options
				add_option( 'wc_apm_label', '' );
				add_option( 'wc_apm_american_express', 'no' );
				add_option( 'wc_apm_google', 'no' );
				add_option( 'wc_apm_mastercard', 'no' );
				add_option( 'wc_apm_paypal', 'no' );
				add_option( 'wc_apm_visa', 'no' );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( &$this, 'admin_settings' ), 20);
				add_action( 'woocommerce_update_options_catalog', array( &$this, 'save_admin_settings' ) );
				add_action( 'wp_enqueue_scripts', array( &$this, 'setup_styles' ) );


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
			$amex 		= get_option( 'wc_apm_american_express' );
			$google 	= get_option( 'wc_apm_google' );
			$mastercard = get_option( 'wc_apm_mastercard' );
			$paypal 	= get_option( 'wc_apm_paypal' );
			$visa 		= get_option( 'wc_apm_visa' );

			// Display
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

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
				wc_accepted_payment_methods();
			echo $after_widget;
		}
		/**
		 * Sanitize widget form values as they are saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 */
		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}
			else {
				$title = __( 'Accepted Payment Methods', 'woocommerce-accepted-payment-methods' );
			}
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'woocommerce-accepted-payment-methods' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}

	}

	function apm_register_widgets() {
		register_widget( 'Accepted_Payment_Methods' );
	}

	add_action( 'widgets_init', 'apm_register_widgets' );

}