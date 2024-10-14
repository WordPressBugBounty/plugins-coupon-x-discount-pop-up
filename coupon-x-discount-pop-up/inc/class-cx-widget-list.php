<?php
/**
 * Coupon Listing
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
 * Display widget list
 */
class Cx_Widget_List
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->list_widgets();

    }//end __construct()


    /**
     * Fetch and display widget list and widget statistics.
     */
    public function list_widgets()
    {
        $posts          = get_posts(
            [
                'numberposts' => -1,
                'post_type'   => 'cx_widget',
            ]
        );
        $new_widget_url = admin_url('admin.php?page=couponx_pro_features');
        if ($posts) {
            ?>
        <div class='cx-widget-listing'>
            <a class='new-widget' href='<?php echo esc_attr($new_widget_url); ?>'>
            <?php esc_html_e('Create New Widget', 'cx'); ?>
            </a>            
            <table class='widget-listing'>
                <input type='hidden' name='cx_nonce' value = '<?php echo wp_create_nonce('wp_rest'); ?>' />
                <thead>
                    <th> <?php esc_html_e('Status', 'coupon-x'); ?> </th>
                    <th> <?php esc_html_e('Widget Name', 'coupon-x'); ?> </th>
                    <th> <?php esc_html_e('Widget Type', 'coupon-x'); ?> </th>
                    <th> 
                        <span class="icon label-tooltip coupon-dashboard" title="<?php esc_html_e(' The number of people who viewed your widget', 'coupon-x'); ?>">
                            <span class="dashicons dashicons-editor-help dashboard-wrap"></span>
                        </span>
                        <?php esc_html_e('Visitors', 'coupon-x'); ?>
                    </th>
                    <th>
                        <span class="icon label-tooltip coupon-dashboard" title="<?php esc_html_e('The number of unique times your widget was opened', 'coupon-x'); ?>">
                            <span class="dashicons dashicons-editor-help dashboard-wrap"></span>
                        </span> 
                        <?php esc_html_e('Open Rate', 'coupon-x'); ?>
                    </th>
                    <th> 
                        <span class="icon label-tooltip coupon-dashboard" title="<?php esc_html_e('The number of times people click on the Copy button on your widget', 'coupon-x'); ?>">
                            <span class="dashicons dashicons-editor-help dashboard-wrap"></span>
                        </span>
            <?php esc_html_e('Conversions', 'coupon-x'); ?> 
                    </th>
                    <th> 
                        <span class="icon label-tooltip coupon-dashboard" title="<?php esc_html_e('The number of times the coupon code was copied divided by the number of times the widget has been opened', 'coupon-x'); ?>">
                            <span class="dashicons dashicons-editor-help dashboard-wrap"></span>
                        </span>
            <?php esc_html_e('% Rate', 'coupon-x'); ?> 
                    </th>
                    <th> <?php esc_html_e('Actions', 'coupon-x'); ?> </th>
                </thead>
                <tbody>
            <?php
            if ($posts) {
                foreach ($posts as $post) {
                    $status      = get_post_meta($post->ID, 'status', true);
                    $widget_type = get_post_meta($post->ID, 'widget_type', true);

                    $visitors = get_post_meta($post->ID, 'visitor', true);
                    $visitors = '' !== $visitors ? $visitors : 0;

                    $open_rate = get_post_meta($post->ID, 'widget_open', true);
                    $open_rate = '' !== $open_rate ? $open_rate : 0;

                    $conversions = get_post_meta($post->ID, 'coupon', true);
                    $conversions = '' !== $conversions ? $conversions : 0;

                    $rate = 0;
                    if ($open_rate > 0) {
                        $rate = (( $conversions / $open_rate ) * 100);
                    }
                    ?>
                        <tr data-widget='<?php echo esc_attr($post->ID); ?>'>
                            <td>
                                <label class="couponapp-switch">
                                    <input type="checkbox" name="status" value="1" <?php echo checked($status, 1, false); ?> widget-id = '<?php echo esc_attr($post->ID); ?>' class='widget-status' />
                                    <span class="cx-slider round">
                                        <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                        <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                    </span>
                                </label>
                            </td>
                            <td><?php echo esc_attr($post->post_title); ?></td>
                            <td>
                    <?php
                    if ('style-1' === $widget_type) {
                        echo esc_html__('Show Coupon', 'coupon-x');
                    } else if ('style-2' === $widget_type) {
                        echo esc_html__('Email', 'coupon-x');
                    } else if ('style-3' === $widget_type) {
                        echo esc_html__('External Link', 'coupon-x');
                    } else if ('style-4' === $widget_type) {
                        echo esc_html__('Announcement', 'coupon-x');
                    } else {
                               echo esc_html__('Announcement Email', 'coupon-x');
                    }
                    ?>
                            </td>
                            <td><?php echo esc_attr($visitors); ?></td>
                            <td><?php echo esc_attr($open_rate); ?></td>
                            <td><?php echo esc_attr($conversions); ?></td>
                            <td><?php echo esc_attr(round($rate, 2)); ?></td>
                            <td>
                                <a href='<?php echo esc_url(admin_url().'admin.php?page=add_couponx&id='.esc_attr($post->ID)); ?>'  title='Edit'>
                                    <span class="dashicons dashicons-edit"></span>
                                </a>
                                <a href='<?php echo esc_url(admin_url('admin.php?page=couponx_pro_features')); ?>' title='Duplicate'>
                                    <span class="dashicons dashicons-admin-page"></span>
                                </a>                                
                                <a href='#' class='delete-widget' widget-id = '<?php echo esc_attr($post->ID); ?>' title='Delete'>
                                    <span class="dashicons dashicons-trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php
                }//end foreach
            }//end if
            ?>
                </tbody>
            </table>
        </div>
        <div id="couponapp-widget-delete-confirm" class="couponapp-widget-dialog" title="<?php esc_attr_e('Delete Widget?', 'coupon-x'); ?>" style='display: none;'>
            <p>
            <?php esc_attr_e('Are you sure you want to delete this widget?', 'coupon-x'); ?>
            </p>
            <input type="hidden" id="dashboard_widget_id" value="" />
        </div>
        <div id="loader" class="center">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="width:150px;height:150px;"><path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"><animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform></path></svg>
        </div>
        <div id="wp_flash_message" class="hide">
            <?php echo esc_html__('Widget is deleted successfully', 'coupon-x'); ?>
            <span>
                <a href="#" class="close_flash_popup">&#x2715;</a>
            </span>
        </div>
            <?php
        } else {
            $this->display_no_widget();
        }//end if

    }//end list_widgets()


    /**
     *  Display no widgets UI if widget list is empty.
     */
    public function display_no_widget()
    {
        ?>
        <div class="empty-widget-wrapper">
        <div class="main-chaty-rate-popup empty-widget" >
            <div class="empty-widget-rate-box" >
                <div class="rate-popup-content">
                    <div class="rate-popup-content-wrapper">
                        <img src='<?php echo esc_url(COUPON_X_URL.'/assets/img/welcome.svg'); ?>'>
                        <h4><?php esc_html_e('Welcome to Coupon X', 'coupon-x'); ?></h4>
                        <p> 
                            <?php esc_html_e('Create beautiful promo code pop ups and get more sales today!', 'coupon-x'); ?>
                        </p>
                    </div>
                </div>
                <div class="rate-popup-content-footer" style="">
                    <button type="button" class="welcompopupbtn btn btn-blue" href='<?php echo esc_url(admin_url().'admin.php?page=add_couponx'); ?>'>
                        <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0001 29.3334C23.3639 29.3334 29.3334 23.3639 29.3334 16.0001C29.3334 8.63628 23.3639 2.66675 16.0001 2.66675C8.63628 2.66675 2.66675 8.63628 2.66675 16.0001C2.66675 23.3639 8.63628 29.3334 16.0001 29.3334Z" fill="white"/>
                            <path d="M16 10.6667V21.3334" stroke="#656BE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 16H21.3334" stroke="#656BE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php esc_html_e('Create New Widget', 'coupon-x'); ?>
                    </button>
                </div>
            </div>
        </div>
        </div>
        <?php

    }//end display_no_widget()


}//end class

