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
        add_action('admin_footer', [$this, 'render_first_widget_popup']);
        $this->files_loader();

    }//end __construct()

    /**
     * Render first widget popup html.
     */
    public function render_first_widget_popup()
    {
        if(isset($_GET['page']) && in_array($_GET['page'], ['couponx_pro', 'add_couponx_pro'])) {
            $count = get_posts([ 'post_type' => 'cx_widget' ]);
            if (count($count) < 1 || (isset($_GET['show_first_modal']) && count($count) == 1)) {
                ?>
                <div class="main-popup-couponx-bg first-widget-popup <?php echo (isset($_GET['show_first_modal']) && count($count) == 1?'':'hide') ?>">
                    <?php
                    if(isset($_GET['show_first_modal']) && count($count) == 1) {
                        echo '<style>.popup-overlayout-cls, .first-widget-popup {display: block !important;}</style>';
                    }
                    ?>
                    <div class="main-popup-couponx-bg couponx_container_popupbox" >
                        <div class="maxvisit-popup-contain" style="">
                            <img class="inline-block" src="<?php echo esc_url(COUPON_X_URL.'assets/img/firstwidget.svg'); ?>">
                            <h4><?php esc_html_e('Your first widget is up!', 'coupon-x'); ?></h4>
                            <svg class="inline-block"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="0 0 28 28"><defs><pattern id="pattern" preserveAspectRatio="none" width="100%" height="100%" viewBox="0 0 64 64"><image width="64" height="64" xlink:href="data:image/png;base64,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"/></pattern></defs><path id="Path_8" data-name="Path 8" d="M498.836,240.96h28v-28h-28Z" transform="translate(-498.836 -212.96)" fill="url(#pattern)"/></svg></h4>
                            <p>
                                <?php printf(esc_html__('Yay - we’re happy you chose Coupon X for your website. If you run into anything, the %s is always here for you.', 'coupon-x'), "<a class='help-center' href='https://premio.io/help/coupon-x/' target='_blank'><strong>".esc_html__('help center', 'coupon-x')."</strong></a>"); ?>
                            </p>
                            <a style="padding: 15px 32px;" href="<?php echo esc_url(admin_url('admin.php?page=couponx')); ?>" class="btn-black btn-back-dashboard"><?php esc_html_e('Back to Dashboard', 'coupon-x'); ?></a>
                        </div>
                        <div class="welcome-modul-close-btn maxvisitor-model">
                            <a href="javascript:void(0)" class="close-chaty-maxvisitor-popup">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 5L5 15" stroke="#4A4A4A" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5 5L15 15" stroke="#4A4A4A" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="popup-overlayout-cls" style='display: none;' ></div>
                <?php
            }//end if
        }
    }//end render_first_widget_popup()


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
