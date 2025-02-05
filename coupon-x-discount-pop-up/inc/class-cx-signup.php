<?php
/**
 *  Sign up Form
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
 * Newsletter signup
 */
class Cx_SignUp
{


    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->render_signup_popup();

    }//end __construct()


    /**
     * Render sign up popup html
     */
    public function render_signup_popup()
    {
        $email = (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == "playground.wordpress.net")?"":get_option('admin_email');
        ?>
        <style>
            #wpwrap{
                background: url('<?php echo esc_url(COUPON_X_URL); ?>assets/img/update-bg.jpg');
                background-position: bottom center;
                background-size: cover;
            }
        </style>
        <div class="starts-testimonials-updates-form">
            <div class="updates-form-form-left">
                <div class="updates-form-form-left-text">premio</div>
                <img src="<?php echo esc_url(COUPON_X_URL); ?>assets/img/wcupdate_email.svg" style="width: 230px;margin: 60px 0px 20px 0px;" />
                <p><?php esc_html_e('Grow your WordPress or Shopify websites with our plugins', 'coupon-x'); ?></p>
            </div>
            <div class="updates-form-form-right">
                <div class="update-title"><?php esc_html_e('Be the first to know product updates, tips & discounts', 'coupon-x'); ?></div>
                <p><?php esc_html_e('Be among the first to know about our latest features & what we’re working on. Plus insider offer & flash sales', 'coupon-x'); ?></p>
                <div class="updates-form">
                    <div class="update-form-input">
                        <div class="mail-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="4" width="20" height="16">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM12 13L4 8V18H20V8L12 13Z" fill="white"/>
                                </mask>
                                <g mask="url(#mask0)">
                                    <rect width="24" height="24" fill="#94A3B8"/>
                                </g>
                            </svg>
                        </div>
                        <input type='hidden' class='signup-nonce' value='<?php echo wp_create_nonce('cx_signup_status'); ?>'/>
                        <input id="couponx_update_email" autocomplete="off" value="<?php echo esc_attr($email); ?>" placeholder="Email address">
                        <button href="javascript:;" class="button button-primary form-submit-btn yes befirst-btn"><?php esc_html_e('Sign Up', 'coupon-x'); ?></button>
                        <p id="suggestion"></p>
                    </div>
                    <!--div class="update-form-skip-button">
                        <button href="javascript:;" class="button button-secondary form-cancel-btn no">Skip</button>
                    </div-->
                </div>
                <div class="update-notice-latter">
                    <span><a href="javascript:;" class="form-cancel-btn no"><?php esc_html_e('No, I will do it later', 'coupon-x'); ?></a></span>
                </div>
                <div class="update-notice">
        <?php esc_html_e('You can remove yourself from the list whenever you want, no strings attached', 'coupon-x'); ?>
                </div>
                <input type="hidden" id="sticky_element_update_nonce" value="<?php echo wp_create_nonce('my_sticky_elements_update_nonce'); ?>">
            </div>
        </div>
        <div id="mystickyelement-update-email-overlay" class="stickyelement-overlay" style="display:block;" data-id="0" data-from="widget-status"></div>
        <?php

    }//end render_signup_popup()


}//end class

?>

<script>
    var suggestionText = "";
    jQuery(document).ready(function($) {
        jQuery(document).on("focus", ".updates-form button", function () {
            suggestionText = jQuery("#suggestion").text();
        });
        jQuery(document).on("mouseover", ".updates-form button", function () {
            suggestionText = jQuery("#suggestion").text();
        }).on("mouseleave", "updates-form button", function () {
            suggestionText = jQuery("#suggestion").text();
        });

        var domains = ['hotmail.com', 'gmail.com', 'aol.com'];
        var topLevelDomains = ["com", "net", "org"];

        jQuery("#couponx_update_email").emailautocomplete({
            domains: ['example.com', 'protonmail.com', 'yahoo.com', 'gmail.com'],
            caseSensitive: false
        });

        jQuery(document).on("click", "#suggestion i", function (){
            jQuery("#couponx_update_email").val(jQuery(this).text()).focus();
            jQuery("#suggestion").html('');
        });

        $(document).on("click", ".updates-form button, a.form-cancel-btn", function () {
            var updateStatus = 0;
            if ($(this).hasClass("yes")) {
                updateStatus = 1;
            }
            $(".updates-form button").attr("disabled", true);
            $.ajax({
                url: cx_data.url,
                data: {
                    action: "coupon_x_update_signup_status",
                    status: updateStatus,
                    nonce: $('.signup-nonce').val(),
                    email: jQuery("#couponx_update_email").val()
                },
                type: 'post',
                cache: false,
                success: function () {
                    window.location.reload();
                }
            })
        });

        jQuery(document).on("change", "#couponx_update_email", function (){
            isValidEmailAddress();
        });
        jQuery(document).on("keyup", "#couponx_update_email", function (){
            if(isValidEmailAddress()) {
                jQuery(this).mailcheck({
                    // domains: domains,                       // optional
                    // topLevelDomains: topLevelDomains,       // optional
                    suggested: function(element, suggestion) {
                        // callback code
                        jQuery('#suggestion').html("Did you mean <b><i>" + suggestion.full + "</b></i>?");
                    },
                    empty: function(element) {
                        // callback code
                        jQuery('#suggestion').html('');
                    }
                });
            } else {
                jQuery('#suggestion').html('');
            }
        });
    });

    function isValidEmailAddress() {
        if(jQuery.trim(jQuery("#couponx_update_email").val()) == "") {
            jQuery(".form-submit-btn").prop("disabled", true);
            return false;
        } else if(!isValidEmail(jQuery("#couponx_update_email").val())) {
            jQuery(".form-submit-btn").prop("disabled", true);
            return false;
        } else {
            jQuery(".form-submit-btn").prop("disabled", false);
        }
        return true;
    }

    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>