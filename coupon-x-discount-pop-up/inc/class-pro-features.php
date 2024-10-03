<?php
/**
 * Coupon X Pro Features
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
 * Submit review for plugin
 */
class Cx_Pro_Features
{


    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->render_pro_features();

    }//end __construct()


    /**
     * PRO features listing
     */
    public function render_pro_features()
    {
        $planURL = admin_url('admin.php?page=couponx_pricing_tbl');

        ?>
        <div class='widget-wrap'>
        <div class="couponapp-new-widget-wrap">
            <h2 class="text-center"><strong><a href="<?php echo esc_url($planURL); ?>" style="text-decoration:none">Upgrade now</a></strong> and create a new Coupon X widget for your website. What can you use it for?</h2>
            <div class="couponapp-new-widget-row">
                <div class="couponapp-features">
                    <ul>
                        <li>
                            <div class="couponapp-feature">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-devices.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Create separate designs for desktop and mobile</h4>
                                    <p class="feature-description">E.g. the mobile version can have a bigger widget, in a different color and a different position</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="couponapp-feature">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-language.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Do you have a multi-language?</h4>
                                    <p class="feature-description">You can show different coupon widgets based on URL (E.g. French widget for your French version website, and you can also give different coupons based on region)</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="couponapp-feature">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-widget.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Show separate widgets for different products</h4> 
                                    <p class="feature-description">You can give high-value coupons on a certain product-category, e.g yourdomain.com/high-end/*</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <div class="couponapp-feature second">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-page.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Display different channels for your landing pages</h4>
                                    <p class="feature-description">Show the most relevant coupon for your landing pages</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="couponapp-feature second">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-support.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Reduce bounce rate</h4>
                                    <p class="feature-description"> Show a coupon on your high bounce rate pages and make sure your visitors get what they want</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="couponapp-feature second">
                                <div class="couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/pro-chat.png'); ?>" >
                                </div>
                                <div class="couponapp-feature-bottom">
                                    <h4 class="feature-title">Display different call-to-action messages</h4>
                                    <p class="feature-description">Show different call-to-action for different pages on your website or separate call-to-action messages for mobile and desktop</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="clear clearfix"></div>
                </div>                
                <div class="upgrade-couponapps">
                    <a href="<?php echo esc_url($planURL); ?>" style="text-transform: none;"> Upgrade Now</a>
                </div>
            </div>            
        </div>
        </div>
        <?php

    }//end render_pro_features()


}//end class

