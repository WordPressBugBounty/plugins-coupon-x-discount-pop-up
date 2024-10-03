<?php
/**
 * Plugin feedback form
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
 * Plugin deactivation form.
 */
class Cx_Deactivation_Form
{


    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->render_feedback_popup();

    }//end __construct()


    /**
     * Render feedback popup html.
     */
    public function render_feedback_popup()
    {

        ?>
        <div class="cx-popup-overlay">
            <div class="cx-serveypanel">
                <!-- form start -->
                <form action="#" method="post" id="cx-deactivate-form">
                    <div class="cx-popup-header">
                        <h2><?php esc_html_e('Quick feedback about Coupon X', 'coupon-x'); ?> 🙏</h2>
                    </div>
                    <div class="cx-popup-body">
                        <h3><?php esc_html_e('Your feedback will help us improve the product, please tell us why did you decide to deactivate Coupon X:)', 'coupon-x'); ?></h3>
                        <div class="form-control">
                            <input type="email" value="<?php echo get_option('admin_email'); ?>" placeholder="<?php echo esc_html__('Email address', 'coupon-x'); ?>" id="cx-deactivation-email_id">
                        </div>
                        <div class="form-control">
                            <label></label>
                            <textarea placeholder="<?php esc_html_e('I need some help setting up Coupon X 🙂', 'coupon-x'); ?>" id="cx-deactivation-comment">I need some help setting up Coupon X 🙂</textarea>
                        </div>
                    </div>
                    <div class="cx-popup-footer">
                        <label class="cx-anonymous">
                            <input type="checkbox"/><?php esc_html_e('Anonymous feedback', 'coupon-x'); ?>
                        </label>
                        <input type="button" class="button button-secondary button-skip cx-popup-skip-feedback" value="<?php esc_html_e('Skip & Deactivate', 'coupon-x'); ?>">
                        <div class="action-btns">
                            <span class="cx-spinner"><img src="<?php echo esc_url(admin_url('/images/spinner.gif')); ?>" alt=""></span>
                            <input type="submit" class="button button-secondary button-deactivate cx-popup-allow-deactivate" value="<?php esc_html_e('Submit & Deactivate', 'coupon-x'); ?>" >
                            <a href="#" class="button button-primary cx-popup-button-close"><?php esc_html_e('Cancel', 'coupon-x'); ?></a>
                        </div>
                    </div>
                </form>
                <!-- form end -->
            </div>
        </div>
        <?php

    }//end render_feedback_popup()


}//end class

