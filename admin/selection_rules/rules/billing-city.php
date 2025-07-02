<?php

class Pi_dpmw_selection_rule_billing_city{

    public $slug;
    public $condition;
    
    function __construct($slug){
        $this->slug = $slug;
        $this->condition = 'billing_city';
        /* this adds the condition in set of rules dropdown */
        add_filter("pi_".$this->slug."_condition", array($this, 'addRule'));
        
        /* this gives value field blank of populated */
        add_action( 'wp_ajax_pi_'.$this->slug.'_value_field_'.$this->condition, array( $this, 'ajaxCall' ) );


        add_filter('pi_'.$this->slug.'_saved_values_'.$this->condition, array($this, 'savedDropdown'), 10, 3);

        add_filter('pi_'.$this->slug.'_condition_check_'.$this->condition,array($this,'conditionCheck'),10,4);

        add_action('pi_'.$this->slug.'_logic_'.$this->condition, array($this, 'logicDropdown'));

        add_filter('pi_'.$this->slug.'_saved_logic_'.$this->condition, array($this, 'savedLogic'),10,3);
    }

    function addRule($rules){
        $rules[$this->condition] = array(
            'name'=>__('Billing City/Town', 'disable-payment-method-for-woocommerce'),
            'group'=>'billing_location_related',
            'condition'=>$this->condition
        );
        return $rules;
    }

    function logicDropdown(){
        $html = "";
        $html .= 'var pi_logic_'.$this->condition.'= "<select class=\'form-control\' name=\'pi_selection[{count}][pi_'.$this->slug.'_logic]\'>';
    
            $html .= '<option value=\'equal_to\'>Equal to ( = )</option>';
			$html .= '<option value=\'not_equal_to\'>Not Equal to ( != )</option>';
        
        $html .= '</select>";';
        echo wp_kses($html,
                array( 'select'=> array(
                        'name'=>array(), 
                        'class' => array()
                    )
                    ,
                    'option' => array(
                        'value' => array(),
                        'selected' => array()
                    ),
                    'optgroup' => array(
                        'label' => array()
                    )
                )
            );
    }

    function savedLogic($html_in, $saved_logic, $count){
        $html = "";
        $html .= '<select class="form-control" name="pi_selection['.$count.'][pi_'.$this->slug.'_logic]">';

            $html .= '<option value=\'equal_to\' '.selected($saved_logic , "equal_to",false ).'>Equal to ( = )</option>';
			$html .= '<option value=\'not_equal_to\' '.selected($saved_logic , "not_equal_to",false ).'>Not Equal to ( != )</option>';
        
        
        $html .= '</select>';
        return $html;
    }

    function ajaxCall(){
        $cap = class_exists('Pi_Dpmw_Menu') ? Pi_Dpmw_Menu::getCapability() : 'manage_options';
        if(!current_user_can( $cap )) {
            die();
        }
        $count = sanitize_text_field(filter_input(INPUT_POST,'count'));

        echo wp_kses(Pi_Dpmw_selection_rule_main::createTextField($count, $this->condition, null), array(
            'input' => array(
                'type' => array(),
                'name' => array(),
                'value' => array(),
                'id' => array(),
                'class' => array(),
                'step' => array(),
                'min' => array(),
                'max' => array(),
                'placeholder' => array(),
                'data-condition' => array(),
                'data-step' => array(),
                'data-logic' => array(),
                'required' => array(),
            )
        ));
        die();
    }

    function savedDropdown($html, $values, $count){
        $html = Pi_dpmw_selection_rule_main::createTextField($count, $this->condition,  $values);
        return $html;
    }

    function conditionCheck($result, $package, $logic, $values){
        
                    $or_result = false;
                    $cart_city = $this->get_user_city($package);
                    $rules = isset($values[0]) && !empty($values[0]) ? $values[0] : "";
                    if(empty($rules)) return $or_result;

                    $city_matched = $this->cityMatched( $cart_city, $rules);
                    
                    switch ($logic){
                        case 'equal_to':
                            if($city_matched){
                                $or_result = true;
                            }
                        break;

                        case 'not_equal_to':
                            if($city_matched){
                                $or_result = false;
                            }else{
                                $or_result = true;
                            }
                        break;
                    }
               
        return  $or_result;
    }

    function get_user_city($package){
        $state = '';
        if(is_a($package, 'WC_Cart')){
            $state = function_exists('WC') && is_object(WC()->customer) ? WC()->customer->get_billing_city() : '';
        }elseif(is_a($package, 'WC_Order')){
            $state = $package->get_billing_city();
        }
        return $state;
    }

    function cityMatched( $cart_city, $rules_city){
        $cities_array = $this->getCities($rules_city);

        if(in_array(strtolower($cart_city), $cities_array)) return true;

        return false;
        
    }

    function getCities( $text_value ){
        $cities = array();
        $values = explode(',', $text_value);
        $cities = array_map( 'trim', $values );
        $cities = array_map( 'strtolower', $cities );
        return $cities;
    }
}

new Pi_dpmw_selection_rule_billing_city(PI_DPMW_SELECTION_RULE_SLUG);