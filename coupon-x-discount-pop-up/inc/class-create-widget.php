<?php
/**
 * Create Coupon
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;

if (! defined('ABSPATH')) {
    exit;
}

require_once 'widget_parts/class-cx-widget-tab.php';
require_once 'widget_parts/class-cx-widget-popup.php';
require_once 'widget_parts/class-cx-widget-triggers.php';
require_once 'widget_parts/class-cx-widget-coupon.php';

/**
 * Create new widget
 */
class Create_Widget
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->create_widget();
        $this->render_first_widget_popup();
        $this->render_countdown_timer_popup();

    }//end __construct()


    /**
     * Get settings of a widget
     *
     * @param opt $opt Array of settings.
     *
     * @return array of settings.
     */
    public function get_settings($opt='')
    {
        $number = 1;

        $default = [
            'tab'           => [
                'show_icon'        => 1,
                'widget_title'    => esc_html__('My widget #', 'coupon-x').$number,
                'tab_color'       => '#FFC600',
                'icon_color'      => '#605DEC',
                'tab_icon'        => 'tab-icon-1',
                'tab_custom_icon' => '',
                'tab_shape'       => 'circle',
                'position'        => 'right',
                'custom_position' => 'right',
                'bottom_spacing'  => 100,
                'side_spacing'    => 50,
                'tab_size'        => 50,
                'call_action'     => esc_html__('Get 10% off now!', 'coupon-x'),
                'action_color'    => '#FFFFFF',
                'action_bgcolor'  => '#605DEC',
                'show_cta'        => 2,
                'show_tab'        => 1,
                'msg'             => 0,
                'no_msg'          => 1,
                'no_color'        => '#FFFFFF',
                'no_bgcolor'      => '#DD0000',
                'font'            => 'Google_Fonts-Poppins',
                'effect'          => 'none',
                'show_attention' => 2
            ],
            'popup'         => [
                'style'       => 'style-1',
                'auto_close'  => 0,
                'auto_time'   => 2,
                'coupon_type' => '',
                'custom_css'  => '',
                'type'        => 'Slide-in Pop up',
                'slide_in_position' => 'right',
                'custom_position'   => 'right',
                'bottom_spacing'    => 100,
                'side_spacing'      => 50,
                'font'              => 'Google_Fonts-Poppins'
            ],
            'main'          => [
                'bgcolor'          => '#ffffff',
                'headline'         => esc_html__('Enter your email and unlock amazing deals!', 'coupon-x'),
                'headline_color'   => '#000000',
                'email'            => esc_html__('Email', 'coupon-x'),
                'email_color'      => '#FFFFFF',
                'text_color'       => '#000000',
                'email_brdcolor'   => '#635EFF',
                'btn_text'         => esc_html__('Send', 'coupon-x'),
                'btn_color'        => '#605DEC',
                'btn_text_color'   => '#FFFFFF',
                'desc'             => esc_html__('Get ready to unwrap the gift of savings!', 'coupon-x'),
                'desc_color'       => '#000000',
                'consent'          => 0,
                'consent_text'     => esc_html__('I agree to join the mailing list', 'coupon-x'),
                'consent_required' => 0,
                'customer_email'   => 1,
                'error'            => esc_html__('You have already used this email address, please try another email address', 'coupon-x'),
                'error_color'      => '#FFFFFF',
                'send_coupon'      => 0,
            ],
            'coupon'        => [
                'link_type'       => 1,
                'custom_link'     => '',
                'new_tab'         => 0,
                'bg_color'        => '#ffffff',
                'headline'        => esc_html__('Unlock exclusive deals awaiting you', 'coupon-x'),
                'headline_color'  => '#000000',
                'error_color'     => '#000000',
                'coupon_color'    => '#FFFFFF',
                'text_color'      => '#929292',
                'coupon_brdcolor' => '#635EFF',
                'clsbtn_color'    => '#000000',
                'cpy_btn'         => esc_html__('Copy Code', 'coupon-x'),
                'cpy_msg'         => esc_html__('Coupon is copied to clipboard', 'coupon-x'),
                'btn_color'       => '#605DEC',
                'txt_color'       => '#FFFFFF',
                'desc'            => esc_html__('Your exclusive code is ready! Copy it now!', 'coupon-x'),
                'desc_color'      => '#000000',
                'couponcode_type' => '',
                'enable_styles'   => 1,
            ],
            'trigger'       => [
                'display_desktop'    => 1,
                'display_mobile'     => 1,
                'when'               => 1,
                'enable_time_delay'  => 1,
                'delay_time'         => 0,
                'enable_page_scroll' => 0,
                'scroll_percent'     => 0,
                'exit_intent'        => 0,
            ],
            'unique_coupon' => [
                'discount_type'        => 'percent',
                'discount_value'       => 10,
                'applies_to'           => 'order',
                'cats'                 => [],
                'products'             => [],
                'min_req'              => 1,
                'min_val'              => '',
                'discount_perqty'      => '',
                'enable_usage_limits'  => 0,
                'enable_no_item_limit' => 0,
                'no_item_limit'        => '',
                'enable_user_limit'    => 0,
                'enable_date'          => 0,
                'start_date'           => '',
                'end_date'             => '',
                'discount_code'        => '',
            ],
            'ex_coupon'     => ['coupon' => ''],
            'announcement'  => [
                'headline'       => esc_html__('Check out our latest collection', 'coupon-x'),
                'headline_color' => '#000000',
                'desc'           => esc_html__('New fall collection is now on sale', 'coupon-x'),
                'desc_color'     => '#000000',
                'enable_btn'     => '0',
                'cpy_btn'        => esc_html__('CLAIM NOW', 'coupon-x'),
                'btn_action'     => 1,
                'redirect_url'   => 'https://example.com',
                'bg_color'       => '#ffffff',
                'btn_color'      => '#605DEC',
                'txt_color'      => '#FFFFFF',
                'enable_styles'  => 1,
                'new_tab'        => 0,
            ],
        ];
        $post_content = [];

        if (isset($_GET['id'])) {
            $post_id = filter_input(INPUT_GET, 'id');

            $content = get_post_field('post_content', $post_id);

            $post_content = unserialize($content);

            if ('' === $opt) {
                $settings = wp_parse_args($post_content, $default);
                return $settings;
            } else {
                $settings = wp_parse_args($post_content[$opt], $default[$opt]);
                return $settings;
            }
        } else {
            if ('' === $opt) {
                return $default;
            } else {
                $settings = $default[$opt];
                return $settings;
            }
        }//end if

    }//end get_settings()


    /**
     * Create widget tabs.
     */
    public function create_widget()
    {
        $id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id') : '';
        global $wpdb;
        $count = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_type='cx_widget'");
        $slug  = '';
        if ($count > 0 && '' === $id) {
            exit(wp_redirect(admin_url('admin.php?page=couponx')));
        }
        ?>
        <div class='wrap create-widget'>
            <form method="post" action="" id='cx_widget'>
                <input type='hidden' class='widget-id' name='cx_settings[tab][cx_widget_id]' value='<?php echo esc_attr($id); ?>'/>
                <input type='hidden' name='cx_nonce' value='<?php echo wp_create_nonce('wp_rest'); ?>' />
                <div class='tabs' id="coupon-tab">
                <ul class="coupon-tabs widget-tabs" >
                    <li>
                        <a href="#tab_design" class="coupon-tab active" >
                            <?php esc_html_e('Icon design', 'coupon-x'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#choose_coupon" class="coupon-tab">
                            <?php esc_html_e('Choose Coupon', 'coupon-x'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#popup_design" class="coupon-tab">
                            <?php esc_html_e('Pop Up Design', 'coupon-x'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#triggers_targetting" class="coupon-tab" >
                            <?php esc_html_e('Triggers & Targeting', 'coupon-x'); ?>
                        </a>
                    </li>
                    <a href='<?php echo esc_url(admin_url().'admin.php?page=couponx'); ?>' class='custom-back-link'>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 17L9.92186 12.7682C9.44211 12.3684 9.44211 11.6316 9.92187 11.2318L15 7" stroke="#181749" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <?php esc_html_e('Back to Dashboard', 'coupon-x'); ?>
                    </a>
                </ul>
                <div id='tab_design' class="ui-tab-content active">
                    <?php
                    $settings = $this->get_settings('tab');
                    new Cx_Widget_Tab($settings);
                    ?>
                    <div class='nav-links'>
                        <a class='next-step' tab='#choose_coupon'> 
                            <?php esc_html_e('Next Step', 'coupon-x'); ?>
                        </a>
                        <?php
                        if (isset($_GET['id'])) {
                            ?>
                            <a class='save' href='#'>
                                <?php esc_html_e('Save', 'coupon-x'); ?>
                            </a>
                            <a class='go-to-dashboard' href='<?php echo esc_url(admin_url('admin.php?page=couponx')); ?>' >
                                <?php esc_html_e('Save & View Dashboard', 'coupon-x'); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id='choose_coupon' class="ui-tab-content">
                    <?php
                    $settings = $this->get_settings();
                    new Cx_Widget_Coupon($settings);
                    ?>
                    <div class='nav-links'>
                        <a class='prev-step' tab='#tab_design'> 
                            <?php esc_html_e('Back', 'coupon-x'); ?>
                        </a>
                        <a class='next-step' tab='#popup_design'> 
                            <?php esc_html_e('Next Step', 'coupon-x'); ?>
                        </a>
                        <?php
                        if (isset($_GET['id'])) {
                            ?>
                            <a class='save' href='#'>
                                <?php esc_html_e('Save', 'coupon-x'); ?>
                            </a>
                            <a class='go-to-dashboard' href='<?php echo esc_url(admin_url('admin.php?page=couponx')); ?>' >
                                <?php esc_html_e('Save & View Dashboard', 'coupon-x'); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id='popup_design' class="ui-tab-content">
                    <?php
                    $popup_settings = $this->get_settings();
                    new Cx_Widget_Popup($popup_settings);
                    ?>
                    <div class='nav-links'>
                        <a class='prev-step' tab='#choose_coupon'> 
                            <?php esc_html_e('Back', 'coupon-x'); ?>
                        </a>
                        <a class='next-step' tab='#triggers_targetting'> 
                            <?php esc_html_e('Next Step', 'coupon-x'); ?>
                        </a>
                        <?php
                        if (isset($_GET['id'])) {
                            ?>
                            <a class='save' href='#'>
                                <?php esc_html_e('Save', 'coupon-x'); ?>
                            </a>
                            <a class='go-to-dashboard' href='<?php echo esc_url(admin_url('admin.php?page=couponx')); ?>' >
                                <?php esc_html_e('Save & View Dashboard', 'coupon-x'); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id='triggers_targetting' class="ui-tab-content">
                    <?php
                    $settings = $this->get_settings('trigger');
                    new Cx_Widget_Triggers($settings);
                    ?>
                    <div class='nav-links'>
                        <a class='prev-step' tab='#popup_design'> 
                            <?php esc_html_e('Back', 'coupon-x'); ?>
                        </a>
                        <a class='save' href='#'> 
                            <?php esc_html_e('Save', 'coupon-x'); ?>
                        </a>
                        <a class='go-to-dashboard' href='<?php echo esc_url(admin_url('admin.php?page=couponx')); ?>' >
                            <?php esc_html_e('Save & View Dashboard', 'coupon-x'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class='validation-popup' title="<?php esc_attr_e('Select a coupon', 'coupon-x'); ?>"  style="display:none;">
                <p> <?php esc_html_e('Please select a coupon code before moving to the next step', 'coupon-x'); ?></p>
                <div class='actions'>
                    <input type='button' class='select-coupon-btn' value='<?php esc_attr_e('Select coupon', 'coupon-x'); ?>' />
                </div>
            </div>
            <div class='layout-validation' title="<?php esc_attr_e('Select a layout', 'coupon-x'); ?>"  style="display:none;">
                <p> <?php esc_html_e('Please select a popup layout before moving to the next step', 'coupon-x'); ?></p>
                <div class='actions'>                    
                    <input type='button' class='select-layout' value='<?php esc_attr_e('Select layout', 'coupon-x'); ?>' />
                </div>
            </div>
            <div class='validation-trigger' title="<?php esc_attr_e('No trigger was selected', 'coupon-x'); ?>"  style="display:none;">
                <p class='trigger-error'> </p>
            </div>
            <div id="loader" class="center">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="width:150px;height:150px;"><path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"><animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform></path></svg>
            </div>
            <?php $dashboard_link = admin_url('admin.php?page=couponx'); ?>
            <div id="wp_flash_message" class="hide">
                <?php printf(esc_html__("Settings saved (visit your %s for stats)", 'coupon-x'), '<a id="go-dashboard" href="'.esc_url($dashboard_link).'">'.esc_html__('Dashboard', 'coupon-x').'</a>'); ?>
                <span>
                    <a href="#" class="close_flash_popup">&#x2715;</a>
                </span>
            </div>
            <div id="wp_error_flash_message" class="hide">
                <?php printf(esc_html__("You've already created a Coupon X widget. Please %s to edit it.", 'coupon-x'), '<a id="go-dashboard" href="'.esc_url($dashboard_link).'">'.esc_html__('go to the dashboard', 'coupon-x').'</a>'); ?>
                <span>
                    <a href="#" class="close_flash_popup">&#x2715;</a>
                </span>
            </div>
        </form>
        </div>
        <div class='mobile-preview-bg'></div> 
        <?php
        include_once 'class-cx-help.php';
        new Cx_Help();

    }//end create_widget()


    /**
     * Render first widget popup html.
     */
    public function render_first_widget_popup()
    {
        $count = get_posts([ 'post_type' => 'cx_widget' ]);

        if (count($count) < 1) {
            ?>
        <div class="main-popup-couponx-bg first-widget-popup hide">
            <div class="main-popup-couponx-bg couponx_container_popupbox" >
                <div class="maxvisit-popup-contain" style="">
                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/firstwidget.svg'); ?>">
                    <h4><?php esc_html_e('Your first widget is up!', 'coupon-x'); ?></h4>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="0 0 28 28"><defs><pattern id="pattern" preserveAspectRatio="none" width="100%" height="100%" viewBox="0 0 64 64"><image width="64" height="64" xlink:href="data:image/png;base64,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"/></pattern></defs><path id="Path_8" data-name="Path 8" d="M498.836,240.96h28v-28h-28Z" transform="translate(-498.836 -212.96)" fill="url(#pattern)"/></svg></h4>
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

    }//end render_first_widget_popup()


    public function render_countdown_timer_popup()
    {
        ?>
        
        <div class="main-popup-couponx-bg couponx-coundown-timer-updrade countdown-timer-popup hide" id="couponcode-screen-countdown-upgrade" style="">
            <div class="couponx-timer-upgrade-left couponx-timer-upgrade-slid">
                <img src="<?php echo esc_url(COUPON_X_URL."assets/img/maxlimitpopup.svg") ?>">
                <h4><?php esc_html_e("Upgrade to Pro 🎉", "coupon-x") ?></h4>
                <p><?php esc_html_e("Enjoy awesome features like beautiful timer templates, sending leads to email, emails integrations and more", "coupon-x") ?></p>
                <div class="couponx-coundown-timer-updrade-btn">
                    <a  href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>"  class=" btn-black">
                        <?php esc_html_e("Upgrade Now", "coupon-x") ?>
                    </a>
                </div>
                <span><span class="dashicons dashicons-saved"></span> <?php esc_html_e("Cancel anytime. No strings attached", "coupon-x") ?></span><br>
                <span><span class="dashicons dashicons-saved"></span> <?php esc_html_e("30 days refund", "coupon-x") ?></span>
            </div>
            <div class="couponx-timer-upgrade-right couponx-timer-upgrade-slid">
                <div class="slideshow-container"> 
                    <div class="mySlides_couponcode fade" style="display: block;">
                        <img src="<?php echo esc_url(COUPON_X_URL."assets/img/default_timer_theme.gif") ?>">
                    </div>

                    <div class="mySlides_couponcode fade" style="display: none;">
                        <img src="<?php echo esc_url(COUPON_X_URL."assets/img/timer_updown_1.gif") ?>">
                    </div>

                    <div class="mySlides_couponcode fade" style="display: none;">
                        <img src="<?php echo esc_url(COUPON_X_URL."assets/img/timer_updown_2.gif") ?>">
                    </div>
                    
                    <div class="mySlides_couponcode fade" style="display: none;">
                        <img src="<?php echo esc_url(COUPON_X_URL."assets/img/timer_blink.gif") ?>">
                    </div>

                    <div class="mySlides_couponcode fade" style="display: none;">
                        <img src="<?php echo esc_url(COUPON_X_URL."assets/img/timer_left_anim.gif") ?>">
                    </div>
                </div> 
                <br>  
                <div class="couponx-timer-updrade-slide-control">
                
                    <a class="prev">❮</a>
                        <span class="dot_couponcode active-slid" data-pos = '1'></span> 
                        <span class="dot_couponcode" data-pos = '2'></span> 
                        <span class="dot_couponcode" data-pos = '3'></span>
                        <span class="dot_couponcode" data-pos = '4'></span>
                        <span class="dot_couponcode" data-pos = '5'></span>
                    <a class="next">❯</a>                             
                </div>
                <div style="text-align:end;">
                    <img src="<?php echo esc_url(COUPON_X_URL."assets/img/timer_template_guid.svg") ?>">
                </div>
                    
            </div>
            <div class="couponx-timer-updrade-close-button">
                <a href="javascript:void(0)" class="close-timer-popup">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 5L5 15" stroke="#4A4A4A" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5 5L15 15" stroke="#4A4A4A" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="popup-overlayout-cls" style='display: none;' ></div> 
        <?php

    }//end render_countdown_timer_popup()


}//end class

new Create_Widget();
