<?php
/**
 * Plugin help
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Support help widget
 */
class Cx_Help
{

    // Allowed pages for showing the help menu
    private static $allowed_pages = ['couponx', 'add_couponx', 'couponx_pro_features', 'leads_list', 'cx_integrations', 'couponx_pricing_tbl']; 
    
    // constructor
    public function __construct() {    
     
        $page = $_GET['page'] ?? ''; 
        // Check if we're on one of those pages
        if (in_array($page, self::$allowed_pages, true)) {
            // register enqueue  css 
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts')); 
            // add need help in footer
            add_action('admin_footer', array($this, 'admin_footer_need_help_content'));
        } 
  
	}//end __construct()

    // load help settings
    public function load_help_settings(){
        define('WCP_CX_FOOTER_HELP_DATA', array(
            'help_icon' => esc_url(COUPON_X_URL."assets/img/help/help-icon.svg"),
            'close_icon' => esc_url(COUPON_X_URL."assets/img/help/close.svg"), 
            'premio_site_info' => esc_url('https://premio.io/'),
            'help_center_link' => esc_url('https://premio.io/help/coupon-x/?utm_source=pluginspage'),
            'footer_menu' => array( 
                'support' => array(
                    'title' => esc_html("Get Support", "coupon-x-discount-pop-up"),
                    'link' =>  esc_url("https://wordpress.org/support/plugin/coupon-x-discount-pop-up/"),
                    'status' => true,
                ),
                'upgrade_to_pro' => array(
                    'title' => esc_html("Upgrade to Pro", "coupon-x-discount-pop-up"),
                    'link' =>  esc_url(admin_url("admin.php?page=couponx_pricing_tbl")),
                    'status' => true,
                ),
                'recommended_plugins' => array(
                    'title' => esc_html("Recommended Plugins", "coupon-x-discount-pop-up"),
                    'link' =>  esc_url(admin_url("admin.php?page=cx-recommended-plugins")),
                    'status' => get_option("hide_couponx_plugins") ? false : true,
                ),  
            ),
            'support_widget' => array(
                'upgrade_to_pro' => array(
                    'title' => esc_html("Upgrade to Pro", "coupon-x-discount-pop-up"),
                    'link' =>  esc_url(admin_url("admin.php?page=couponx_pricing_tbl")),
                    'icon' => esc_url(COUPON_X_URL."assets/img/help/pro.svg"),
                ),
                'get_support' => array(
                    'title' => esc_html("Get Support", "coupon-x-discount-pop-up"),
                    'link' =>   esc_url("https://wordpress.org/support/plugin/coupon-x-discount-pop-up/"),
                    'icon' => esc_url(COUPON_X_URL."assets/img/help/help-circle.svg"),
                ),
                'contact' => array(
                    'title' => esc_html("Contact Us", "coupon-x-discount-pop-up"),
                    'link' =>  false,
                    'icon' => esc_url(COUPON_X_URL."assets/img/help/headphones.svg"),
                ),
            ),
        ));  
    }

    // enqueue scripts
    public function admin_enqueue_scripts(){ 
        // enqueue css
        wp_enqueue_style('coupon-x-help-css', COUPON_X_URL . 'assets/css/help.css', array(), COUPON_X_VERSION);   

    } 

    // Need Help Footer Content
    public function admin_footer_need_help_content(){ 
        $this->load_help_settings(); 

        include_once COUPON_X_PATH.'/inc/pages/help.php';
    } 

}//end class
new Cx_Help();
