<?php

class pi_dpmw_third_party_support{

    protected static $instance = null;

    public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    function __construct(){
        /**
         * adding Partial payment and paid order PDF invoice link in 
         * https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/
         */
        add_filter( 'wpo_wcpdf_meta_box_actions', [$this, 'addingPaidRemainingAmount'], 10, 2);

        // Generate a fresh invoice when the second payment is completed.
        add_action( 'pi_dpmw_second_payment_completed', [ $this, 'generate_full_invoice' ] );
    }

    function addingPaidRemainingAmount($meta_box_actions, $post_id ){
        $order = wc_get_order( $post_id );

        if(empty($order) || !is_object($order)) return $meta_box_actions;

        $args = array(
            'type'   => 'pi_pending_amt',
            'parent' => $post_id,
        );

        $depositList = wc_get_orders( $args );
        if(!empty($depositList)){
            foreach ( $depositList as $key => $depositOrder ) {
                $type = $depositOrder->get_meta('_deposit_order_type', true);
                $title = '';
                if($type == 'pending_payment'){
                    $title = 'Pending Payment';
                }elseif($type == 'deposit_payment'){
                    $title = 'Deposit Payment';
                }
                $pdf_url        = WPO_WCPDF()->endpoint->get_document_link( $depositOrder, 'invoice' );
                $meta_box_actions[$key] = array(
					'url'		=> esc_url( $pdf_url ),
					'alt'		=> "PDF Invoice ".$title,
					'title'		=> "PDF Invoice ".$title,
					'exists'	=>  false,
				);
            }
        }

        return $meta_box_actions;
    }

    /**
     * Create a new invoice for the parent order once the remaining payment is paid.
     * This requires the WooCommerce PDF Invoices & Packing Slips plugin.
     */
    function generate_full_invoice( $order ){
        if( class_exists( 'WPO_WCPDF' ) ){
            $document = WPO_WCPDF()->documents->get_document( 'invoice', $order );
            if ( $document ) {
                $document->create();
            }
        }
    }
}
pi_dpmw_third_party_support::get_instance();
