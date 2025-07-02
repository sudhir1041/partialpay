<?php
/**
 * This prevents the customer from checkout if cart total is 0 or if there are not payment gateway to select 
 */

namespace PISOL\DPMW;

class PaymentSafety{

    static $instance = null;

    public static function get_instance(){
        if( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        add_filter('woocommerce_update_order_review_fragments', [$this, 'stopReloadDoAjax']);

        add_filter('woocommerce_available_payment_gateways', array($this,'filterGateways'), PHP_INT_MAX - 10);
    }

    
    function stopReloadDoAjax($fragments){
        if (WC()->session->get('stop_reload_do_ajax_again') === true) {
            $fragments['stop_reload_do_ajax_again'] = '1';
            WC()->session->set( 'stop_reload_do_ajax_again', null );
        }
        return $fragments;
    }

    function filterGateways($gateways){
        
        $this->handleWrongPaymentMethod($gateways);
        
        return $gateways;
    }

    /**
     * Issue solved: Payment method fee (applied to cash on delivery payment method) ws not removed when the payment method itself was been removed because of the selection of Partial payment option
     */
    function handleWrongPaymentMethod( $gateways ){
        $user_payment_method = \Pi_dpmw_Apply_fees::getUserSelectedPaymentMethod();
        $not_present = true;
        foreach($gateways as $key => $gateway){
            if($key == $user_payment_method || $user_payment_method === false){
                $not_present = false;
                break;
            }
        }

        if(!empty($gateways) && $not_present && function_exists('WC') && isset(WC()->session) && is_object(WC()->session)){
            WC()->session->set('chosen_payment_method', null);
            /**
             * inside the class-safety.php we use this to add a fragment in ajax response, and based on that ajax our js does a ajax call again to get the updated cart total
             */
            WC()->session->set( 'stop_reload_do_ajax_again', true );
        }

    }

}

PaymentSafety::get_instance();