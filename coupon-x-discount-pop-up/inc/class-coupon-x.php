<?php
/**
 * Register scripts and load templates
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Dashboard functions of Coupon X
 */
class Coupon_X
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('admin_init', [ $this, 'redirect_user_to_settings_page' ]);
        add_action('admin_init', [ $this, 'change_menu_text' ]);
        add_action('plugins_loaded', [ $this, 'load_domain_files' ]);
        $this->files_loader();

    }//end __construct()


    public function change_menu_text()
    {
        global $submenu;
        if(isset($submenu['couponx'])) {
            $totalItems = count($submenu['couponx'])-1;
            if(isset($submenu['couponx'][$totalItems][0])) {
                $submenu['couponx'][$totalItems][0] = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.0518 4.01946C12.9266 3.91499 12.7747 3.84781 12.6132 3.82557C12.4517 3.80333 12.2872 3.82693 12.1385 3.89367L9.3713 5.12414L7.76349 2.22571C7.68664 2.09039 7.5753 1.97785 7.44081 1.89956C7.30632 1.82127 7.15348 1.78003 6.99786 1.78003C6.84224 1.78003 6.6894 1.82127 6.55491 1.89956C6.42042 1.97785 6.30908 2.09039 6.23224 2.22571L4.62442 5.12414L1.85724 3.89367C1.70822 3.82703 1.54352 3.8034 1.38178 3.82545C1.22003 3.84751 1.06768 3.91437 0.941941 4.01849C0.816207 4.1226 0.722106 4.25982 0.670275 4.41461C0.618444 4.56941 0.610951 4.73562 0.648642 4.89446L2.0377 10.8171C2.06427 10.9318 2.11383 11.0399 2.18339 11.1348C2.25295 11.2297 2.34107 11.3096 2.44239 11.3695C2.57957 11.4516 2.73642 11.495 2.8963 11.4952C2.97402 11.4951 3.05133 11.484 3.12599 11.4624C5.65792 10.7624 8.33233 10.7624 10.8643 11.4624C11.0955 11.5232 11.3413 11.4898 11.5479 11.3695C11.6498 11.3103 11.7384 11.2307 11.8081 11.1357C11.8777 11.0406 11.9269 10.9321 11.9525 10.8171L13.3471 4.89446C13.3843 4.73558 13.3764 4.56945 13.3243 4.41482C13.2721 4.2602 13.1777 4.12326 13.0518 4.01946V4.01946Z" fill="white"/>
</svg></span> '.esc_html__( 'Upgrade to Pro' , 'chaty');
            }
        }
    }


    /**
     * Redirect user to plugin settings page on first activation.
     */
    public function redirect_user_to_settings_page()
    {
        if(!defined("DOING_AJAX")) {
            global $wpdb;
            $redirect_option = get_option('cx_redirect_user', false);
            if($redirect_option) {
                update_option('cx_redirect_user', false);
                $widget_count = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
                if ('0' === $widget_count) {
                    exit(wp_redirect(admin_url('admin.php?page=add_couponx')));
                } else if ($widget_count > 0) {
                    exit(wp_redirect(admin_url('admin.php?page=couponx')));
                }
            } else if (get_option('cx_signup_popup') === false) {
                $page = isset($_GET['page'])?$_GET['page']:"";
                if(!empty($page)) {
                    if(in_array($page, ["leads_list", "cx_integrations", "couponx_pricing_tbl", "cx-recommended-plugins"])) {
                        wp_redirect(admin_url('admin.php?page=couponx'));
                        exit;
                    }
                }
            }
        }

        if(isset($_GET['hide_couponx_plugins'])) {
            $nonce = isset($_GET['hcx_nonce'])?esc_attr($_GET['hcx_nonce']):'';
            if($nonce && wp_verify_nonce($nonce, 'hide_couponx_plugins')) {
                add_option('hide_couponx_plugins', 1);
                wp_redirect(admin_url("admin.php?page=couponx"));
                exit;
            }
        }
    }//end redirect_user_to_settings_page()


    /**
     * Load text domain folder
     */
    public function load_domain_files()
    {
        load_plugin_textdomain('cx', false, dirname(plugin_basename(__FILE__)).'/languages/');

    }//end load_domain_files()


    /**
     * Load plugin related files
     */
    public function files_loader()
    {

        include_once 'class-dashboard.php';
        include_once 'class-couponx-frontend.php';

    }//end files_loader()


}//end class

new Coupon_X();
