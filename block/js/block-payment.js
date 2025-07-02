/**
 * when the block loads set-active-payment-method is not called by WooCommerce core so we have added this to call that hook so that we can set the payment method in the backend on loading
 */
wp.hooks.addAction('experimental__woocommerce_blocks-checkout-render-checkout-form', 'woocommerce-block-checkout', () => {
    // Subscribe to changes in the PAYMENT_STORE_KEY
    const unsubscribe = wp.data.subscribe(() => {
        const paymentStore = wp.data.select(wc.wcBlocksData.PAYMENT_STORE_KEY);
        
        if (paymentStore) {
            const payment_method = paymentStore.getActivePaymentMethod();
            if (payment_method) {
                //console.log('payment_method', payment_method);

                // Trigger your custom action with the payment method data
                var data = { 'value': payment_method };
                wp.hooks.doAction('pisol_initial_checkout_load', data);

                // Unsubscribe after getting the payment method to prevent multiple calls
                unsubscribe();
            }
        }
    });
});

/**
 * this reads the hook of set-active-payment-method and then update the payment method in the backend
 */
wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-active-payment-method', 'woocommerce-block-checkout', (data) => {
    if(!pisol_dpmw_payment_block.payment_change_trigger) return;

    let payment_method = '';
    if(data.value){
       payment_method = data.value;
    }else{
       payment_method = data.paymentMethodSlug;
    }

    pisol_set_payment_method(payment_method);
}); 

wp.hooks.addAction('pisol_initial_checkout_load', 'woocommerce-block-checkout', (data) => {
    pisol_set_payment_method(data.value);
});

function pisol_set_payment_method(payment_method){
    if (typeof payment_method == 'undefined') return;
    if (payment_method == '') return;
    var data = { payment_method: payment_method };
    document.body.classList.add('pi-dpmw-processing');
    wc.blocksCheckout.extensionCartUpdate({
        namespace: 'pisol_set_payment_method',
        data: data
    }).then( function(  ) {
        document.body.classList.remove('pi-dpmw-processing');
    });
}

