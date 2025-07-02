<?php

class pisol_dpmw_pro_rules{
    
    public $slug;

    function __construct($slug){
        $this->slug = $slug;
         /* this adds the condition in set of rules dropdown */
        add_filter("pi_".$this->slug."_condition", array($this, 'addRule'));
    }

    function addRule($rules){
        
        /*
        $rules['user_email'] = array(
            'name'=>__('User Email Id (Available in PRO Version)','disable-payment-method-for-woocommerce'),
            'group'=>'user_related',
            'condition'=>'user_email',
            'desc' => 'This rule considers the billing email id of the order, and it can work even for the Guest customers. This rule is available in the PRO version of the plugin',
            'pro'=>true
        );
        */
        
        return $rules;
    }
}

new pisol_dpmw_pro_rules(PI_DPMW_SELECTION_RULE_SLUG);