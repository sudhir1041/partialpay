<?php

class pisol_dpmw_options{

    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'cod_deposit';

    private $tab_name = "Partial payment for order";

    private $setting_key = 'dpmw_cod_deposit_setting';
    
    public $tab;

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;


        $this->settings = array(
           
            
            array('field'=>'pi_dpmw_enable_partial_payment', 'label'=>__('Enable partial payment for order', 'disable-payment-method-for-woocommerce'), 'desc'=>__('When enabled you can collect some amount from the customer as partial payment for order', 'disable-payment-method-for-woocommerce'), 'type'=>'switch', 'default'=>"0"),

            array('field'=>'pi_dpmw_auto_remove_coupons', 'label'=>__('Remove coupons when partial payment selected', 'disable-payment-method-for-woocommerce'), 'desc'=>__('If enabled, all applied coupons will be removed when a customer opts for partial payment and the option will be hidden when coupons are active.', 'disable-payment-method-for-woocommerce'), 'type'=>'switch', 'default'=>'1'),

            array('field'=>'pi_dpmw_partial_amt_calculation', 'label'=>__('Partial payment based on', 'disable-payment-method-for-woocommerce'), 'desc'=>__('How the partial payment amount will be calculated', 'disable-payment-method-for-woocommerce'), 'type'=>'dpmw_custom_select', 'default'=>"fixed", 'value'=>['fixed' => 'Fixed amount', 'percentage' => 'Percentage of Total', 'shipping_percentage' => 'Shippig charege percentage'], 'pro_options' => ['shipping_percentage']),

            array('field'=>'pi_dpmw_partial_amt', 'label'=>__('Partial payment', 'disable-payment-method-for-woocommerce'), 'desc'=>__('partial payment amt will be flat amount or percent of the total or (in pro it can be Shipping amount)', 'disable-payment-method-for-woocommerce'), 'type'=>'text', 'default'=>"0"),

            array('field'=>'pi_dpmw_partial_payment_fee_pro', 'type' => 'dpmw_partial_payment_fee_pro'),

            array('field'=>'pi_dpmw_charge_partial_fee_upfront','label'=>__('Charge partial fee upfront', 'disable-payment-method-for-woocommerce'), 'desc'=>__('When you enable this option, the Partial Payment Fee will be added to the initial partial payment that the customer makes. For example, if you set the Partial Payment amount to $100 and the Partial Payment Fee to $60, then with this option enabled, the customer will need to pay $160 at checkout. However, if this option is disabled, the customer will only pay $100 upfront, and the $60 fee will be included in the remaining balance.', 'disable-payment-method-for-woocommerce'),'type'=>'switch','default'=> '0', 'pro' => true),

            array('field'=>'pi_dpmw_remove_payment_methods','label'=>__('Remove payment method when partial payment enabled', 'disable-payment-method-for-woocommerce'), 'desc'=>__('Remove Payment methods for when partial payment option is enabled', 'disable-payment-method-for-woocommerce'),'type'=>'multiselect','default'=>array('cod'), 'value'=>$this->paymentMethods()),

            array('field'=>'pi_dpmw_remove_payment_methods_selected','label'=>__('Remove payment method when partial payment selected', 'disable-payment-method-for-woocommerce'), 'desc'=>__('Remove Payment methods for when partial payment option is selected by the customer during checkout', 'disable-payment-method-for-woocommerce'),'type'=>'multiselect','default'=>array('cod'), 'value'=>$this->paymentMethods()),

            array('field'=>'pi_dpmw_default_order_status','label'=>__('Default order status of partially paid order', 'disable-payment-method-for-woocommerce'), 'desc'=>__('This will be the order status of the main order once it is partially paid ', 'disable-payment-method-for-woocommerce'),'type'=>'select','default'=> 'partial-paid', 'value'=> $this->order_status()),

            array('field'=>'pi_dpmw_excluded_products','label'=>__('Exclude product from partial payment', 'disable-payment-method-for-woocommerce'), 'desc'=>__('User will have to pay this product total amount even when they select for partial payment, It is just like you are excluding this product to be part of partial payment option E.g: if you set 10 as partial payment amount and there is no excluded product then user will pay 10 and checkout, but if there is some excluded product and non excluded product in the cart excluded product is of 20, so now user will pay 10+20 = 30 and then checkout, so he will be paying in full for the excluded product', 'disable-payment-method-for-woocommerce'),'type'=>'multiselect','default'=>array(), 'value'=>[], 'pro'=>true),

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Labels", 'disable-payment-method-for-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_dpmw_partial_payment_title_checkout', 'label'=>__('Partial payment for the order', 'disable-payment-method-for-woocommerce'),'type'=>'text', 'default'=>'Partial payment for the order',  'desc'=>__('This label is shown on the checkout page next to the partial payment checkbox', 'disable-payment-method-for-woocommerce')),

            array('field'=>'pi_dpmw_txt_to_pay', 'label'=>__('To Pay', 'disable-payment-method-for-woocommerce'),'type'=>'text', 'default'=>'To Pay',  'desc'=>__('This label is shown on the checkout page next to the amount that has to be paid now', 'disable-payment-method-for-woocommerce')),

            array('field'=>'pi_dpmw_balance_to_pay', 'label'=>__('Due Payment', 'disable-payment-method-for-woocommerce'),'type'=>'text', 'default'=>'Due Payment',  'desc'=>__('This label is shown on the checkout page next to the amount that has to be paid afterwords', 'disable-payment-method-for-woocommerce')),

            array('field'=>'pi_dpmw_paid_amt', 'label'=>__('Paid amount', 'disable-payment-method-for-woocommerce'),'type'=>'text', 'default'=>'Paid amount',  'desc'=>__('This label is shown on the thank your page and order email next to the amount paid', 'disable-payment-method-for-woocommerce')),

            array('field'=>'pi_dpmw_balance_amt', 'label'=>__('Balance amount', 'disable-payment-method-for-woocommerce'),'type'=>'text', 'default'=>'Balance amount',  'desc'=>__('This label is shown on the thank your page and order email next to the amount remaining to be paid', 'disable-payment-method-for-woocommerce')),

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Designing option for partial payment option", 'disable-payment-method-for-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_dpmw_pp_bg_color', 'label'=>__('Background color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#ffffff',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_border_color', 'label'=>__('Border color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#000000',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_txt_color', 'label'=>__('Text color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#000000',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_bg_color', 'label'=>__('Checkbox background color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#ffffff',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_border_color', 'label'=>__('Checkbox border color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#000000',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_hover_bg_color', 'label'=>__('Checkbox mouse over background color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#ffffff',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_checked_bg_color', 'label'=>__('Checkbox checked background color', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#ffffff',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_checkmark_color', 'label'=>__('Checkbox checkmark color ', 'disable-payment-method-for-woocommerce'),'type'=>'color', 'default'=>'#ff0000',  'desc'=>''),

            array('field'=>'pi_dpmw_pp_checkbox_style', 'label'=>__('Checkbox style', 'disable-payment-method-for-woocommerce'),'type'=>'select', 'default'=>'border',  'value'=>array('border' => 'Border selection', 'checkmark' => 'Show Checkmark on selection'), 'desc'=>''),
        );
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';
        
        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }


        add_action($this->plugin_name.'_tab', array($this,'tab'),10);

       
        $this->register_settings();

        add_filter( 'pre_update_option_pi_dpmw_partial_amt', [$this, 'onlyNumeric']);

    }

    
    function register_settings(){   

        foreach($this->settings as $setting){
            //phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
            register_setting( $this->setting_key, $setting['field'], array( $this, 'sanitize_setting' ) );
        }
    
    }

    function sanitize_setting( $input ) {
        if ( is_array( $input ) ) {
            // Sanitize each element in the array
            return array_map( 'sanitize_text_field', $input );
        } else {
            // Sanitize string
            return sanitize_text_field( $input );
        }
    }

    function tab(){
        $page = sanitize_text_field(filter_input( INPUT_GET, 'page'));
        ?>
        <a class=" px-3 py-2 text-light d-flex align-items-center  border-left border-right  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo esc_url(admin_url( 'admin.php?page='.$page.'&tab='.$this->this_tab )); ?>">
            <?php echo esc_html( $this->tab_name ); ?> 
        </a>
        <?php
    }

    function tab_content(){
       ?>
        <div class="alert alert-info mt-3 mb-3" role="alert">
            <strong><?php _e('Note:', 'disable-payment-method-for-woocommerce'); ?></strong> <?php _e('Create conditional Partial payment option in PRO version, just like how you crate rules to disable payment method or apply fee to payment method in free version', 'disable-payment-method-for-woocommerce'); ?>
        </div>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
            foreach($this->settings as $setting){
                new pisol_class_form_dpmw($setting, $this->setting_key);
            }
        ?>
        <input type="submit" class="mt-3 btn btn-primary btn-sm" value="Save Option" id="pi-dpmw-new-rule"/>
        </form>
       <?php
    }

    function paymentMethods(){
        if(!(isset($_GET['page']) && $_GET['page'] == 'pisol-dpmw-settings')) return array();
        $gateways = WC()->payment_gateways->payment_gateways();
        $enabled_gateways = [];

        if( !empty($gateways) ) {
            foreach( $gateways as $gateway ) {

                if( $gateway->enabled == 'yes' ) {

                    $enabled_gateways[$gateway->id] = $gateway->title;

                }
            }
        }
        return apply_filters('pisol_dpmw_payment_method_list',$enabled_gateways);
    }

    function onlyNumeric( $input ) {
        $output = '';
    
        // Check if input is numeric
        if ( is_numeric( $input ) ) {
            // If numeric, sanitize input and return
            $output = sanitize_text_field( $input );
        } else {
            // If non-numeric, add error message
            add_settings_error(
                'pi_dpmw_partial_amt',
                'pi_dpmw_partial_amt',
                'Please enter a numeric value for the Partial payment.'
            );
        }
    
        return $output;
    }

    function order_status(){
        $order_status = wc_get_order_statuses();
        $processed = array();
        foreach($order_status as  $key => $val){
            $new_key = str_replace('wc-','',$key);
            $processed[$new_key] = $val;
        }
        return $processed;
    }
}

add_action('wp_loaded', function(){
    new pisol_dpmw_options($this->plugin_name);
});
