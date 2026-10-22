<?php
/**
 * Coupon X uninstall cleanup.
 *
 * Removes the plugin's settings and scheduled tasks. Leads and widgets are kept, so
 * reinstalling the plugin restores them. WooCommerce coupons are store data and are never
 * deleted here. To also remove widgets and leads, add this line to wp-config.php before
 * deleting the plugin:
 *
 *     define('COUPON_X_REMOVE_ALL_DATA', true);
 *
 * @package Coupon_X
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$couponx_options = [
    'cx_convert_serialize_to_json',
    'cx_db_version',
    'cx_redirect_user',
    'cx_total_widget',
    'cx_wc_popup',
    'cx_widget_cpt_private',
    'cx_signup_popup',
    'cx_next_signup_date',
    'cx_show_signup_modal',
    'hide_couponx_plugins',
    'hide_coupon-x_cta',
    'coupon-x-discount-pop-up_hide_review_box',
    'coupon-x-discount-pop-up_show_review_box_after',
];
foreach ($couponx_options as $couponx_option) {
    delete_option($couponx_option);
}

wp_clear_scheduled_hook('couponx_cleanup_unused_coupons');

if (defined('COUPON_X_REMOVE_ALL_DATA') && COUPON_X_REMOVE_ALL_DATA) {
    global $wpdb;

    // Widgets.
    $couponx_widgets = get_posts(
        [
            'post_type'   => 'cx_widget',
            'post_status' => 'any',
            'numberposts' => -1,
            'fields'      => 'ids',
        ]
    );
    foreach ($couponx_widgets as $couponx_widget_id) {
        wp_delete_post($couponx_widget_id, true);
    }

    // Leads table.
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange
    $wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}cx_leads`");
}
