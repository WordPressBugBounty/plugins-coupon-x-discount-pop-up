<?php
/**
 * Create Coupon - Triggers and Targeting
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
 * Create new widget - triggers & targeting tab
 */
class Cx_Widget_Triggers
{


    /**
     * Constructor function
     *
     * @param settings $settings array of widget settings.
     */
    public function __construct($settings)
    {
        $this->render_triggers($settings);

    }//end __construct()


    /**
     * Renders triggers & targeting tab html
     *
     * @param settings $settings array of widget settings.
     */
    public function render_triggers($settings)
    {
        if (! isset($settings['display_desktop']) && isset($_GET['id'])) {
            $desktop = 0;
        }

        $collections = [];
        $products    = [];

        ?>
        <div class='triggers-tab'>
            <div class='trigger-settings'>                
                <div class='cx-tab'>
                    <h3><?php esc_html_e('Triggers & Targeting', 'coupon-x'); ?></h3>
                    <div class='row mx-height-110'>
                        <div class='row-elements full'>
                            <label> 
                                <?php esc_html_e('Devices', 'coupon-x'); ?> 
                            </label>
                            <ul class='devices-list'>
                                <li>
                                    <label>
                                        <input type='checkbox' class='chk-desktop' name='cx_settings[trigger][display_desktop]' value='1' 
                                        <?php echo  checked(1, $settings['display_desktop'], false); ?> > 
                                        <?php esc_html_e('Desktop', 'coupon-x'); ?>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type='checkbox' class='chk-mobile' name='cx_settings[trigger][display_mobile]' value='1' 
                                        <?php echo checked(1, $settings['display_mobile'], false); ?>> 
                                        <?php esc_html_e('Mobile', 'coupon-x'); ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label> 
                                <?php esc_html_e('When to open the pop up?', 'coupon-x'); ?> 
                            </label>
                            <select name='cx_settings[trigger][when]' class='input-element'>                               
                                <?php
                                $when         = $settings['when'];
                                $when_trigger = [
                                    'hover' => esc_html__('Open the pop up on hover', 'coupon-x'),
                                    'click' => esc_html__('Open the pop up on click', 'coupon-x'),
                                    'open'  => esc_html__('Open the pop up on load', 'coupon-x'),

                                ];
                                foreach ($when_trigger as $key => $value) {
                                    ?>
                                    <option value='<?php echo esc_attr($key); ?>' <?php echo selected($when, $key, false); ?>>
                                    <?php echo esc_attr($value); ?> 
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label> 
                                <?php esc_html_e('Trigger ', 'coupon-x'); ?> <span><?php esc_html_e(' (Decide when & how the pop up will trigger)', 'coupon-x'); ?> </span> 
                            </label>
                        </div>
                    </div>
                    <div class='row gray-bg first'>
                        <div class='row-elements full'>
                            <label>
                                <span class="icon label-tooltip" title="<?php esc_html_e('The popup will trigger after a brief period of time', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                                <input type='checkbox' name='cx_settings[trigger][enable_time_delay]' value='1' 
                                <?php echo checked(1, $settings['enable_time_delay'], false); ?> class='time-delay'> 
                                <?php esc_html_e('Time delay', 'coupon-x'); ?>
                            </label>
                            <label>
                                <span><?php esc_html_e('Display after ', 'coupon-x'); ?></span>
                                <input type='number'  name='cx_settings[trigger][delay_time]' class='input-element delay-time' value='<?php echo esc_attr($settings['delay_time']); ?>' min='0' <?php echo esc_attr(1 !== (int) $settings['enable_time_delay'] ? 'disabled' : ''); ?>/>
                                <span><?php esc_html_e(' seconds on the page', 'coupon-x'); ?></span>
                            </label>
                        </div>
                    </div>
                    <hr />
                    <div class='row gray-bg '>
                        <div class='row-elements full'>
                            <label>
                                <span class="icon label-tooltip" title="<?php esc_html_e('The pop up will trigger after a user scrolls a certain percentage of the website', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                                <input type='checkbox' name='cx_settings[trigger][enable_page_scroll]' value='1' 
                                <?php echo checked(1, $settings['enable_page_scroll'], false); ?> class='page-scroll'> 
                                <?php esc_html_e('Page scroll', 'coupon-x'); ?>
                            </label>
                            <label>
                                <span><?php esc_html_e('Display after ', 'coupon-x'); ?></span>
                                <input type='number'  name='cx_settings[trigger][scroll_percent]' class='input-element scroll-page' value='<?php echo esc_attr($settings['scroll_percent']); ?>' min='0' max='100' <?php echo esc_attr('1' !== $settings['enable_page_scroll'] ? 'disabled' : ''); ?>/>
                                <span><?php esc_html_e(' % on the page', 'coupon-x'); ?></span>
                            </label>
                        </div>
                    </div>
                    <hr />
                    <div class='row gray-bg last'>
                        <div class='row-elements full'>                        
                            <label>
                                <span class="icon label-tooltip" title="<?php esc_html_e('The coupon will automatically trigger and shown when a user is about to leave. ', 'coupon-x'); ?><a href='https://premio.io/help/coupon-x/how-to-add-exit-intent-to-your-widget/' target='_blank'><?php esc_html_e('Read more', 'coupon-x'); ?></a>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                                <input type='checkbox'  name='cx_settings[trigger][exit_intent]'  value='1' <?php echo checked(1, $settings['exit_intent'], false); ?> class='exit-intent'/>
                                <?php esc_html_e('Exit Intent', 'coupon-x'); ?>
                            </label>
                            <span>
                                <?php esc_html_e('The coupon pop-up will be shown automatically when visitors are about to leave the store', 'coupon-x'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='cx-tab-rule'>                    
        <?php
        $this->render_cart_rule($settings, $products, $collections);
        $this->render_order_rule($settings, $collections, $products);
        $this->render_date_scheduling_rule($settings);
        $this->render_day_hour_scheduling_rule($settings);
        $this->render_page_rule($settings);
        $this->render_traffic_source_rule($settings);
        $this->render_os_rule($settings);
        ?>
                    <div class='rule-row'>
                        <div class='rule-row-elements full country-rule'>
                            <label>
                                <span class="icon label-tooltip" title="<?php esc_html_e('Target your widget to specific countries. You can create different widgets for different countries', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span> 
                                <?php esc_html_e('Country targeting (When Off: Show for all countries)', 'coupon-x'); ?> 
                            </label>
                            <select class='input-element country-dropdown' name='' multiple>
                                <option value='' selected><?php esc_html_e('All countries', 'coupon-x'); ?></option>
                            </select>
                            <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                                <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                            </a>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <?php

    }//end render_triggers()


    /**
     * Render cart rule placeholder html
     */
    public function render_cart_rule()
    {
        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Display the Coupon X widget only for visitors who meet the condition you set. For example, you can show the Coupon X widget only to visitors that have more than 10 items in their cart, or visitors with specific items in their cart', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('Cart targeting (When Off: Show the widget for any cart value)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg'>
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' 
                        class='cart-rule btn-rule'>
                    <div class='cart-rule hide'>
                        <select class='cart-type show-cart input-element' name=''>
                            <option value='1'>
                                <?php esc_html_e('Show', 'coupon-x'); ?>
                            </option>
                            <option value='2'>
                                <?php esc_html_e('Don\'t Show', 'coupon-x'); ?>
                            </option>
                        </select>
                        <select class='cart-type cart-value input-element' name=''>
                            <option value="" disabled  selected>
                                <?php esc_html_e('Cart type', 'coupon-x'); ?>
                            </option>
                            <option value='1'>
                                <?php esc_html_e('Cart money value', 'coupon-x'); ?>
                            </option>
                            <option value='2'>
                                <?php esc_html_e('Number of cart items', 'coupon-x'); ?>
                            </option>
                            <option value='3' >
                                <?php esc_html_e('Products in the cart', 'coupon-x'); ?>
                            </option>
                        </select>
                        <select class='cart-type cart-condition input-element ' 
                            name='' >
                            <option value="" disabled  selected>
                                <?php esc_html_e('Condition', 'coupon-x'); ?>
                            </option>
                            <option value='1' >
                                <?php esc_html_e('Over or equal', 'coupon-x'); ?>
                            </option>
                            <option value='2' >
                                <?php esc_html_e('Equal', 'coupon-x'); ?>
                            </option>
                            <option value='3'>
                                <?php esc_html_e('Under', 'coupon-x'); ?>
                            </option>
                        </select>                                                
                        <input type='number' class='input-element cart-val hide' 
                            name='' value='' min='0' />
                        <div class="day-buttons">
                            <a class="remove-cart-targeting" href="javascript:;">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                </svg>
                            </a>
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>                    
                </div>                
            </div>
            <p class='error hide' ></p>
        </div>
        <?php

    }//end render_cart_rule()


    /**
     * Render page rule placeholder html
     */
    public function render_page_rule()
    {

        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Show or don\'t show the widget on specific pages. You can use rules like contains, exact match, starts with, and ends with', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('Show on pages (When Off: Show on all pages)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg page-rule-box'>                    
                    <div class='page-rule hide'>
                        <select class='cart-type page-rule-enable input-element' name=''>
                            <option value='1'>
                                <?php esc_html_e('Show On', 'coupon-x'); ?>
                            </option>
                            <option value='2' >
                                <?php esc_html_e('Don\'t Show On', 'coupon-x'); ?>
                            </option>
                        </select>
                        <select class='cart-type page-type input-element' name=''>
                            <option disabled value='' ><?php esc_html_e('Select rule', 'coupon-x'); ?></option>
                            <option value='1' >
                                <?php esc_html_e('Homepage', 'coupon-x'); ?>
                            </option>
                            <option value='2'>
                                <?php esc_html_e('Links that contain', 'coupon-x'); ?>
                            </option>
                            <option value='3'>
                                <?php esc_html_e('A specific link', 'coupon-x'); ?>
                            </option>
                            <option value='4'>
                                <?php esc_html_e('Links starting with', 'coupon-x'); ?>
                            </option>
                            <option value='5'>
                                <?php esc_html_e('Links ending with', 'coupon-x'); ?>
                            </option>
                            <option value='6'>
                                <?php esc_html_e('WordPress Pages', 'coupon-x'); ?>
                            </option>
                            <option value='7'>
                                <?php esc_html_e('WordPress Posts', 'coupon-x'); ?>
                            </option>
                            <option value='8'>
                                <?php esc_html_e('WordPress Categories', 'coupon-x'); ?>
                            </option>
                            <option value='9'>
                                <?php esc_html_e('WordPress Tags', 'coupon-x'); ?>
                            </option>
                            <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
                                <option value='10'>
                                    <?php esc_html_e('Woocommerce products', 'coupon-x'); ?>
                                </option>
                                <option value='11'>
                                    <?php esc_html_e('Woocommerce products on sale', 'coupon-x'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class='site-url '> 
                            <?php echo site_url().'/'; ?>
                        </span>
                        <input type='text' class='input-element page-rule-val ' name='' value='' readonly>
                        <div class="day-buttons">
                            <a class="remove-page-targeting" href="javascript:;">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                </svg>
                            </a>
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>                    
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' class='page-rule btn-rule '>
                </div>
            </div>
        </div>
        <?php

    }//end render_page_rule()


    /**
     * Render order rule placeholder html
     */
    public function render_order_rule()
    {
        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('The order history targeting feature is based on orders from the past 60 days', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('Order history targeting (When Off: Show the widget no matter what was ordered in the past)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg'>
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' 
                        class='order-rule btn-rule '>
                    <div class='order-rule hide '>
                        <select class='cart-type show-order input-element' name=''>
                            <option value='1' >
                                <?php esc_html_e('Show', 'coupon-x'); ?>
                            </option>
                            <option value='2' >
                                <?php esc_html_e('Don\'t Show', 'coupon-x'); ?>
                            </option>
                        </select>
                        <select class='cart-type order_rule_condition input-element' name=''>
                            <option value='' disabled> <?php esc_html_e('Based on the following purchase history', 'coupon-x'); ?></option>
                            <option value='1' >
                                <?php esc_html_e('Any product', 'coupon-x'); ?>
                            </option>
                            <option value='2'>
                                <?php esc_html_e('Products from a specific collection', 'coupon-x'); ?>
                            </option>
                            <option value='3' >
                                <?php esc_html_e('Specific products', 'coupon-x'); ?>
                            </option>
                            <option value='4' >
                                <?php esc_html_e("New users (users who haven't made a purchase yet)", 'coupon-x'); ?>
                            </option>
                            <option value='5' >
                                <?php esc_html_e('Number of products ordered', 'coupon-x'); ?>
                            </option>
                            <option value='6' >
                                <?php esc_html_e('Money value', 'coupon-x'); ?>
                            </option>
                        </select>                        
                        <div class="day-buttons">
                            <a class="remove-order-targeting" href="javascript:;">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                </svg>
                            </a>
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>
                </div>                
            </div>
        </div>
        <?php

    }//end render_order_rule()


    /**
     * Render date rule placeholder html
     */
    public function render_date_scheduling_rule()
    {

        ?>
        <div class='rule-row'>
            <div class='full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Schedule the specific time and date when your Coupon X widget appears. Use this feature to offer time-limited coupons, or to start a promotion from a specific date.', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('Date scheduling (When Off: Show the widget immediately)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg'>
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' 
                        class='date-rule btn-rule '
                        >                    
                    <div class='date-rule hide'>
                        <div class='date-row'>
                            <div>
                                <label><?php esc_html_e('Start Date', 'coupon-x'); ?></label>
                                <input type='text'  class='display_start_date input-element'/>
                            </div>
                            <div>
                                <label><?php esc_html_e('Start Time', 'coupon-x'); ?></label>
                                <input type='text'  class='display_start_time input-element'/>
                            </div>
                            <div>
                                <?php
                                $current_timezone = wp_timezone_string();
                                ?>
                                <label><?php esc_html_e('Timezone', 'coupon-x'); ?></label>
                                <select class='input-element trigger-timezone' >
                                    <?php echo wp_timezone_choice($current_timezone); ?>
                                </select>
                            </div>
                        </div>
                        <div class='date-row'>
                            <div>
                                <label><?php esc_html_e('End Date', 'coupon-x'); ?></label>
                                <input type='text'  class='display_end_date input-element'/>
                            </div>
                            <div>
                                <label><?php esc_html_e('End Time', 'coupon-x'); ?></label>
                                <input   type='text'  class='display_end_time input-element'/>
                            </div>
                            <div class="day-buttons" style='margin-top:5%'>
                                <a class="remove-date-targeting" href="javascript:;">
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                        <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>
                </div>                
            </div>
            <p class='error hide' ></p>
        </div>
        <?php

    }//end render_date_scheduling_rule()


    /**
     * Render day and hour rule placeholder html
     */
    public function render_day_hour_scheduling_rule()
    {

        $show_on = [
            'Everyday of week',
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday to Thursday',
            'Monday to Friday',
            'Weekend',
        ];

        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Display the widget on specific days and hours based on your opening days and hours', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('Days and hours (When Off: Show the widget all the time)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg day-rule-box'>                    
                    <div class='day-rule hide'>
                        <select class='cart-type day-rule-enable input-element' >
        <?php
          $j = 0;
        foreach ($show_on as $day) {
            ?>
                                <option value='<?php echo esc_attr($j); ?>' >
            <?php echo esc_attr($day); ?>
                                </option>
            <?php
            $j++;
        }
        ?>
                        </select>
                        <div class='day-from'>
                            <span>From</span>
                            <input type='text' class='input-element day-start-time' />
                        </div>
                        <div class='day-to'>
                            <span>To</span>
                            <input type='text' class='input-element day-end-time' />
                        </div>
                        <div class='day-zone'>                            
          <?php
            $current_timezone = wp_timezone_string();
            ?>
                            <label><?php esc_html_e('Timezone', 'coupon-x'); ?></label>
                            <select class='input-element day-timezone' >
                                <?php echo wp_timezone_choice($current_timezone); ?>
                            </select>
                        </div>
                        <div class="day-buttons">
                            <a class="remove-day-targeting" href="javascript:;">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                    <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                </svg>
                            </a>
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>                
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' class='day-rule btn-rule'>
                </div>
            </div>
        </div>        
        <?php

    }//end render_day_hour_scheduling_rule()


    /**
     * Render Traffic rule placeholder html
     */
    public function render_traffic_source_rule()
    {
        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget only to visitors who come from specific traffic sources including direct traffic, social networks, search engines, Google Ads, or any other traffic source', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
                    <?php esc_html_e('Traffic source (When Off: Show for any traffic source)', 'coupon-x'); ?>
                </label>
                <div class='rule-box gray-bg'>
                    <div class='traffic-rule-main hide'>
                        <div class='row-elements full'>
                            <label class="couponapp-switch">
                                <input type="checkbox" disabled/>
                                <span class="cx-slider round">
                                    <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                    <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                </span>
                            </label>
                            <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'> 
                                <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to visitors who arrived to your website from direct traffic', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span> 
                                <?php esc_html_e('Direct visit', 'coupon-x'); ?> 
                            </label>
                        </div>
                        <div class='row-elements full'>
                            <label class="couponapp-switch">
                                <input type="checkbox" disabled />
                                <span class="cx-slider round">
                                    <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                    <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                </span>
                            </label>
                            <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'> 
                                <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to visitors who arrived to your website from social networks including: Facebook, Twitter, Pinterest, Instagram, Google+, LinkedIn, Delicious, Tumblr, Dribbble, StumbleUpon, Flickr, Plaxo, Digg and more', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span> 
                                <?php esc_html_e('Social networks', 'coupon-x'); ?> 
                            </label>
                        </div>
                        <div class='row-elements full'>
                            <label class="couponapp-switch">
                                <input type="checkbox" disabled />
                                <span class="cx-slider round">
                                    <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                    <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                </span>
                            </label>
                            <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'> 
                                <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to visitors who arrived from search engines including: Google, Bing, Yahoo!, Yandex, AOL, Ask, WOW,  WebCrawler, Baidu and more', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span> 
                                <?php esc_html_e('Search engines', 'coupon-x'); ?> 
                            </label>
                        </div>
                        <div class='row-elements full'>
                            <label class="couponapp-switch">
                                <input type="checkbox" disabled />
                                <span class="cx-slider round">
                                    <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                    <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                </span>
                            </label>
                            <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'> 
                                <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to visitors who arrived from search engines including: Google, Bing, Yahoo!, Yandex, AOL, Ask, WOW,  WebCrawler, Baidu and more', 'coupon-x'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span> 
                                <?php esc_html_e('Google Ads', 'coupon-x'); ?> 
                            </label>
                        </div>
                        <label>
        <?php esc_html_e('Specific URL', 'coupon-x'); ?> 
                        </label>
                        <div class='traffic-url-rules'>                            
                            <div class='url-rule'>
                                <div>
                                    <select  class='input-element url-select'>
                                        <option value='0'>Contains</option>
                                        <option value='1'>Not contains</option>
                                    </select>
                                </div>
                                <div>
                                    <input type='text' class='input-element url-val' value='' placeholder='http://www.example.com' readonly>
                                </div>
                            </div>                                                            
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' 
                        class='traffic-rule btn-rule invalid-key'
                        >
                        <input type='button' value='<?php esc_html_e('Remove Rule', 'coupon-x'); ?>' 
                        class='remove-traffic-rule btn-rule hide'>
                </div>                
            </div>
        </div>
        <?php

    }//end render_traffic_source_rule()


    /**
     * Render OS and Browser rule placeholder html for mobile and desktop users
     */
    public function render_os_rule()
    {
        ?>
        <div class='rule-row'>
            <div class='rule-row-elements full'>
                <label>
                    <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget only to visitors who come from specific operating system and browser', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span> 
        <?php esc_html_e('OS and Browsers (When OFF: display on all operating systems and browsers)', 'coupon-x'); ?> 
                </label>
                <div class='rule-box gray-bg'>
                    <input type='button' value='<?php esc_html_e('Add Rule', 'coupon-x'); ?>' 
                            class='os-rule btn-rule' >                    
                    <div class='os-rule hide'>
                        <div class='os-row'>
                            <div>
                                <label>
                                    <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to desktop visitors who are using specific operating systems and browsers', 'coupon-x'); ?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span> 
                                    <?php esc_html_e('Desktop', 'coupon-x'); ?>
                                </label>
                            </div>
                            <div>
                                <select class='cart-type input-element desktop-dropdown '  multiple >
                                    <option value='All' selected><?php esc_html_e('All Desktop Operating Systems', 'coupon-x'); ?></option>
                                        <?php
                                        $desktop_os = [
                                            'Windows',
                                            'Windows NT',
                                            'Mac OS',
                                            'Debian',
                                            'Ubuntu',
                                            'Macintosh',
                                            'OpenBSD',
                                            'Linux',
                                            'ChromeOS',
                                        ];
                                        foreach ($desktop_os as $os) {
                                            ?>
                                            <option value='<?php echo esc_attr($os); ?>' >
                                            <?php echo esc_attr($os); ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                </select>                            
                            </div>
                            <div>
                                <select class='cart-type input-element desktop-browser-dropdown'  multiple >
                                    <option value='All' selected><?php esc_html_e('All Desktop Browsers', 'coupon-x'); ?></option>
             <?php
                $desktop_browsers = [
                    'OPR'               => 'Opera Mini',
                    'OPR'               => 'Windows NT',
                    'Edg'               => 'Edge',
                    'Coc Coc'           => 'Coc Coc',
                    'UCBrowser'         => 'UCBrowser',
                    'Vivaldi'           => 'Vivaldi',
                    'Chrome'            => 'Chrome',
                    'Firefox'           => 'Firefox',
                    'Safari'            => 'Safari',
                    'Internet Explorer' => 'IE',
                    'Netscape'          => 'Netscape',
                    'Mozilla'           => 'Mozilla',
                    'Blazer'            => 'Blazer',
                    'WeChat'            => 'WeChat',
                    'baiduboxapp'       => 'baiduboxapp',
                    'baidubrowser'      => 'baidubrowser',
                    'DiigoBrowser'      => 'DiigoBrowser',
                    'GenericBrowser'    => 'GenericBrowser',
                    'PaleMoon'          => 'PaleMoon',
                ];
                foreach ($desktop_browsers as $key => $val) {
                    ?>
                                            <option value='<?php echo esc_attr($key); ?>' >
                    <?php echo esc_attr($val); ?>
                                            </option>
                    <?php
                }
                ?>
                                </select>
                            </div>
                            <div class="day-buttons">
                                <a class="remove-os-targeting" href="javascript:;">
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"></rect>
                                        <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"></rect>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class='os-row'>
                            <div>
                                <label>
                                    <span class="icon label-tooltip" title="<?php esc_html_e('Show the widget to mobile visitors who are using specific operating systems and browsers', 'coupon-x'); ?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span> 
            <?php esc_html_e('Mobile', 'coupon-x'); ?>
                                </label>
                            </div>
                            <div>
                                <select class='cart-type input-element mobile-dropdown ' multiple >
                                    <option value='All' selected><?php esc_html_e('All Mobile Operating Systems', 'coupon-x'); ?></option>
             <?php
                $mobile_os = [
                    'Android'       => 'AndroidOS',
                    'BlackBerry'    => 'BlackBerryOS',
                    'Palm'          => 'PalmOS',
                    'Symbian'       => 'SymbianOS',
                    'WindowsMobile' => 'WindowsMobileOS',
                    'WindowsPhone'  => 'WindowsPhoneOS',
                    'iPhone'        => 'iOS',
                    'iPad'          => 'iPadOS',
                    'MeeGo'         => 'MeeGoOS',
                    'Maemo'         => 'MaemoOS',
                    'Java'          => 'JavaOS',
                    'web'           => 'webOS',
                    'bada'          => 'badaOS',
                    'BREW'          => 'BREWOS',
                ];
                foreach ($mobile_os as $key => $val) {
                    ?>
                                            <option value='<?php echo esc_attr($key); ?>'>
                    <?php echo esc_attr($val); ?>
                                            </option>
                    <?php
                }
                ?>
                                </select>                            
                            </div>
                            <div>
                                <select class='cart-type input-element mobile-browser-dropdown '  multiple >
                                    <option value='All' selected><?php esc_html_e('All Mobile Browsers', 'coupon-x'); ?></option>
             <?php
                $mobile_browsers = [
                    'OPR'               => 'Opera Mini',
                    'OPR'               => 'Opera',
                    'Edg'               => 'Edge',
                    'Coc Coc'           => 'Coc Coc',
                    'UCBrowser'         => 'UCBrowser',
                    'Vivaldi'           => 'Vivaldi',
                    'Chrome'            => 'Chrome',
                    'Firefox'           => 'Firefox',
                    'Safari'            => 'Safari',
                    'Internet Explorer' => 'IE',
                    'Netscape'          => 'Netscape',
                    'Mozilla'           => 'Mozilla',
                    'Dolfin'            => 'Dolfin',
                    'Skyfire'           => 'Skyfire',
                    'Bolt'              => 'Bolt',
                    'TeaShark'          => 'TeaShark',
                    'baiduboxapp'       => 'baiduboxapp',
                    'baidubrowser'      => 'baidubrowser',
                    'DiigoBrowser'      => 'DiigoBrowser',
                    'Mercury'           => 'Mercury',
                    'ObigoBrowser'      => 'ObigoBrowser',
                    'NetFront'          => 'NetFront',
                    'GenericBrowser'    => 'GenericBrowser',
                    'PaleMoon'          => 'PaleMoon',
                ];
                foreach ($mobile_browsers as $key => $val) {
                    ?>
                                            <option value='<?php echo esc_attr($key); ?>'>
                    <?php echo esc_attr($val); ?>
                                            </option>
                    <?php
                }
                ?>
                                </select>
                            </div>                            
                        </div>
                        <a target='_blank' class="upgrade-cx-button" href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                            <span class="dashicons dashicons-lock"></span>UPGRADE NOW
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
        <?php

    }//end render_os_rule()


}//end class

