<?php
/**
    Plugin Name: Coupon X Discount Pop Up
    Description: Use Coupon X to surprise visitors with engaging discount codes to boost your WooCommerce store's sales
    Author: Premio
    Author URI: https://premio.io/downloads/coupon-x-discount-pop-up/
    Version: 1.4.8
    Requires at least: 6.2
    Requires PHP: 7.4
    WC requires at least: 6.0
    Text Domain: coupon-x-discount-pop-up
    Domain Path: /languages
    License: GPLv3

    @package Coupon X
*/

// Main plugin file.
namespace Coupon_X;

if (! defined('ABSPATH')) {
    exit;
}

// Define constants.
define('COUPON_X_FILE', __FILE__);
define('COUPON_X_PATH', __DIR__);
define('COUPON_X_URL', plugin_dir_url(COUPON_X_FILE));
define('COUPON_X_BUILD_URL', COUPON_X_FILE.'build/');
define('COUPON_X_PLUGIN_BASE', plugin_basename(COUPON_X_FILE));
define('COUPON_X_FREE_DEV_MODE', false);
define('COUPON_X_VERSION', '1.4.8');
define('COUPON_X_DB_VERSION', '1.1');

require_once 'inc/class-coupon-x.php';
require_once 'inc/class-cx-rest.php';
require_once 'inc/class-cx-review-box.php';
require_once 'inc/class-email-signup.php';
require_once 'inc/class-cx-help.php';


register_activation_hook(COUPON_X_FILE, __NAMESPACE__.'\\save_redirect_status');
register_deactivation_hook(COUPON_X_FILE, __NAMESPACE__.'\\couponx_deactivate');

/**
 * Coupon X creates WooCommerce coupons: tell admins when WooCommerce is not active.
 */
function woocommerce_missing_notice()
{
    if (class_exists('WooCommerce') || !current_user_can('activate_plugins')) {
        return;
    }
    // Only on the Plugins screen and Coupon X pages, not on every admin page.
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || ('plugins' !== $screen->id && false === strpos((string) $screen->id, 'couponx'))) {
        return;
    }
    echo '<div class="notice notice-warning"><p>'
        . esc_html__('Coupon X needs WooCommerce to create and show discount coupons. Please install and activate WooCommerce. Until then only announcement pop ups are shown on your site.', 'coupon-x-discount-pop-up')
        . '</p></div>';
}
add_action('admin_notices', __NAMESPACE__.'\\woocommerce_missing_notice');


/**
 * Save redirection value on plugin activation.
 */
function save_redirect_status()
{
    if(!defined("DOING_AJAX")) {
        update_option('cx_redirect_user', true, 'no');
    }

    // Create the table, or add columns missing in a table from an older version.
    delete_option('cx_db_version');
    couponx_plugin_check_db_table();

}//end save_redirect_status()


/**
 * Stop the daily coupon cleanup when the plugin is deactivated.
 */
function couponx_deactivate()
{
    wp_clear_scheduled_hook('couponx_cleanup_unused_coupons');

}//end couponx_deactivate()


/**
 * Create the leads table when it does not exist yet.
 */
function create_leads_table()
{
    global $wpdb;

    $lead_table = $wpdb->prefix.'cx_leads';
    $charset_collate = $wpdb->get_charset_collate();
    
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $lead_table)) !== $lead_table) {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange
        $sql = "CREATE TABLE {$lead_table} (
            id int NOT NULL AUTO_INCREMENT,
            name varchar(100) NULL DEFAULT NULL,
            email varchar(255),
            widget_id int,
            widget_name varchar(255),
            date varchar(50),
            coupon_code varchar(100),
            ip_address tinytext,
            PRIMARY KEY (id)
            ) {$charset_collate};";

        include_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}//end create_leads_table()

/**
 * Create / upgrade the leads table once per database version.
 *
 * Runs on admin_init, which also fires for admin-ajax.php requests (email capture), so the
 * table is ready even when nobody visits the plugin pages after an update. The option check
 * keeps it to one cheap get_option() call per request.
 */
function couponx_plugin_check_db_table()
{
    if (COUPON_X_DB_VERSION === get_option('cx_db_version')) {
        return;
    }

    global $wpdb;
    $lead_table = $wpdb->prefix . 'cx_leads';

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $lead_table)) !== $lead_table) {
        create_leads_table();
    } else {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter
        $field_check = $wpdb->get_var($wpdb->prepare("SHOW COLUMNS FROM `{$lead_table}` LIKE %s", 'name'));
        if ('name' !== $field_check) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, PluginCheck.Security.DirectDB.UnescapedDBParameter
            $wpdb->query("ALTER TABLE `{$lead_table}` ADD `name` VARCHAR(100) NULL DEFAULT NULL AFTER `id`");
        }
    }

    update_option('cx_db_version', COUPON_X_DB_VERSION, false);

}//end couponx_plugin_check_db_table()
add_action('admin_init', __NAMESPACE__ . '\\couponx_plugin_check_db_table');
