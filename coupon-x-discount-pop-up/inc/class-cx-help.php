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


    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->render_help_widget();

    }//end __construct()


    /**
     * Render chat widget code.
     */
    public function render_help_widget()
    {
        ?>
        <div class="cx-help-form">
            <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" id="cx-help-form">
                <div class="cx-help-header">
                    <b>Gal Dubinski</b> Co-Founder at Premio
                </div>
                <div class="cx-help-content">
                    <p><?php esc_html_e('Hello! Are you experiencing any problems with Coupon X? Please let me know :)', 'coupon-x'); ?></p>
                    <div class="cx-form-field">
                        <input type="text" name="user_email" id="user_email" placeholder="<?php esc_html_e('Email', 'coupon-x'); ?>">
                    </div>
                    <div class="cx-form-field">
                        <textarea type="text" name="textarea_text" id="textarea_text" placeholder="<?php esc_html_e('How can I help you?', 'coupon-x'); ?>"></textarea>
                    </div>
                    <div class="form-button">
                        <button type="submit" class="cx-help-button" ><?php esc_html_e('Chat'); ?></button>
                        <input type="hidden" name="action" value="cx_admin_send_message_to_owner"  >
                        <input type="hidden" id="nonce" name="nonce" value="<?php echo esc_attr(wp_create_nonce('cx_send_message_to_owner')); ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="cx-help-btn">
            <a class="cx-help-tooltip" href="javascript:;"><img src="<?php echo esc_url(COUPON_X_URL.'assets/img/owner.png'); ?>" alt="<?php esc_html_e('Need help?', 'coupon-x'); ?>"  /></a>
            <span class="tooltiptext"><?php esc_html_e('Need help?', 'coupon-x'); ?></span>
        </div>
        <?php

    }//end render_help_widget()


}//end class

