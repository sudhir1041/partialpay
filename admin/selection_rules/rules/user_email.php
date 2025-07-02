<?php

class Pi_dpmw_selection_rule_user_email{

    public $slug;
    public $condition;
    
    function __construct($slug){
        $this->slug = $slug;
        $this->condition = 'user_email';

        add_filter("pi_".$this->slug."_condition", array($this, 'addRule'));

        add_action( 'wp_ajax_pi_'.$this->slug.'_value_field_'.$this->condition, array( $this, 'ajaxCall' ) );

        add_filter('pi_'.$this->slug.'_saved_values_'.$this->condition, array($this, 'savedDropdown'), 10, 3);
        
        
        add_filter('pi_'.$this->slug.'_condition_check_'.$this->condition, array($this,'conditionCheck'),10,4);

        add_action('pi_'.$this->slug.'_logic_'.$this->condition, array($this, 'logicDropdown'));
        add_filter('pi_'.$this->slug.'_saved_logic_'.$this->condition, array($this, 'savedLogic'),10,3);
    }

    function addRule($rules){
        $rules[$this->condition] = array(
            'name'=>__('User email', 'disable-payment-method-for-woocommerce'),
            'group' => "user_related",
            'condition'=>$this->condition,
            'desc' => 'This allows you to disable payment method based on user email id, so it also works for guest customer as well'       
        );
        return $rules;
    }

    function logicDropdown(){
        $html = "";
        $html .= 'var pi_logic_'.$this->condition.'= "<select class=\'form-control\' name=\'pi_selection[{count}][pi_'.$this->slug.'_logic]\'>';
        
        $html .= '<option value=\'equal_to\'>Equal to (=)</option>';
        $html .= '<option value=\'not_equal_to\'>Not Equal to (!=)</option>';
       
        
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
        
            $html .= '<option value="equal_to" '.selected($saved_logic , "equal_to",false ).'>Equal to (=)</option>';
            $html .= '<option value="not_equal_to" '.selected($saved_logic , "not_equal_to",false ).'>Not Equal to (!=)</option>';
           
        
        $html .= '</select>';
        return $html;
    }


    function ajaxCall(){
        $cap = Pi_dpmw_Menu::getCapability();
        if(!current_user_can( $cap )) {
            return;
            die;
        }
        $count = filter_input(INPUT_POST,'count',FILTER_VALIDATE_INT);
        echo wp_kses( Pi_dpmw_selection_rule_main::createTextField($count, $this->condition,  null), array(
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
        die;
    }

    function savedUsers($values){
        $saved_users = array();
        if(is_array($values)){
            foreach($values as $value){
                $user_obj = get_user_by("ID",$value);
                if(!is_object($user_obj)){
                    $saved_users[$value] = 'ID: '.$value;
                    continue;
                }
                $saved_users[$user_obj->ID] = $user_obj->display_name;
            }
        }
        
        return $saved_users;
    }

    function savedDropdown($html, $values, $count){
        $html = Pi_dpmw_selection_rule_main::createTextField($count, $this->condition,  $values);
        return $html;
    }


    function conditionCheck($result, $package, $logic, $values){
        
        $or_result = false;
        $user_email = self::get_user_email($package);
        $rule_emails = self::get_rule_emails($values[0] ?? '');
        
        if($logic == 'equal_to'){
            if(in_array($user_email, $rule_emails)){
                $or_result = true;
            }else{
                $or_result = false;
            }
        }else{
            if(!in_array($user_email, $rule_emails)){
                $or_result = true;
            }else{
                $or_result = false;
            }
        }
        
        return  $or_result;    
       
    }

    function get_user_email($package){
        
        if(is_a($package, 'WC_Cart')){
            if(!isset($_POST['post_data']) && !isset($_POST['billing_email'])) return false;
            
            if(isset($_POST['billing_email'])){
                $values['billing_email'] = sanitize_email(wp_unslash($_POST['billing_email']));
            }else{
                // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
                parse_str($_POST['post_data'], $values);
            }
            
            if(!empty($values['billing_email'])){
                return strtolower($values['billing_email']);
            }
        }elseif(is_a($package, 'WC_Order')){
            return strtolower($package->get_billing_email());
        }

        return false;
    }

    static function get_rule_emails($value){
        $emails = explode(',', $value);
        $emails = array_map('trim', $emails);
        $emails = array_map('strtolower', $emails);
        return [$emails[0]];
    }

}

new Pi_dpmw_selection_rule_user_email(PI_DPMW_SELECTION_RULE_SLUG);