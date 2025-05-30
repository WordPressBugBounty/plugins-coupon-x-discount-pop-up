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

            $post_content = get_post_meta($post_id, 'prm_cx_widget_data', true);

            if(empty($post_content)) {
                $content = get_post_field('post_content', $post_id);
                $content = $this->clean_json_string($content);
                $post_content = json_decode($content, true);
            }

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

    public function clean_json_string($json_string) {
        $pos = strrpos($json_string, '}}</'); // Find the last occurrence of }}
        return ($pos !== false) ? substr($json_string, 0, $pos + 2) : $json_string;
    }


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
        $step = 0;
        ?>
        <div class='wrap create-widget'>
            <form method="post" action="" id='cx_widget'>
                <input type='hidden' class='widget-id' name='cx_settings[tab][cx_widget_id]' value='<?php echo esc_attr($id); ?>'/>
                <input type='hidden' name='cx_nonce' value='<?php echo wp_create_nonce('wp_rest'); ?>'/>
                <div class="chaty-header-space"></div>
                <div class="chaty-header chaty-logo z-50 flex gap-3 items-center justify-between bg-white p-1.5 fixed top-0 left-0 w-full" id="chaty-header-tab-label">
                    <a class="text-cx-black hover:text-cx-primary-100" href="<?php echo admin_url('admin.php?page=couponx') ?>">
                        <span class="dashicons dashicons-arrow-left-alt"></span>
                        <span class="lg:inline hidden">Dashboard</span>
                    </a>
                    <div class="header-items flex-1">
                        <ul class="chaty-app-tabs flex items-start justify-between">
                            <li class="m-0">
                                <a href="javascript:;" class="chaty-tab <?php echo ($step == 0) ? "active" : "completed" ?>" data-tab-id="cx-icon-design" id="cx-btn-icon-design" data-tab="first" data-tab-index="">
                                    <span class="chaty-tabs-heading"></span>
                                    <span class="lg:inline hidden chaty-tabs-subheading"><?php esc_html_e("1. Icon Design", 'coupon-x') ?></span>
                                    <span class="inline lg:hidden chaty-tabs-subheading"><?php esc_html_e("1. Icon Design", 'coupon-x') ?></span>
                                </a>
                            </li>
                            <li class="my-0">
                                <a href="javascript:;" class="chaty-tab <?php echo ($step == 1) ? "active" : (($step == 2) ? "completed" : "") ?>" data-tab-id="cx-choose-coupon" id="cx-btn-choose-coupon" data-tab-index="" data-tab="middle" data-forced-save="yes">
                                    <span class="chaty-tabs-heading"></span>
                                    <span class="lg:inline hidden chaty-tabs-subheading"><?php esc_html_e("2. Choose Coupon", 'coupon-x') ?></span>
                                    <span class="inline lg:hidden chaty-tabs-subheading"><?php esc_html_e("2. Choose Coupon", 'coupon-x') ?></span>
                                </a>
                            </li>
                            <li class="m-0">
                                <a href="javascript:;" class="chaty-tab <?php echo ($step == 2) ? "active" : "" ?>" data-tab-id="cx-pop-up-design" id="cx-btn-pop-up-design" data-tab-index="middle" data-forced-save="yes">
                                    <span class="chaty-tabs-heading"></span>
                                    <span class="lg:inline hidden chaty-tabs-subheading"><?php esc_html_e("3. Pop up Design", 'coupon-x') ?></span>
                                    <span class="inline lg:hidden chaty-tabs-subheading"><?php esc_html_e("3. Pop up", 'coupon-x') ?></span>
                                </a>
                            </li>
                            <li class="m-0">
                                <a href="javascript:;" class="chaty-tab <?php echo ($step == 3) ? "active" : "" ?>" data-tab-id="cx-triggers-targeting" id="cx-btn-triggers-targeting" data-tab="last" data-tab-index="" data-forced-save="yes">
                                    <span class="chaty-tabs-heading"></span>
                                    <span class="lg:inline hidden chaty-tabs-subheading"><?php esc_html_e("4. Triggers & Targeting", 'coupon-x') ?></span>
                                    <span class="inline lg:hidden chaty-tabs-subheading"><?php esc_html_e("4. Triggers & Targeting", 'coupon-x') ?></span>
                                </a>
                              </li>
                        </ul>
                        <div class="chaty-app-steps">
                            <div class="progress-stat">
                                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="whirlPath">
                                    <circle cx="50" cy="50" r="46.5" stroke-linecap="round" fill="none" stroke-width="4.5"></circle>
                                </svg>
                                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="svg-progress">
                                    <circle cx="50" cy="50" r="46.5" stroke-linecap="round" fill="none" stroke-width="4.5" id="step-progress" style="stroke-dashoffset: 0;"></circle>
                                </svg>
                                <span class="current-step" id="current-step">4/4</span>
                            </div>
                            <div class="process-step" id="process-step"> Add live chat </div>
                        </div>
                    </div>
                    <footer class="footer-buttons relative space-x-2 step-<?php echo esc_attr($step) ?>">
                        <div class="flex items-center justify-center gap-3">
                            <div class="flex items-center gap-2 next-prev-buttons">
                                <button type="button" class="flex back-button" id="back-button" aria-label="<?php esc_html_e("Back", 'coupon-x') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M15.8333 10H4.16668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10 15.8333L4.16668 9.99996L10 4.16663" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Back</span>
                                </button>
                                <button type="button" class="flex next-button" id="next-button" aria-label="<?php esc_html_e("Next", 'coupon-x') ?>">
                                    <span>Next</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M4.16677 10H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.0001 4.16663L15.8334 9.99996L10.0001 15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="save-button-container">
                                <button type="submit" class="save-button flex gap-2 whitespace-nowrap" id="save-button" name="save_button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H13.3333L17.5 6.66667V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.1666 17.5V10.8334H5.83331V17.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.83331 2.5V6.66667H12.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span><?php esc_html_e("Save Widget", 'coupon-x') ?></span>
                                    <span class="mobile-text"><?php esc_html_e("Save", 'coupon-x') ?></span>
                                </button>
                                <button type="button" class="arrow-btn !px-1.5 h-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            <div>
                        </div>
                        <input type="hidden" name="current_step" value="<?php echo esc_attr($step) ?>" id="current_step">
                        <input type="hidden" name="redirect_on_dashboard" value="0" id="redirect_on_dashboard">
                        <input type="submit" class="save-dashboard-button hidden" id="save-dashboard-button" name="save_and_view_dashboard" value="<?php esc_html_e('Save & Close', 'coupon-x'); ?>" />
                    </footer>
                </div>
                <div id="cx-widget-tab" class="max-w-[1280px] mx-auto">
                    <div class='overflow-x-hidden sm:overflow-visible rounded-lg border border-gray-150/40 bg-white' id="cx-widget-body-tab">
                        <div id='cx-icon-design' class="social-channel-tabs active">
                            <?php
                            $settings = $this->get_settings('tab');
                            new Cx_Widget_Tab($settings);
                            ?>
                        </div>
                        <div id='cx-choose-coupon' class="social-channel-tabs">
                            <?php
                            $settings = $this->get_settings();
                            new Cx_Widget_Coupon($settings);
                            ?>
                        </div>
                        <div id='cx-pop-up-design' class="social-channel-tabs">
                            <?php
                            $popup_settings = $this->get_settings();
                            new Cx_Widget_Popup($popup_settings);
                            ?>
                        </div>
                        <div id='cx-triggers-targeting' class="social-channel-tabs">
                            <?php
                            $settings = $this->get_settings('trigger');
                            new Cx_Widget_Triggers($settings);
                            ?>
                        </div>
                    </div>
                </div>
                <div class='validation-popup' title="<?php esc_html_e('Select a coupon', 'coupon-x'); ?>"
                     style="display:none;">
                    <p> <?php esc_html_e('Please select a coupon code before moving to the next step', 'coupon-x'); ?></p>
                    <div class='actions'>
                        <input type='button' class='select-coupon-btn' value='<?php esc_html_e('Select coupon', 'coupon-x'); ?>'/>
                    </div>
                </div>
                <div class='layout-validation' title="<?php esc_html_e('Select a layout', 'coupon-x'); ?>"
                     style="display:none;">
                    <p> <?php esc_html_e('Please select a popup layout before moving to the next step', 'coupon-x'); ?></p>
                    <div class='actions'>
                        <input type='button' class='select-layout'
                               value='<?php esc_html_e('Select layout', 'coupon-x'); ?>'/>
                    </div>
                </div>
                <div class='validation-trigger' title="<?php esc_html_e('No trigger was selected', 'coupon-x'); ?>"
                     style="display:none;">
                    <p class='trigger-error'></p>
                </div>
                <div id="loader" class="center">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100"
                         enable-background="new 0 0 0 0" xml:space="preserve" style="width:150px;height:150px;">
                        <path fill="#fff"
                              d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                              from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                        </path>
                    </svg>
                </div>
                <?php $dashboard_link = admin_url('admin.php?page=couponx'); ?>
                <div id="wp_flash_message" class="hide">
                    <?php echo __('Settings saved (visit your  ', 'coupon-x') . '<a id="go-dashboard" href="' . $dashboard_link . '">' . __('Dashboard', 'coupon-x') . '</a>' . __(' for stats)', 'coupon-x'); ?>
                    <span>
                        <a href="#" class="close_flash_popup">&#x2715;</a>
                    </span>
                </div>
                <div id="wp_error_flash_message" class="hide">
                    <?php echo __("You've already created a Coupon X widget. Please ", 'coupon-x') . '<a id="go-dashboard" href="' . $dashboard_link . '">' . __('go to the dashboard', 'coupon-x') . '</a>' . __(' to edit it.', 'coupon-x'); ?>
                    <span>
                        <a href="#" class="close_flash_popup">&#x2715;</a>
                    </span>
                </div>
            </form>
        </div>
        <div class='mobile-preview-bg'></div>
        <?php 
    }


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
