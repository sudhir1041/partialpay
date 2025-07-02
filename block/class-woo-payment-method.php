<?php

use Automattic\WooCommerce\StoreApi\StoreApi;
use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
//use Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema;
//use Automattic\WooCommerce\Blocks\StoreApi\Schemas\CartSchema;
//use Automattic\WooCommerce\Blocks\StoreApi\Schemas\CheckoutSchema;

class pisol_dpmw_woo_payment_block{

    private $extend;

    protected static $instance = null;

    const IDENTIFIER = 'pisol_set_payment_method';


    public static function get_instance( ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    protected function __construct(){
        add_action( 'woocommerce_blocks_loaded', [$this, 'loadData']);
        add_action('wp_enqueue_scripts', [$this, 'paymentScript']);
    }

    function loadData(){
        if(!class_exists('\Automattic\WooCommerce\StoreApi\StoreApi') || !class_exists('\Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema') || !class_exists('\Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema')) return;
        
        $this->callBack();
    }

    function callBack(){
        woocommerce_store_api_register_update_callback(
            [
              'namespace' => self::IDENTIFIER,
              'callback'  => [$this, 'setPaymentMethod']
            ]
          );
    }

    function setPaymentMethod( $data ){
        if(function_exists('WC') && isset(WC()->session)){
            $session = WC()->session;
            if(isset($data['payment_method']) && !empty($data['payment_method'])){
                $session->set('chosen_payment_method', $data['payment_method']);
            }
        }
    }

    function paymentScript(){
        if(is_checkout()){
            wp_enqueue_script( 'pisol-dpmw-payment-block', plugin_dir_url( __FILE__ ) . 'js/block-payment.js', array( 'wp-plugins', 'wc-blocks-checkout' ), DISABLE_PAYMENT_METHOD_FOR_WOOCOMMERCE_VERSION, true );
            wp_enqueue_style( 'pisol-dpmw-fill-block', plugin_dir_url( __FILE__ ) . 'css/block.css', array( 'wc-blocks-style' ),DISABLE_PAYMENT_METHOD_FOR_WOOCOMMERCE_VERSION);
            wp_localize_script( 'pisol-dpmw-payment-block', 'pisol_dpmw_payment_block', [
                'payment_change_trigger' => self::is_payment_change_detection_needed()
            ] );
        }
    }

    /**
    * Woocommerce version 6.8 introduced the feature of payment method change in the checkout block. So we don't need our code from WC 9.8 and above.
    */
    static function is_payment_change_detection_needed(){
        if(apply_filters('pisol_dpmw_force_payment_change_detection', false)) return true;

        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '9.8', '>=' ) ) {
            return false;
        }
        
        return true;
    }

}

pisol_dpmw_woo_payment_block::get_instance();