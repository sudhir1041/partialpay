<?php
/*
v1.0.3
*/
if(!class_exists('pisol_dpmw_review')){
class pisol_dpmw_review{

    public $title;
    public $slug;
    public $activation_date;
    public $saved_value;
    public $review_url;
    public $review_after;
    public $buy_url;
    public $price;
    public $allowed_tags = array();
        
    function __construct($title, $slug, $buy_url = '', $price = '' ){
        if(function_exists('is_admin') && is_admin()){
        $this->title = $title;
        $this->slug = $slug;
        $this->activation_date = "pi_review_activation_date_{$this->slug}";
        $this->saved_value = "pi_review_saved_value_{$this->slug}";
        $this->review_url = "https://wordpress.org/support/plugin/{$this->slug}/reviews/?rate=5#new-post";
        $this->review_after = 6;
        $this->buy_url = $buy_url;
        $this->price = $price;

        $allowed_atts = array(
            'align'      => array(),
            'class'      => array(),
            'selected'   => array(),
            'multiple'   => array(),
            'checked'    => array(),
            'type'       => array(),
            'id'         => array(),
            'dir'        => array(),
            'lang'       => array(),
            'style'      => array(),
            'xml:lang'   => array(),
            'src'        => array(),
            'alt'        => array(),
            'href'       => array(),
            'rel'        => array(),
            'rev'        => array(),
            'target'     => array(),
            'novalidate' => array(),
            'type'       => array(),
            'value'      => array(),
            'name'       => array(),
            'tabindex'   => array(),
            'action'     => array(),
            'method'     => array(),
            'for'        => array(),
            'width'      => array(),
            'height'     => array(),
            'data'       => array(),
            'title'      => array(),
            'min'        => array(),
            'max'        => array(),
            'step'        => array(),
            'required'   => array(),
            'readonly'   => array(),
        );
        $this->allowed_tags['form']     = $allowed_atts;
        $this->allowed_tags['br']     = $allowed_atts;
        $this->allowed_tags['label']    = $allowed_atts;
        $this->allowed_tags['input']    = $allowed_atts;
        $this->allowed_tags['select']    = $allowed_atts;
        $this->allowed_tags['option']    = $allowed_atts;
        $this->allowed_tags['textarea'] = $allowed_atts;
        $this->allowed_tags['iframe']   = $allowed_atts;
        $this->allowed_tags['script']   = $allowed_atts;
        $this->allowed_tags['style']    = $allowed_atts;
        $this->allowed_tags['strong']   = $allowed_atts;
        $this->allowed_tags['small']    = $allowed_atts;
        $this->allowed_tags['table']    = $allowed_atts;
        $this->allowed_tags['span']     = $allowed_atts;
        $this->allowed_tags['abbr']     = $allowed_atts;
        $this->allowed_tags['code']     = $allowed_atts;
        $this->allowed_tags['pre']      = $allowed_atts;
        $this->allowed_tags['div']      = $allowed_atts;
        $this->allowed_tags['img']      = $allowed_atts;
        $this->allowed_tags['h1']       = $allowed_atts;
        $this->allowed_tags['h2']       = $allowed_atts;
        $this->allowed_tags['h3']       = $allowed_atts;
        $this->allowed_tags['h4']       = $allowed_atts;
        $this->allowed_tags['h5']       = $allowed_atts;
        $this->allowed_tags['h6']       = $allowed_atts;
        $this->allowed_tags['ol']       = $allowed_atts;
        $this->allowed_tags['ul']       = $allowed_atts;
        $this->allowed_tags['li']       = $allowed_atts;
        $this->allowed_tags['em']       = $allowed_atts;
        $this->allowed_tags['hr']       = $allowed_atts;
        $this->allowed_tags['br']       = $allowed_atts;
        $this->allowed_tags['tr']       = $allowed_atts;
        $this->allowed_tags['td']       = $allowed_atts;
        $this->allowed_tags['p']        = $allowed_atts;
        $this->allowed_tags['a']        = $allowed_atts;
        $this->allowed_tags['b']        = $allowed_atts;
        $this->allowed_tags['i']        = $allowed_atts;

        //update_option($this->saved_value, array('preference'=> 'later', 'update_at'=>'2021/06/10'));
        //delete_option($this->saved_value);
        
        add_action( 'admin_notices', array($this, 'display_admin_notice'),20 );
        add_action( "admin_post_pi_save_review_preference_{$this->slug}", array($this, 'savePreference'),20 );
        }
    }

    function display_admin_notice() {
    
        $options = get_option($this->saved_value);

        $activation_time = $this->getInstallationDate();

        $notice = '<div class="notice notice-error is-dismissible">';
        $notice .= '<style>.pisol-review-btn {
            display: block;
            padding: 10px 15px;
            color: #FFF;
            text-decoration: none;
            border-radius: 2px;
        }
        
        .pi-active-btn {
            background-color: #00adb5;
        }
        
        .pi-passive-btn {
            background-color: #ccc;
        }

        .pi-buy-now-btn {
            background-color: #ee6443;
        }

        .pi-flex{
            display:flex;
            align-items:center;
        }
        </style>';
        $notice .= '<div class="pi-flex">';
        $notice .= '<img style="max-width:90px; height:auto;" src="'.plugin_dir_url( __FILE__ ).'review-icon.svg" alt="pi web solution">';
        $notice .= '<div style="margin-left:20px;">';
        /* translators: Plugin title */
        $notice .= '<p>'.sprintf(__("Hi there, You've been using <strong>%s</strong> on your site for a few days <br>- I hope it's been helpful. If you're enjoying my plugin, would you mind rating it 5-stars to help spread the word?", 'disable-payment-method-for-woocommerce'), $this->title).'</p>';
        $notice .= '<ul class="pi-flex" style="margin-top:15px;
        grid-template-columns: 1fr 1fr 1fr;
        grid-column-gap: 20px;
        text-align: center;">';
        $notice .= '<li><a val="later" class="pi-active-btn pisol-review-btn" href="'.add_query_arg(array('action' => "pi_save_review_preference_{$this->slug}", 'preference'=>'later',  '_wpnonce'=>wp_create_nonce( "pi_save_review_preference_{$this->slug}" )), admin_url('admin-post.php')).'">'.__("Remind me later", 'disable-payment-method-for-woocommerce').'</a></li>';
        $notice .= '<li><a  class="pi-active-btn pisol-review-btn" style="font-weight:bold;" val="given" href="'.add_query_arg(array('action' => "pi_save_review_preference_{$this->slug}", 'preference'=>'now','_wpnonce'=>wp_create_nonce( "pi_save_review_preference_{$this->slug}" )), admin_url('admin-post.php')).'" target="_blank">'.__("Review Here", 'disable-payment-method-for-woocommerce').'</a></li>';
        $notice .= '<li><a  class="pi-passive-btn pisol-review-btn" val="never" href="'.add_query_arg(array('action' => "pi_save_review_preference_{$this->slug}", 'preference'=>'never', '_wpnonce'=>wp_create_nonce( "pi_save_review_preference_{$this->slug}" )), admin_url('admin-post.php')).'">'.__("I would not", 'disable-payment-method-for-woocommerce').'</a></li>';	 
        if($this->buy_url && $this->price){   
            /* translators: Price */    
            $notice .= '<li><a target="_blank" class="pi-buy-now-btn pisol-review-btn" val="never" href="'.esc_url($this->buy_url).'&utm_ref=review_reminder">'.sprintf(__("BUY PRO FOR %s", 'disable-payment-method-for-woocommerce'), $this->price).'</a></li>';	
        }        
        $notice .= '</ul>';
        $notice .= '</div>';
        $notice .= '</div>';
        $notice .= '</div>';
        
        if(!$options && current_time('timestamp') >= strtotime($activation_time." +{$this->review_after} days")){
            echo wp_kses($notice, $this->allowed_tags);
        } else if(is_array($options)) {
            if( array_key_exists('preference', $options) && array_key_exists('update_at', $options) && $options['preference'] =='later'){ 
                if($this->validateDate($options['update_at']) && current_time('timestamp') >= strtotime($options['update_at']." +{$this->review_after} days")){
                    echo wp_kses($notice, $this->allowed_tags);
                }
            }
        }
    }

    function savePreference(){
            $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field( wp_unslash($_GET['_wpnonce'] )) : '' ;
            $preference = isset($_GET['preference']) ? sanitize_text_field( wp_unslash( $_GET['preference'] )) : 'later';

            if(!isset($_GET['_wpnonce']) || !wp_verify_nonce($nonce,"pi_save_review_preference_{$this->slug}")){
                wp_die(esc_html('Link has expired'), '', array('response' => 403));
            }

            $values['update_at'] = current_time('Y/m/d');
            switch($preference){
                case 'later':
                    $values['preference'] = 'later';
                    $redirect = admin_url('index.php');
                    break;
                    
                case 'now':
                    $values['preference'] = 'now';
                    $redirect = $this->review_url;
                    break;
                        
                case 'never':
                    $values['preference'] = 'never';
                    $redirect = admin_url('index.php');
                    break;
            }
            update_option($this->saved_value, $values);
            wp_redirect($redirect);
    }

    function getInstallationDate(){
        $get_install_date = get_option($this->activation_date);
        if(empty($get_install_date) || !$this->validateDate($get_install_date)){
            $now = current_time( "Y/m/d" );
            add_option( $this->activation_date, $now );
            return $now;
        }
        return $get_install_date;
    }

    function validateDate($date, $format = 'Y/m/d'){
        if ( empty($date) ) return false;
        
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}

new pisol_dpmw_review('Disable payment method for WooCommerce plugin', 'disable-payment-method-for-woocommerce',DISABLE_PAYMENT_METHOD_FOR_WOOCOMMERCE_BUY_URL, DISABLE_PAYMENT_METHOD_FOR_WOOCOMMERCE_PRICE);
}