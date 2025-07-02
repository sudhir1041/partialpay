<?php

class pisol_dpmw_CustomFields{

    static $instance = null;

    public $allowed_tags;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    } 

    function __construct()
    {
        $this->allowed_tags =  wp_kses_allowed_html('post');

        $this->allowed_tags['input'] = array(
            'type'        => true,
            'name'        => true,
            'value'       => true,
            'class'       => true,
            'id'          => true,
            'placeholder' => true,
            'checked'     => true,
            'readonly'    => true,
            'disabled'    => true,
            'size'        => true,
            'maxlength'   => true,
            'min'         => true,
            'max'         => true,
            'step'        => true,
            'pattern'     => true,
            'required'    => true,
            'autocomplete'=> true,
            'autofocus'   => true,
        );

        $this->allowed_tags['select'] = array(
            'name'        => true,
            'id'          => true,
            'class'       => true,
            'multiple'    => true,
            'size'        => true,
            'disabled'    => true,
        );
        $this->allowed_tags['option'] = array(
            'value'       => true,
            'selected'    => true,
            'disabled'    => true,
            'label'       => true,
        );

        add_action('pisol_custom_field_dpmw_custom_select', array($this,'custom_select'), 10, 2);
        add_action('pisol_custom_field_dpmw_partial_payment_fee_pro', array($this,'dpmw_partial_payment_fee_pro'), 10, 2);
        
    }

    function custom_select($setting, $saved_value){

        $label = '<label class="h6 mb-0" for="'.esc_attr($setting['field']).'">'.wp_kses_post($setting['label']).'</label>';
        $desc = (isset($setting['desc'])) ? '<br><small>'.wp_kses($setting['desc'], $this->allowed_tags).'</small>' : "";
        
        $field = '<select class="form-control " name="'.esc_attr($setting['field']).'" id="'.esc_attr($setting['field']).'"'
            .(isset($setting['multiple']) ? ' multiple="'.esc_attr($setting['multiple']).'"': '')
        .'>';
            foreach($setting['value'] as $key => $val){
                $field .= '<option value="'.esc_attr($key).'" 
                '.( ( $saved_value == $key) ? " selected=\"selected\" " : "" ).
                (in_array($key, $setting['pro_options']) ? ' disabled="disabled" ' : '' ).
                '>'.(in_array($key, $setting['pro_options']) ? ' 🔒 ' : '' ).' '.esc_html($val).'</option>';
            }
        $field .= '</select>';

        $this->bootstrap($setting, $label, $field, $desc, '', 6);
    }

    /**
     * Create a combined text field with dropdown
     * 
     * @param array $setting The field settings
     * @param mixed $saved_value The saved value for this field
     */
    function dpmw_partial_payment_fee_pro($setting, $saved_value){
        ?>
        <div id="row_pi_dpmw_partial_payment_fee_pro" class="row py-4 border-bottom align-items-center ">
            <div class="col-12 col-md-5">
                <label class="h6 mb-0" for="pi_dpmw_partial_payment_fee_pro_text">Partial payment fee</label>
                <br>
                <small>Charge extra fee when customer select partial payment option</small>
                <br>
            </div>
            <div class="col-12 col-md-7">
                <div class="input-group">
                    <input type="text" class="form-control" name="pi_dpmw_partial_payment_fee_pro[text]" id="pi_dpmw_partial_payment_fee_pro_text" value="" placeholder="🔒 Partial payment fee (PRO)" disabled="">
                    <select class="form-control" name="pi_dpmw_partial_payment_fee_pro[dropdown]" id="pi_dpmw_partial_payment_fee_pro_dropdown">
                        <option selected="" value="fixed" disabled=""> 🔒 Fee will be Fixed amount</option>
                        <option selected="" value="percentage_cart" disabled=""> 🔒 Cart Subtotal percentage</option>
                        <option selected="" value="percent_cart_subtotal_plus_shipping" disabled=""> 🔒 Fee is percentage of (Cart Subtotal + Shipping)</option>
                        <option selected="" value="percent_cart_subtotal_plus_shipping_minus_discount" disabled=""> 🔒 Fee is percentage of (Cart Subtotal + Shipping - Discount)</option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }

    function bootstrap($setting, $label, $field, $desc = "",$shortcode_html = '',  $title_col = 5){
        $setting_col = 12 - $title_col;
        ?>
        <div id="row_<?php echo esc_attr($setting['field']); ?>"  class="row py-4 border-bottom align-items-center <?php echo !empty($setting['class']) ? esc_attr($setting['class']) : ''; ?>">
            <div class="col-12 col-md-<?php echo esc_attr($title_col); ?>">
            <?php echo wp_kses_post($label, $this->allowed_tags); ?>
            <?php echo wp_kses_post($desc != "" ? $desc.'<br>': "", $this->allowed_tags); ?>
            <?php if(!empty($shortcode_html)): ?>
                <div class="mt-2">
                    <small><?php esc_html_e('Short codes:','pi-edd'); ?><br> <?php echo wp_kses($shortcode_html, $this->allowed_tags); ?></small>
                </div>
            <?php endif; ?>
            </div>
            <div class="col-12 col-md-<?php echo esc_attr($setting_col); ?>">
            <?php echo wp_kses($field, $this->allowed_tags); ?>
            </div>
        </div>
        <?php
    }
}

pisol_dpmw_CustomFields::get_instance();