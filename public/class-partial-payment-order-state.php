<?php

class Pi_dpmw_partial_payment_order_state{
    protected static $instance = null;

    public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    protected function __construct(){
        add_action('woocommerce_order_status_changed', [$this, 'stateManager'], 10, 4);
    }

    function stateManager($order_id, $from, $to, $order){
        $type = $order->get_type( );

        if($type == 'pi_pending_amt'){
            $parent_order_id = $order->get_parent_id();
            $parent_order = wc_get_order( $parent_order_id );
            if(Pi_dpmw_partial_payment::is_deposit_payment_order( $order_id )){
                
                $same_state = ['pending', 'on-hold', 'cancelled', 'failed', 'refunded', 'processing'];
                if(in_array($to, $same_state)){
                    $parent_order->set_status($to);
                    $parent_order->save();
                }elseif($to == 'completed'){
                    $default_status = 'partial-paid';
                    $default_wanted = get_option('pi_dpmw_default_order_status','partial-paid');
                    $present_status = $parent_order->get_status();
                    if($default_wanted != $present_status){
                        $parent_order->set_status( $default_status );
                        $parent_order->save();
                    }
                }

            } elseif ( Pi_dpmw_partial_payment::is_remaining_payment_order( $order_id ) ) {
                if ( $to === 'completed' ) {
                    $parent_order->set_status( 'processing' );
                    $parent_order->add_order_note( __( 'Remaining payment received.', 'disable-payment-method-for-woocommerce' ) );
                    $parent_order->save();

                    /**
                     * Allow third parties to generate final invoice.
                     */
                    do_action( 'pi_dpmw_second_payment_completed', $parent_order );
                }
            }
        }
    }

}
Pi_dpmw_partial_payment_order_state::get_instance();
