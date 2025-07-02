<?php 

class Pi_dpmw_gateway_rules{

    static $instance = null;

    static function get_instance(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        add_filter('woocommerce_valid_order_statuses_for_payment', [__CLASS__, 'orderStatusThatAllowPayment'], 10, 2);
    }

    static function orderStatusThatAllowPayment($status, $order){
        /**
         * Cashfree payment method recheck if the order needs_payment or not, and needs_payment is only allowed for pending, failed order so to avoid issue we are adding 'partial-paid' status to the list so user can make partial-paid as default order status for partially paid orders
         */
        if($order->get_payment_method() == 'cashfree'){
            $status[] = 'partial-paid';
        }
        
        return $status;
    }

    static function allowPaymentMethodSwitching($order){
        $payment_method = $order->get_payment_method();
        /**
         * We are disable order type switching for cashfree payment method
         * as this payment method does not support order type switching
         */
        if($payment_method == 'cashfree'){
            if(function_exists( 'wc_get_logger' )){
                wc_get_logger()->error( 'You cant change Payment method for CashFree else the payment will be rejected', [ 'source' => 'Disable payment method'] );
            }

            return false;
        }

        return true;
    }
}

Pi_dpmw_gateway_rules::get_instance();