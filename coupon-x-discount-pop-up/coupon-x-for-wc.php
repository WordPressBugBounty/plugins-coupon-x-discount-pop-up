<?php
/**
    Plugin Name: Coupon X Discount Pop Up
    Description: Use Coupon X to surprise visitors with engaging discount codes to boost your WooCommerce store's sales
    Author: Premio
    Author URI: https://premio.io/downloads/coupon-x-discount-pop-up/
    Version: 1.4.5
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
define('COUPON_X_VERSION', '1.4.5');

require_once 'inc/class-coupon-x.php';
require_once 'inc/class-cx-rest.php';
require_once 'inc/class-cx-review-box.php';
require_once 'inc/class-email-signup.php';
require_once 'inc/class-cx-help.php';


register_activation_hook(COUPON_X_FILE, __NAMESPACE__.'\\save_redirect_status');


/**
 * Save redirection value on plugin activation.
 */
function save_redirect_status()
{
    if(!defined("DOING_AJAX")) {
        update_option('cx_redirect_user', true, 'no');
    }

    global $wpdb;

    $lead_table = $wpdb->prefix.'cx_leads';
    $charset_collate = $wpdb->get_charset_collate();
    
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $lead_table)) !== $lead_table) {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange
        $sql = "CREATE TABLE {$lead_table} (
            id int NOT NULL AUTO_INCREMENT,
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

}//end save_redirect_status()

if (!function_exists('couponx_plugin_check_db_table')) {
    function couponx_plugin_check_db_table()
    {
        global $wpdb;
        $lead_table = $wpdb->prefix . 'cx_leads';
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['page']) && ($_GET['page'] == "couponx" || $_GET['page'] == "couponx_pro_features" || $_GET['page'] == "leads_list" || $_GET['page'] == "cx_integrations" || $_GET['page'] == "couponx_pricing_tbl")) {
            // version 2.7.3 change added new column
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter
            $field_check = $wpdb->get_var($wpdb->prepare("SHOW COLUMNS FROM `{$lead_table}` LIKE %s", 'name'));
 
            if ('name' != $field_check) {
                  
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, PluginCheck.Security.DirectDB.UnescapedDBParameter
                $wpdb->query("ALTER TABLE `{$lead_table}` ADD `name` VARCHAR(100) NULL DEFAULT NULL AFTER `id`");
            }
        }

    }//end couponx_plugin_check_db_table()
    add_action('admin_init', __NAMESPACE__ . '\\couponx_plugin_check_db_table');
}