<?php
/**
 * Coupon X APIs
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Rest;

use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Rest APIs
 */
class Cx_Rest
{

    /**
     * Statistic counters the frontend may increment.
     */
    const STATS_KEYS = ['visitor', 'widget_open', 'coupon'];

    /**
     * Max. new unique coupons per IP address per hour.
     */
    const COUPON_RATE_LIMIT = 20;

    /**
     * Max. email submissions per IP address per hour.
     */
    const LEAD_RATE_LIMIT = 10;

    /**
     * Daily cleanup of unused per-visitor coupons.
     */
    const CLEANUP_HOOK = 'couponx_cleanup_unused_coupons';

    /**
     * Constructor.
     */
    public function __construct()
    {
        /* Daily cleanup of per-visitor coupons that were never used */
        add_action(self::CLEANUP_HOOK, [$this, 'cleanup_unused_coupons']);
        add_action('init', [$this, 'schedule_cleanup']);

        /* Fresh nonce + widget tokens for pages served from a full-page cache */
        add_action('wp_ajax_cx_refresh_tokens', [$this, 'refresh_tokens']);
        add_action('wp_ajax_nopriv_cx_refresh_tokens', [$this, 'refresh_tokens']);

        add_action('wp_ajax_update_popup_status', [$this, 'update_popup_status']);
        add_action('wp_ajax_create_cx_widget', [$this, 'save_widget_data']);
        add_action('wp_ajax_update_status', [$this, 'update_status']);
        add_action('wp_ajax_delete_widget', [$this, 'delete_widget']);
        add_action('wp_ajax_delete_leads', [$this, 'delete_leads']);

        /* FE Actions does not require permission */
        add_action('wp_ajax_update_widget_stats', [$this, 'update_widget_stats']);
        add_action('wp_ajax_nopriv_update_widget_stats', [$this, 'update_widget_stats']);
        add_action('wp_ajax_capture_email', [$this, 'capture_email']);
        add_action('wp_ajax_nopriv_capture_email', [$this, 'capture_email']);
        add_action('wp_ajax_generate_coupon', [$this, 'generate_coupon']);
        add_action('wp_ajax_nopriv_generate_coupon', [$this, 'generate_coupon']);

    }//end __construct()


    /**
     * Send a JSON response and stop.
     *
     * @param array $response response data.
     */
    private function send_json($response)
    {
        echo wp_json_encode($response);
        exit;
    }

    /**
     * True when the ID belongs to an existing Coupon X widget.
     *
     * @param int $widget_id widget id.
     *
     * @return boolean
     */
    private function is_cx_widget($widget_id)
    {
        return $widget_id > 0 && 'cx_widget' === get_post_type($widget_id);
    }

    /**
     * Load a widget's settings (meta first, legacy post_content as fallback).
     *
     * @param int $widget_id widget id.
     *
     * @return array settings, empty array when the widget does not exist.
     */
    private function get_widget_settings($widget_id)
    {
        if (!$this->is_cx_widget($widget_id)) {
            return [];
        }
        $settings = get_post_meta($widget_id, 'prm_cx_widget_data', true);
        if (empty($settings)) {
            $content  = get_the_content(null, false, $widget_id);
            $content  = $this->clean_json_string($content);
            $settings = json_decode($content, true);
        }
        return is_array($settings) ? $settings : [];
    }

    /**
     * Verify the public page nonce and the widget token sent by the frontend widget.
     *
     * @param int $widget_id widget id.
     *
     * @return boolean
     */
    private function verify_widget_request($widget_id)
    {
        $nonce        = sanitize_text_field((string) filter_input(INPUT_POST, 'nonce'));
        $widget_token = sanitize_text_field((string) filter_input(INPUT_POST, 'widget_token'));

        return !empty($nonce) && wp_verify_nonce($nonce, 'wp_cx_nonce')
            && !empty($widget_token) && wp_verify_nonce($widget_token, 'widget_token_' . $widget_id);
    }

    /**
     * Response used when the nonce/token check fails.
     */
    private function send_invalid_token()
    {
        $this->send_json([
            'status'      => 401,
            'response'    => 'Invalid request',
            'code'        => 'invalid_nonce',
            'error'       => esc_html__('Something went wrong. Please contact site administrator', 'coupon-x-discount-pop-up'),
            'show_coupon' => false,
        ]);
    }

    /**
     * Return a fresh page nonce and widget tokens for the given widgets.
     * admin-ajax.php is not page-cached, so this always returns valid values.
     */
    public function refresh_tokens()
    {
        nocache_headers();

        $ids    = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $ids    = is_array($ids) ? array_slice(array_unique(array_map('absint', $ids)), 0, 50) : [];
        $tokens = [];

        foreach ($ids as $widget_id) {
            if ($this->is_cx_widget($widget_id) && 'publish' === get_post_status($widget_id)) {
                $tokens[$widget_id] = wp_create_nonce('widget_token_' . $widget_id);
            }
        }

        $this->send_json([
            'status' => 200,
            'nonce'  => wp_create_nonce('wp_cx_nonce'),
            'tokens' => $tokens,
        ]);

    }//end refresh_tokens()

    /**
     * IP address used for rate limiting (REMOTE_ADDR only, it cannot be spoofed with headers).
     *
     * @return string
     */
    private function get_rate_limit_ip()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
    }

    /**
     * Simple per-IP rate limit (counter in a transient, reset after one hour).
     *
     * @param string $bucket name of the limit.
     * @param int    $limit  max. actions per hour.
     *
     * @return boolean true when the action is allowed.
     */
    private function within_rate_limit($bucket, $limit)
    {
        $key   = 'cx_' . $bucket . '_rl_' . md5($this->get_rate_limit_ip());
        $count = (int) get_transient($key);
        if ($count >= $limit) {
            return false;
        }
        set_transient($key, $count + 1, HOUR_IN_SECONDS);
        return true;
    }

    /**
     * Allow at most COUPON_RATE_LIMIT new coupons per IP address per hour.
     *
     * @return boolean true when another coupon may be created.
     */
    private function can_create_coupon()
    {
        return $this->within_rate_limit('coupon', self::COUPON_RATE_LIMIT);
    }

    /**
     * Find a published WooCommerce coupon that was created by this widget.
     *
     * @param string $coupon_code code.
     * @param int    $widget_id   widget id.
     *
     * @return int coupon id or 0.
     */
    private function get_widget_coupon_id($coupon_code, $widget_id)
    {
        if ('' === $coupon_code || !function_exists('wc_get_coupon_id_by_code')) {
            return 0;
        }
        $coupon_id = (int) wc_get_coupon_id_by_code($coupon_code);
        if ($coupon_id > 0 && (int) get_post_meta($coupon_id, 'cx_widget_id', true) === (int) $widget_id) {
            return $coupon_id;
        }
        return 0;
    }

    /**
     * Generate a random, hard to guess coupon code that is not in use yet.
     *
     * @return string
     */
    private function generate_unique_code()
    {
        do {
            $code = 'COUPONX' . strtoupper(wp_generate_password(10, false, false));
        } while (wc_get_coupon_id_by_code($code) > 0);
        return $code;
    }

    /**
     * Update Welcome popup status
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function update_popup_status()
    {
        $response = [
            'status'   => 0,
            'response' => 'Invalid request',
        ];
        $nonce = filter_input(INPUT_POST, 'nonce');

        if(!current_user_can('manage_options')) {
            echo json_encode($response);
            exit;
        }

        if(!empty($nonce) && !empty($nonce) && wp_verify_nonce($nonce, 'wp_rest')) {
            add_option('cx_wc_popup', false, '', 'no');
            $response = [
                'status' => 200,
                'response' => 'success',
            ];
        }
        echo json_encode($response);
        exit;

    }//end update_popup_status()


    /**
     * Update widget status
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function update_status()
    {
        $response = [
            'status' => 0,
            'response' => 'Invalid request'
        ];

        if(!current_user_can('manage_options')) {
            echo json_encode($response);
            exit;
        }

        $status = filter_input(INPUT_POST, 'status');
        $id  = filter_input(INPUT_POST, 'id');
        $nonce = filter_input(INPUT_POST, 'nonce');

        $status = isset($status) ? sanitize_text_field($status) : '';
        $id = isset($id) ? absint($id) : 0;
        // Only Coupon X widgets (never other posts).
        $id = $this->is_cx_widget($id) ? $id : '';

        if(isset($nonce) && !empty($nonce) && wp_verify_nonce($nonce, 'wp_rest')) {
            if ('' !== $id && '' !== $status) {
                update_post_meta($id, 'status', $status);
                $response = [
                    'status' => 200,
                    'response' => 'success',
                ];
            } else {
                $response = [
                    'status' => 201,
                    'response' => 'error',
                    'error' => esc_html__('Request could not be completed due to missing parameters', 'coupon-x-discount-pop-up'),
                ];
            }
        }
        echo json_encode($response);
        exit;

    }//end update_status()


    /**
     * Delete widget
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function delete_widget()
    {
        $response = [
            'status'   => 0,
            'response' => 'Invalid request',
        ];

        if(!current_user_can('manage_options')) {
            echo json_encode($response);
            exit;
        }

        $id = absint(filter_input(INPUT_POST, 'id'));
        // Only Coupon X widgets can be deleted here (never other posts).
        $id = $this->is_cx_widget($id) ? $id : '';

        $nonce = filter_input(INPUT_POST, 'nonce');

        if(isset($nonce) && !empty($nonce) && wp_verify_nonce($nonce, 'wp_rest')) {
            if ('' !== $id) {
                wp_delete_post($id, true);
                global $wpdb;
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                $widgets = (int) $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM {$wpdb->posts} WHERE post_type=%s", 'cx_widget'));
                if (0 === $widgets) {
                    update_option('cx_total_widget', 1);
                }

               $response = [
                   'status' => 200,
                   'response' => 'success',
               ];

            } else {
                $response = [
                    'status' => 201,
                    'response' => 'error',
                    'error' => esc_html__('Request could not be completed due to missing parameters', 'coupon-x-discount-pop-up'),
                ];
            }//end if
        }
        echo json_encode($response);
        exit;

    }//end delete_widget()


    /**
     * Clear the page caches of popular cache plugins so the widget change shows up.
     */
    public function cx_clear_all_caches()
    {
        try {
            global $wp_fastest_cache, $file_prefix, $supercachedir;

            /* W3 Total Cache */
            if (function_exists('w3tc_flush_all')) {
                w3tc_flush_all();
            }

            /* WP Super Cache */
            if (function_exists('wp_cache_clean_cache')) {
                if (empty($supercachedir) && function_exists('get_supercache_dir')) {
                    $supercachedir = get_supercache_dir();
                }
                wp_cache_clean_cache($file_prefix, true);
            }

            /* WP Fastest Cache */
            if (!empty($wp_fastest_cache) && method_exists($wp_fastest_cache, 'deleteCache')) {
                $wp_fastest_cache->deleteCache();
            }

            /* WP Rocket */
            if (function_exists('rocket_clean_domain')) {
                rocket_clean_domain();
                if (function_exists('run_rocket_sitemap_preload')) {
                    run_rocket_sitemap_preload();
                }
            }

            /* Autoptimize */
            if (class_exists('\autoptimizeCache') && method_exists('\autoptimizeCache', 'clearall')) {
                \autoptimizeCache::clearall();
            }

            /* LiteSpeed Cache (current versions use the action, old versions the API class) */
            if (has_action('litespeed_purge_all')) {
                do_action('litespeed_purge_all');
            } elseif (class_exists('\LiteSpeed_Cache_API') && method_exists('\LiteSpeed_Cache_API', 'purge_all')) {
                \LiteSpeed_Cache_API::purge_all();
            }

            /* Breeze */
            if (class_exists('\Breeze_PurgeCache') && method_exists('\Breeze_PurgeCache', 'breeze_cache_flush')) {
                \Breeze_PurgeCache::breeze_cache_flush();
            }

            /* Hummingbird */
            if (class_exists('\Hummingbird\Core\Utils')) {
                $modules = \Hummingbird\Core\Utils::get_active_cache_modules();
                foreach ($modules as $module => $name) {
                    $mod = \Hummingbird\Core\Utils::get_module($module);
                    if ($mod && $mod->is_active()) {
                        if ('minify' === $module) {
                            $mod->clear_files();
                        } else {
                            $mod->clear_cache();
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // A cache plugin failing must never break saving the widget.
            return 1;
        }
    }

    /**
     * Create new widget
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function save_widget_data()
    {

        $response = [
            'status'    => 0,
            'response'  => 'Invalid request',
        ];

        if(!current_user_can('manage_options')) {
            echo json_encode($response);
            exit;
        }

        $fields = filter_input(INPUT_POST, "cx_settings", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $nonce = filter_input(INPUT_POST, 'cx_nonce');
        $redirect_on_dashboard = filter_input(INPUT_POST, 'redirect_on_dashboard');

        global $wpdb;


        if(isset($nonce) && !empty($nonce) && wp_verify_nonce($nonce, 'wp_rest') && is_array($fields)) {
            $postData = filter_input_array(INPUT_POST);
            $fields = map_deep($fields, 'sanitize_text_field');

            // Rich text fields keep their HTML (it is filtered with wp_kses() when displayed).
            $rich_fields = [
                'main'         => ['consent_text', 'headline', 'desc'],
                'coupon'       => ['headline', 'desc'],
                'announcement' => ['headline', 'desc'],
            ];
            foreach ($rich_fields as $section => $keys) {
                foreach ($keys as $key) {
                    if (isset($postData['cx_settings'][$section][$key]) && is_string($postData['cx_settings'][$section][$key])) {
                        $fields[$section][$key] = $postData['cx_settings'][$section][$key];
                    }
                }
            }

            $widget_id = 0;

            if (isset($fields['tab']['cx_widget_id']) && '' !== $fields['tab']['cx_widget_id']) {
                $widget_id = absint($fields['tab']['cx_widget_id']);
                // An existing ID must belong to a Coupon X widget (never overwrite other posts).
                if (!$this->is_cx_widget($widget_id)) {
                    $this->send_json([
                        'status'   => 0,
                        'response' => 'Invalid request',
                    ]);
                }
                $title = sanitize_text_field($fields['tab']['widget_title'] ?? '');
                $post = [
                    'ID' => $widget_id,
                    'post_title' => $title,
                    'post_content' => '',
                ];
                $res = wp_update_post($post);

                update_post_meta($widget_id, 'prm_cx_widget_data', $fields);

                $version = get_post_meta($widget_id, 'version', true);
                if ('' === $version) {
                    $version = 1;
                } else {
                    $version++;
                }

                update_post_meta($widget_id, 'version', $version);
            } else {
                // The free version allows one widget: stop here instead of creating a second one.
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                $count = (int) $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM {$wpdb->posts} WHERE post_type=%s AND post_status NOT IN ('trash', 'auto-draft')", 'cx_widget'));
                if ($count > 0) {
                    $this->send_json([
                        'status'   => 0,
                        'response' => 'error',
                    ]);
                }

                $title = sanitize_text_field($fields['tab']['widget_title'] ?? '');
                $post = [
                    'post_title' => $title,
                    'post_type' => 'cx_widget',
                    'post_status' => 'publish',
                    'post_content' => '',
                ];

                $widget_id = wp_insert_post($post);

                update_post_meta($widget_id, 'prm_cx_widget_data', $fields);

                update_post_meta($widget_id, 'status', 1);
                $total = get_option('cx_total_widget');
                if ('' === $total) {
                    $total = 2;
                } else {
                    $total++;
                }

                update_option('cx_total_widget', $total);
                update_post_meta($widget_id, 'version', 1);
            }//end if

            update_post_meta($widget_id, 'coupon_type', $fields['popup']['coupon_type'] ?? '');

            update_post_meta($widget_id, 'widget_type', $fields['popup']['style'] ?? '');

            if ('3' === ($fields['popup']['coupon_type'] ?? '') && class_exists('\\WC_Coupon')) {
                $this->generate_or_update_coupon($fields, $widget_id);
            }

            $this->cx_clear_all_caches();

            $response = [
                'status'    => 200,
                'response'  => 'success',
                'widget_id' => $widget_id,
                'dashboard_url' => $redirect_on_dashboard?admin_url('admin.php?page=couponx'):''
            ];
        }
        echo json_encode($response);
        exit;

    }//end save_widget_data()


    /**
     * Delete widget
     *
     * @param array $settings  widget settings.
     * @param int   $widget_id int widget id.
     */
    public function generate_or_update_coupon($settings, $widget_id)
    {
        $coupon_code = trim((string) ($settings['unique_coupon']['discount_code'] ?? ''));
        if ('' === $coupon_code) {
            return;
        }
        $coupon = new \WC_Coupon($coupon_code);

        $discount_type = $settings['unique_coupon']['discount_type'];
        if ('percent' === $discount_type) {
            $coupon->set_discount_type('percent');
        } else {
            $coupon->set_discount_type('fixed_cart');
        }

        $coupon->set_amount($settings['unique_coupon']['discount_value']);

        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['end_date']
        ) {
            $coupon->set_date_expires($settings['unique_coupon']['end_date']);
        } else {
            $coupon->set_date_expires(null);
        }

        $coupon->set_individual_use(true);

        if ('products' === $settings['unique_coupon']['applies_to']
            && isset($settings['unique_coupon']['products'])
            && count($settings['unique_coupon']['products']) > 0
        ) {
            $coupon->set_product_ids($settings['unique_coupon']['products']);
        } else {
            $coupon->set_product_ids(null);
        }

        if ('collections' === $settings['unique_coupon']['applies_to']
            && isset($settings['unique_coupon']['cats'])
            && count($settings['unique_coupon']['cats']) > 0
        ) {
            $coupon->set_product_categories($settings['unique_coupon']['cats']);
        } else {
            $coupon->set_product_categories(null);
        }

        if (isset($settings['unique_coupon']['enable_usage_limits'])
            && isset($settings['unique_coupon']['enable_no_item_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_no_item_limit']
        ) {
            $coupon->set_usage_limit($settings['unique_coupon']['no_item_limit']);
        } else {
            $coupon->set_usage_limit(null);
        }

        if (isset($settings['unique_coupon']['enable_usage_limits'])
            && isset($settings['unique_coupon']['enable_user_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_user_limit']
        ) {
            $coupon->set_usage_limit_per_user(1);
        } else {
            $coupon->set_usage_limit_per_user(null);
        }

        if ('subtotal' === ($settings['unique_coupon']['min_req'] ?? '')) {
            $coupon->set_minimum_amount($settings['unique_coupon']['min_val']);
        } else {
            $coupon->set_minimum_amount(null);
        }

        $coupon->set_free_shipping(!empty($settings['unique_coupon']['free_shipping']));

        $coupon->save();

        $coupon_id = $coupon->get_id();
        update_post_meta($coupon_id, 'status', 1);
        update_post_meta($coupon_id, 'cx_widget_id', $widget_id);
        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['start_date']
        ) {
            update_post_meta($coupon_id, 'start_date', $settings['unique_coupon']['start_date']);
            update_post_meta($coupon_id, 'end_date', $settings['unique_coupon']['end_date']);
        }

    }//end generate_or_update_coupon()


    /**
     * Track widget statistics (visitor / widget_open / coupon).
     */
    public function update_widget_stats()
    {
        $widget_id = absint(filter_input(INPUT_POST, 'id'));
        $meta_key  = sanitize_key((string) filter_input(INPUT_POST, 'key'));

        if (!$this->verify_widget_request($widget_id)) {
            $this->send_invalid_token();
        }

        // Only the widget's own statistic counters may be incremented.
        if (!$this->is_cx_widget($widget_id) || !in_array($meta_key, self::STATS_KEYS, true)) {
            $this->send_json([
                'status'   => 0,
                'response' => 'Invalid request',
            ]);
        }

        $meta_value = (int) get_post_meta($widget_id, $meta_key, true);
        update_post_meta($widget_id, $meta_key, $meta_value + 1);

        $this->send_json([
            'status'   => 200,
            'response' => 'success',
        ]);

    }//end update_widget_stats()


    public function clean_json_string($json_string) {
        $pos = strrpos($json_string, '}}</'); // Find the last occurrence of }}
        return ($pos !== false) ? substr($json_string, 0, $pos + 2) : $json_string;
    }


    /**
     * Get the coupon code for a widget, creating the WooCommerce coupon when needed.
     *
     * Coupon types: 1 = existing coupon, 2 = unique code per visitor,
     * 3 = one shared generated code, 4 = no coupon.
     *
     * @param boolean $plain true when called internally (capture_email); returns the code
     *                       array instead of sending JSON, or false when no coupon could be created.
     *
     * @return array|false|void
     */
    public function generate_coupon($plain = false)
    {
        $plain    = (true === $plain);
        $response = [
            'status'   => 401,
            'response' => 'Invalid request',
        ];

        $widget_id   = isset($_POST['id']) ? absint(wp_unslash($_POST['id'])) : 0;
        $client_code = isset($_POST['coupon_code']) ? sanitize_text_field(wp_unslash($_POST['coupon_code'])) : '';

        // capture_email() verifies the request before calling this method internally.
        if (!$plain && !$this->verify_widget_request($widget_id)) {
            $this->send_invalid_token();
        }

        $settings = $this->get_widget_settings($widget_id);
        if (empty($settings) || !function_exists('wc_get_coupon_id_by_code')) {
            if ($plain) {
                return false;
            }
            $this->send_json($response);
        }

        $widget_type = (int) ($settings['popup']['coupon_type'] ?? 0);
        $code        = [
            'code' => '',
            'id'   => 0,
        ];

        if (1 === $widget_type) {
            // Existing WooCommerce coupon selected in the widget settings.
            $coupon_id = (int) ($settings['ex_coupon']['coupon'] ?? 0);
            $code      = [
                'code' => get_the_title($coupon_id),
                'id'   => $coupon_id,
            ];
        } elseif (2 === $widget_type) {
            // Unique code per visitor. Reuse the visitor's code only when this widget created it;
            // a coupon is never created with a code chosen by the browser.
            $coupon_id = $this->get_widget_coupon_id($client_code, $widget_id);
            if ($coupon_id > 0) {
                $code = [
                    'code' => $client_code,
                    'id'   => $coupon_id,
                ];
            } else {
                if (!$this->can_create_coupon()) {
                    if ($plain) {
                        return false;
                    }
                    $this->send_json([
                        'status'   => 429,
                        'response' => 'Too many requests',
                    ]);
                }
                $coupon_code = $this->generate_unique_code();
                $coupon_id   = $this->create_coupon($settings, $coupon_code, $widget_id);
                // Marks per-visitor coupons so unused ones can be cleaned up later.
                update_post_meta($coupon_id, 'cx_unique_coupon', 1);
                $code = [
                    'code' => $coupon_code,
                    'id'   => $coupon_id,
                ];
            }
        } elseif (3 === $widget_type) {
            // One shared code configured in the widget; created on first use.
            $coupon_code = (string) ($settings['unique_coupon']['discount_code'] ?? '');
            $coupon_id   = ('' !== $coupon_code) ? (int) wc_get_coupon_id_by_code($coupon_code) : 0;
            if (0 === $coupon_id && '' !== $coupon_code) {
                $coupon_id = $this->create_coupon($settings, $coupon_code, $widget_id);
            }
            $code = [
                'code' => $coupon_code,
                'id'   => $coupon_id,
            ];
        }
        // Type 4 (no coupon): empty code, no WooCommerce coupon is created.

        if ($plain) {
            return $code;
        }

        $this->send_json([
            'status'   => 200,
            'response' => 'success',
            'code'     => $code,
            'type'     => $widget_type,
        ]);

    }//end generate_coupon()


    /**
     * Create new WooCommerce coupon.
     *
     * @param settings    $settings    Array of widget settings.
     * @param coupon_code $coupon_code string coupon code.
     * @param widget_id   $widget_id   int widget id.
     *
     * @return int coupond id
     */
    public function create_coupon($settings, $coupon_code, $widget_id)
    {
        $coupon = new \WC_Coupon();
        $coupon->set_code($coupon_code);
        $discount_type = $settings['unique_coupon']['discount_type'];
        if ('percent' === $discount_type) {
            $coupon->set_discount_type('percent');
        } else {
            $coupon->set_discount_type('fixed_cart');
        }

        $coupon->set_amount($settings['unique_coupon']['discount_value']);

        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['end_date']
        ) {
            $coupon->set_date_expires($settings['unique_coupon']['end_date']);
        }

        $coupon->set_individual_use(true);

        $applies_to = $settings['unique_coupon']['applies_to'] ?? 'order';

        // Restrict to products / categories only when "Applies to" says so.
        if ('products' === $applies_to
            && !empty($settings['unique_coupon']['products'])
            && is_array($settings['unique_coupon']['products'])
        ) {
            $coupon->set_product_ids($settings['unique_coupon']['products']);
        }

        if ('collections' === $applies_to
            && !empty($settings['unique_coupon']['cats'])
            && is_array($settings['unique_coupon']['cats'])
        ) {
            $coupon->set_product_categories($settings['unique_coupon']['cats']);
        }

        if (isset($settings['unique_coupon']['enable_no_item_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_no_item_limit']
        ) {
            $coupon->set_usage_limit($settings['unique_coupon']['no_item_limit']);
        }

        if (isset($settings['unique_coupon']['enable_user_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_user_limit']
        ) {
            $coupon->set_usage_limit_per_user(1);
        }

        // min_req is "none" or "subtotal"; any non-empty string used to count as true.
        if ('subtotal' === ($settings['unique_coupon']['min_req'] ?? '')) {
            $coupon->set_minimum_amount($settings['unique_coupon']['min_val']);
        }

        $coupon->set_free_shipping(!empty($settings['unique_coupon']['free_shipping']));

        $coupon->save();

        $coupon_id = $coupon->get_id();
        update_post_meta($coupon_id, 'status', 1);
        update_post_meta($coupon_id, 'cx_widget_id', $widget_id);
        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['start_date']
        ) {
            update_post_meta($coupon_id, 'start_date', $settings['unique_coupon']['start_date']);
            update_post_meta($coupon_id, 'end_date', $settings['unique_coupon']['end_date']);
        }

        return $coupon_id;

    }//end create_coupon()


    /**
     * Validate the email sent by the visitor, store it in the leads table and return the coupon.
     */
    public function capture_email()
    {
        global $wpdb;

        $lead_table    = $wpdb->prefix . 'cx_leads';
        $widget_id     = absint(filter_input(INPUT_POST, 'widget_id'));
        $email         = sanitize_email((string) filter_input(INPUT_POST, 'email'));
        $coupon_code   = sanitize_text_field((string) filter_input(INPUT_POST, 'coupon_code'));
        $is_consent    = 1 === (int) filter_input(INPUT_POST, 'is_consent');
        $customer_name = sanitize_text_field((string) filter_input(INPUT_POST, 'customer_name'));

        $error_response = function ($message) {
            $this->send_json([
                'status'      => 401,
                'response'    => 'error',
                'error'       => $message,
                'show_coupon' => false,
            ]);
        };

        if (!$this->verify_widget_request($widget_id)) {
            $this->send_invalid_token();
        }

        // Honeypot: the field is hidden from people, so only bots fill it in.
        if ('' !== trim((string) filter_input(INPUT_POST, 'cx_hp'))) {
            $error_response(\esc_html__('Something went wrong. Please contact site administrator', 'coupon-x-discount-pop-up'));
        }

        if (!$this->within_rate_limit('lead', self::LEAD_RATE_LIMIT)) {
            $error_response(\esc_html__('Too many attempts. Please try again later.', 'coupon-x-discount-pop-up'));
        }

        $settings = $this->get_widget_settings($widget_id);
        if (empty($settings) || '' === $email || !is_email($email)) {
            $error_response(\esc_html__('Something went wrong. Please contact site administrator', 'coupon-x-discount-pop-up'));
        }

        // Consent checkbox: enforced on the server, not only in the browser.
        $consent_enabled  = 1 === (int) ($settings['main']['consent'] ?? 0);
        $consent_required = 1 === (int) ($settings['main']['consent_required'] ?? 0);
        if ($consent_enabled && $consent_required && !$is_consent) {
            $error_response(\esc_html__('Please accept the consent checkbox to continue.', 'coupon-x-discount-pop-up'));
        }

        // One lead per email address per widget. A repeat email gets the "already used" error
        // message configured in the widget instead of another coupon.
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter
        $existing_lead = $wpdb->get_var(
            $wpdb->prepare("SELECT id FROM `{$lead_table}` WHERE email = %s AND widget_id = %d LIMIT 1", $email, $widget_id)
        );
        if (null !== $existing_lead) {
            $duplicate_message = trim((string) ($settings['main']['error'] ?? ''));
            if ('' === $duplicate_message) {
                $duplicate_message = \esc_html__("You've already used this email address, please try another email address", 'coupon-x-discount-pop-up');
            }
            $error_response(\esc_html($duplicate_message));
        }

        $discount_code = '';
        if ('style-5' !== ($settings['popup']['style'] ?? '')) {
            // generate_coupon() reads these values.
            $_POST['id']          = $widget_id;
            $_POST['coupon_code'] = $coupon_code;

            $code = $this->generate_coupon(true);
            if (false === $code) {
                $error_response(\esc_html__('Something went wrong. Please contact site administrator', 'coupon-x-discount-pop-up'));
            }
            $discount_code = isset($code['code']) ? (string) $code['code'] : '';
        }

        // Stop when the coupon has no uses left (the error used to be overwritten by "success").
        if ('' !== $discount_code) {
            $coupon      = new \WC_Coupon($discount_code);
            $usage_limit = (int) $coupon->get_usage_limit('edit');
            if ($usage_limit > 0 && ($usage_limit - (int) $coupon->get_usage_count('edit')) < 1) {
                $error_response(\esc_html__('The coupon has reached its maximum number of usage.', 'coupon-x-discount-pop-up'));
            }
        }

        // Save the lead (duplicates for this widget were rejected above).
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $wpdb->insert(
            $lead_table,
            [
                'email'       => $email,
                'name'        => $customer_name,
                'widget_id'   => $widget_id,
                'widget_name' => get_the_title($widget_id),
                'coupon_code' => $discount_code,
                'date'        => gmdate('Y-m-d'),
                'ip_address'  => $this->get_the_user_ip(),
            ],
            ['%s', '%s', '%d', '%s', '%s', '%s', '%s']
        );

        $lead_args = [
            'email'       => $email,
            'name'        => $customer_name,
            'widget_id'   => $widget_id,
            'coupon_code' => $discount_code,
        ];
        do_action('couponX_lead_created', $lead_args);

        $meta_value = (int) get_post_meta($widget_id, 'coupon', true);
        update_post_meta($widget_id, 'coupon', $meta_value + 1);

        $this->send_json([
            'status'        => 200,
            'response'      => 'success',
            'discount_code' => $discount_code,
            'show_coupon'   => true,
        ]);

    }//end capture_email()


    /**
     * Get Ip address of user.
     */
    public function get_the_user_ip()
    {
        // Client-IP / X-Forwarded-For headers can be set by anyone, so only REMOTE_ADDR is used.
        // Sites behind a trusted proxy or CDN can return the real client IP from this filter.
        $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        $ip = (string) apply_filters('couponx_visitor_ip', $ip);

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '';

    }//end get_the_user_ip()


    /**
     * Deleate lead(s)
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response obeject
     */
    public function delete_leads()
    {
        $response = [
            'status'   => 0,
            'response' => 'Invalid request',
        ];

        if(!current_user_can('manage_options')) {
            echo json_encode($response);
            exit;
        }

        $leadIds = filter_input(INPUT_POST, 'id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $leadIds = isset($leadIds) ? array_filter(array_map('absint', (array) $leadIds)) : [];

        $nonce = filter_input(INPUT_POST, 'nonce');

        if(isset($nonce) && !empty($nonce) && wp_verify_nonce($nonce, 'wp_rest')) {
            if (!empty($leadIds)) {
                global $wpdb;
                $leads_tbl = $wpdb->prefix . 'cx_leads';
                foreach ($leadIds as $id) {
                    $query = $wpdb->prepare("DELETE FROM `{$leads_tbl}` WHERE id = %d", $id);
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter
                    $wpdb->query($query);
                }

                $response = [
                    'status' => 200,
                    'response' => 'success',
                ];
            } else {
                $response = [
                    'status' => 201,
                    'response' => 'error',
                    'error' => esc_html__('Request could not be completed due to missing parameters', 'coupon-x-discount-pop-up'),
                ];
            }//end if
        }
        echo json_encode($response);
        exit;

    }//end delete_leads()


    /**
     * Schedule the daily cleanup of unused per-visitor coupons.
     */
    public function schedule_cleanup()
    {
        if (!wp_next_scheduled(self::CLEANUP_HOOK)) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', self::CLEANUP_HOOK);
        }

    }//end schedule_cleanup()


    /**
     * Move unused per-visitor coupons to the trash.
     *
     * "Unique code" widgets create one WooCommerce coupon per visitor, and most are never used.
     * A coupon is trashed when it was never used and has expired, or is older than a year
     * (the frontend keeps a code for at most 365 days). Trashed coupons can still be restored
     * from WooCommerce > Coupons > Trash until WordPress empties the trash.
     */
    public function cleanup_unused_coupons()
    {
        global $wpdb;

        $cutoff = gmdate('Y-m-d H:i:s', time() - YEAR_IN_SECONDS);

        // Per-visitor coupons: marked by cx_unique_coupon, or the old COUPONX + digits format.
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT p.ID, p.post_title, w.meta_value AS widget_id
                FROM {$wpdb->posts} p
                INNER JOIN {$wpdb->postmeta} w ON w.post_id = p.ID AND w.meta_key = 'cx_widget_id'
                LEFT JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = 'cx_unique_coupon'
                LEFT JOIN {$wpdb->postmeta} u ON u.post_id = p.ID AND u.meta_key = 'usage_count'
                LEFT JOIN {$wpdb->postmeta} e ON e.post_id = p.ID AND e.meta_key = 'date_expires'
                WHERE p.post_type = 'shop_coupon'
                    AND p.post_status = 'publish'
                    AND (m.meta_value = '1' OR p.post_title REGEXP '^COUPONX[0-9]+$')
                    AND (u.meta_value IS NULL OR u.meta_value = '' OR u.meta_value = '0')
                    AND (p.post_date_gmt < %s OR (e.meta_value REGEXP '^[0-9]+$' AND CAST(e.meta_value AS UNSIGNED) < %d))
                LIMIT 200",
                $cutoff,
                time()
            )
        );

        foreach ((array) $rows as $row) {
            // Never touch the shared code a "generated code" widget is configured with.
            $settings    = $this->get_widget_settings((int) $row->widget_id);
            $shared_code = (string) ($settings['unique_coupon']['discount_code'] ?? '');
            if ('' !== $shared_code && 0 === strcasecmp($shared_code, $row->post_title)) {
                continue;
            }
            wp_trash_post((int) $row->ID);
        }

    }//end cleanup_unused_coupons()


}//end class


new Cx_Rest();
