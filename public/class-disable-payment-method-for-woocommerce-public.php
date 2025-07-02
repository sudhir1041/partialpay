<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       piwebsolution.com
 * @since      1.0.0
 *
 * @package    Disable_Payment_Method_For_Woocommerce
 * @subpackage Disable_Payment_Method_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Disable_Payment_Method_For_Woocommerce
 * @subpackage Disable_Payment_Method_For_Woocommerce/public
 * @author     PI Websolution <sales@piwebsolution.com>
 */
class Disable_Payment_Method_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Disable_Payment_Method_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Disable_Payment_Method_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Disable_Payment_Method_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Disable_Payment_Method_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/disable-payment-method.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/style.css', $this->version );

		if(is_checkout()){
			$css = '
				.pi-cod-deposit-container{
					background-color: '.get_option('pi_dpmw_pp_bg_color','#ffffff').';
					color: '.get_option('pi_dpmw_pp_txt_color','#000000').';
					border-color: '.get_option('pi_dpmw_pp_border_color','#000000').';
				}

				.pi-cod-deposit-container:hover .pi-checkmark {
						background-color: '.get_option('pi_dpmw_pp_checkbox_hover_bg_color','#ffffff').';
				}
			';

			$style = get_option('pi_dpmw_pp_checkbox_style','border');
			if($style == 'border'){
				$css .= '
					.pi-checkmark{
						background-color: '.get_option('pi_dpmw_pp_checkbox_bg_color','#ffffff').';
						border:1px solid '.get_option('pi_dpmw_pp_checkbox_border_color','#000000').';
					}

					.pi-cod-deposit-container input:checked+.pi-checkmark {
						background: '.get_option('pi_dpmw_pp_checkbox_checked_bg_color','#ffffff').';
						border: 6px solid '.get_option('pi_dpmw_pp_checkbox_checkmark_color','#ff0000').';
					}
				';
			}

			if($style == 'checkmark'){
				$css .= '

					.pi-checkmark{
						background-color: '.get_option('pi_dpmw_pp_checkbox_bg_color','#ffffff').';
						border:1px solid '.get_option('pi_dpmw_pp_checkbox_border_color','#000000').';
						display:inline-flex;
						justify-content:center;
						align-items:center;
					}

					.pi-cod-deposit-container input:checked+.pi-checkmark {
						background: '.get_option('pi_dpmw_pp_checkbox_checked_bg_color','#ffffff').';
					}
					
					.pi-cod-deposit-container input:checked+.pi-checkmark:after {
						content:"✓";
						text-align:center;
						color:'.get_option('pi_dpmw_pp_checkbox_checkmark_color','#ff0000').';
						font-weight:bold;
					}
				';
			}
			
			wp_add_inline_style( $this->plugin_name, $css );
		}
	}

}
