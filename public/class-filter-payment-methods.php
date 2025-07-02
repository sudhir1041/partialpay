<?php

class pisol_dpmw_filter_payment_methods{

    public $warning_messages = [];

    function __construct(){
        add_filter('woocommerce_available_payment_gateways', [$this, 'filterPaymentMethods'], PHP_INT_MAX-20);
        add_filter('woocommerce_no_available_payment_methods_message', [$this, 'noPaymentMethodsMessage'], PHP_INT_MAX - 20);
    }

    function filterPaymentMethods($gateways){

        if (is_wc_endpoint_url('order-pay')) {
            $order_id_from_url = get_query_var('order-pay');
            $order = wc_get_order( $order_id_from_url );

            $matched_removal_rules = self::matchedDisablingRules( $order );

            $gateways = self::removeGateways($gateways, $matched_removal_rules);

            return $gateways;
    
        }

        $package = WC()->cart;
        $matched_removal_rules = $this->matchedDisablingRules( $package );

        $gateways = $this->removeGateways($gateways, $matched_removal_rules);

        $this->warning_messages = self::getWarningMessage($matched_removal_rules);
        if (!empty($this->warning_messages) ) {
            foreach ($this->warning_messages as $warning_message) {
                if(empty($gateways)){
                    $type = 'error';
                }else{
                    $type = 'notice';
                }
                
                $this->add_unique_wc_notice(esc_html($warning_message), $type);
            }

            if(empty($gateways) && $this->is_block_checkout_page()){
                $no_payment_method_message = get_option('pisol_dpmw_no_payment_method_warning', '');
                if (!empty($no_payment_method_message)) {
                    $this->add_unique_wc_notice(esc_html($no_payment_method_message), 'error');
                }
            }
        }

        return $gateways;
    }

    function is_block_checkout_page() {
        $checkout_page_id = wc_get_page_id('checkout');
        if (!$checkout_page_id) {
            return false;
        }

        $content = get_post_field('post_content', $checkout_page_id);
        return has_block('woocommerce/checkout', $content);
    }

    function add_unique_wc_notice($message, $type = 'error') {
        $notices = wc()->session->get('wc_notices', []);

        // Prevent duplicate notices by checking if message already exists
        if (!empty($notices[$type])) {
            foreach ($notices[$type] as $notice) {
                if (trim($notice['notice']) === trim($message)) {
                    return; // Duplicate found, skip adding
                }
            }
        }

        wc_add_notice($message, $type);
    }

    function matchedDisablingRules($package){
        $matched_methods = array();
        $args         = array(
            'post_type'      => 'pi_dpmw_rules',
            'posts_per_page' => - 1
        );
        $all_methods        = get_posts( $args );
        foreach ( $all_methods as $method ) {

            $type = get_post_meta($method->ID, 'pi_rule_type', true);

            if(!empty($type) && $type != 'disable') continue;

            if(!pisol_dpmw_CurrencyValid($method->ID)) continue;

            $is_match = $this->matchConditions( $method, $package );

            if ( $is_match === true ) {
                $matched_methods[] = $method;
            }
        }

        return $matched_methods;
    }

    function matchConditions( $method = array(), $package = array() ) {

        if ( empty( $method ) ) {
            return false;
        }

        if ( ! empty( $method ) ) {
            $method_eval_obj = new Pisol_dpmw_method_evaluation($method, $package);
            $final_condition_match = $method_eval_obj->finalResult();

            if ( $final_condition_match ) {
                return true;
            }
        }

        return false;
    }

    function removeGateways($gateways, $matched_removal_rules){
        foreach($matched_removal_rules as $rule){
            $remove_methods = get_post_meta($rule->ID, 'disable_payment_methods', true);

            foreach($remove_methods as $remove_method){
                if(isset($gateways[$remove_method])){
                    unset($gateways[$remove_method]);
                }
            }
        }
        return $gateways;
    }

    function noPaymentMethodsMessage($message){
        $warning_message = get_option('pisol_dpmw_no_payment_method_warning', '');
        if (!empty($warning_message)) {
            return esc_html($warning_message);
        }
        return $message;
    }

    static function getWarningMessage($matched_removal_rules){
        $warning_messages = [];
        foreach ($matched_removal_rules as $rule) {
            $warning_message = get_post_meta($rule->ID, 'pi_payment_hiding_warning_message', true);
            if (!empty($warning_message)) {
                $warning_messages[] = $warning_message;
            }
        }
        return array_unique($warning_messages);
    }
}

new pisol_dpmw_filter_payment_methods();