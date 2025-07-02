<?php 

namespace PISOL\DPMW;

class ConditionalJS{

    static $instance = false;

    static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    static $rules = false;

    static $conditions = [];

    function __construct()
    {
        add_action('wp_enqueue_scripts', [self::class, 'conditional_js']);
    }

    static function conditional_js()
    {
        self::email_change();
    }

    static function email_change(){

        if(!self::is_condition_present('user_email')) return;

        if(! (function_exists('is_checkout') && is_checkout()) ) return;

        $js = '
            jQuery(function($){
                $(document).on("blur", "#billing_email", function(){
                    jQuery("body").trigger("update_checkout");
                });
            });
        ';

        wp_add_inline_script('jquery', $js, 'after');
    }

    static function is_condition_present($condition){
        $active_rules = self::get_all_active_rules();
        $present = false;
        foreach($active_rules as $rule_id){
            if(self::is_condition_present_in_rule($rule_id, $condition)){
                $present = true;
                break;
            }
        }
        return $present;
    }

    static function get_all_active_rules(){

        if ( self::$rules !== false ) return self::$rules;

        $active_rules = [];

        $args         = array(
            'post_type'      => 'pi_dpmw_rules',
            'posts_per_page' => - 1
        );

        $all_methods        = get_posts( $args );

        foreach ( $all_methods as $method ) {

            $pi_status  = get_post_meta( $method->ID, 'pi_status', true );
				
			if ( isset( $pi_status ) && 'off' === $pi_status ) continue;

            $active_rules[] = $method->ID;
        }

        self::$rules = $active_rules;

        return $active_rules;
    }

    static function is_condition_present_in_rule($rule_id, $condition_to_search){

        if ( isset(self::$conditions[$rule_id])){
            $conditions = self::$conditions[$rule_id];
        }else{
            $conditions = get_post_meta($rule_id, 'pi_metabox', true);
            self::$conditions[$rule_id] = $conditions;
        }

        $present = false;

        if(!is_array($conditions)) return $present;

        foreach($conditions as $condition){
            if(isset($condition['pi_condition']) && $condition['pi_condition'] == $condition_to_search){
                $present = true;
                break;
            }
        }

        return $present;
    }
}

ConditionalJS::get_instance();