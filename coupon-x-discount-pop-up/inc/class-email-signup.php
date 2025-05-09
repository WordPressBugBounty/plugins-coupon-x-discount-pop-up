<?php
/**
 * Update Popup Class
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

 if (defined('ABSPATH') === false) {
	exit;
}

/**
 * Class Cx_SIGNUP_CLASS
 *
 * Handles signup modal status, update actions, and manages display configurations
 * for the My Sticky Elements plugin update-related content.
 */
class Cx_SIGNUP_CLASS {

    /**
     * Option name used to store the update message for the "coupon-x" feature.
     */
    private static $update_message_option = 'cx_signup_popup';

    /**
     * Option name used to store the date for the next signup related to the "coupon-x" feature.
     */
    private static $next_signup_date = 'cx_next_signup_date';

    /**
     * Stores the status of the modal to be shown.
     */
    private static $show_modal_name = 'cx_show_signup_modal';

    /**
     * Constructor method for the class.
     *
     * Initializes the MSE_UPDATE_POPUP_CONTENT constant with predefined array values
     * containing plugin metadata, asset URLs, and visual elements.
     * Also registers the WordPress AJAX callback for updating status.
     *
     * @return void
     */
    public function __construct() {
        // ajax callback
        add_action( 'wp_ajax_coupon_x_update_signup_status', array($this, 'update_status'));


	}//end __construct()


    public static function load_signup_settings()
    {
        if(defined('CX_UPDATE_POPUP_CONTENT')) {
            return;
        }

        define('CX_UPDATE_POPUP_CONTENT', array(
            'plugin_name'           => esc_html__('Coupon X', 'coupon-x'),
            'trust_user'            => esc_html__('Join the list thousands of users trust', 'coupon-x'),
            'website_owners'        => esc_html__('Thousands', 'coupon-x'),
            'rating'                => esc_html__('4.9/5 Rating', 'coupon-x'),
            'review'                => esc_html__('Based on User Reviews', 'coupon-x'),
            'trust_user_img'        => COUPON_X_URL . "assets/img/signup/user-trust.svg",
            'plugin_logo'           => COUPON_X_URL . "assets/img/signup/cx-logo.png",
            'font_url'              => COUPON_X_URL . "assets/css/Lato-Regular.woff",
            'background_image'      => COUPON_X_URL . "assets/img/signup/premio-update-bg.svg",
            'shape_bottom'          => COUPON_X_URL . "assets/img/signup/premio-update-bg-btm.png",
            'shape_bottom_right'    => COUPON_X_URL . "assets/img/signup/premio-update-bg-right.png",
            'mail_icon'             => COUPON_X_URL . "assets/img/signup/mail-icon.svg",
            'user_icon'             => COUPON_X_URL . "assets/img/signup/users.svg",
            'slash_icon'            => COUPON_X_URL . "assets/img/signup/slash.svg",
            'star_icon'             => COUPON_X_URL . "assets/img/signup/star.svg",
            'arrow_right'           => COUPON_X_URL . "assets/img/signup/arrow-right.svg",
            'check_circle'          => COUPON_X_URL . "assets/img/signup/check-circle.svg",
            'pre_loader'            => COUPON_X_URL . "assets/img/signup/pre-loader.svg",
        ));
    }


    /**
     * Checks the status of a modal and determines whether it should be displayed.
     *
     * This method evaluates various conditions, such as predefined options and the HTTP referrer,
     * to decide if the modal should be shown. It may also update specific modal-related options
     * based on the results of these checks.
     *
     * @return bool Returns true if the modal should be displayed; otherwise, false.
     */
    public static function check_modal_status() {
        if(get_option(self::$update_message_option) == -1 || get_option(self::$update_message_option) == 1) {
            return false;
        }

        $referer = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';
       
        if (!str_contains($referer, 'couponx')) {
            global $wpdb;
            $widget_count = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
           
            if($widget_count > 0){
                add_option(self::$show_modal_name, 1);
            }
        }

        if (get_option(self::$show_modal_name)) {
            $next_signup_date = get_option(self::$next_signup_date);
            if($next_signup_date === false) {
                self::load_signup_settings();
                return true;
            } else {
                if($next_signup_date < date('Y-m-d')) {
                    self::load_signup_settings();
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Handles the AJAX request to update the status of the plugin.
     *
     * Verifies the nonce for security, processes the provided status and email,
     * and executes specific actions based on the status, including sending data
     * to an external API or updating WordPress options.
     *
     * @return void
     */
    public function update_status() {
   
        if(!empty($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'coupon_x_signup_nonce')) {
            $status = sanitize_text_field($_REQUEST['status']);
            $email = sanitize_text_field($_REQUEST['email']);
            if($status == 1) {
               
                update_option(self::$update_message_option, -1);
                $url = 'https://premioapps.com/premio/signup/email.php';
                $apiParams = [
                    'plugin' => 'coupon',
                    'email'  => $email,
                ];

                // Signup Email for Chaty
                $apiResponse = wp_safe_remote_post($url, ['body' => $apiParams, 'timeout' => 15, 'sslverify' => true]);

                if (is_wp_error($apiResponse)) {
                    wp_safe_remote_post($url, ['body' => $apiParams, 'timeout' => 15, 'sslverify' => false]);
                }
            } else { 
                $next_date = date('Y-m-d', strtotime('+7 days'));
                $next_signup_date = get_option(self::$next_signup_date);
                if($next_signup_date === false) {
                    add_option(self::$next_signup_date, $next_date);
                } else {
                    update_option(self::$update_message_option, -1);
                }
            }
        }
        echo "1";
        die;
    }
    
}
new Cx_SIGNUP_CLASS();