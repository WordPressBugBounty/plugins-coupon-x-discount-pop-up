<?php
/**
 * Coupon X settings
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
 * Coupon X dashboard functions.
 */
class Dashboard
{


    /**
     * Constructor.
     *
     * Define functions
     */
    public function __construct()
    {
        add_action('init', [ $this, 'register_cx_post_type' ]);
        add_action('admin_menu', [ $this, 'register_cx_settings_menu' ]);
        add_action('admin_enqueue_scripts', [ $this, 'include_admin_scripts' ]);
        add_action('admin_footer', [ $this, 'coupon_x_deactivate_modal' ]);
        add_action('wp_ajax_coupon_x_plugin_deactivate', [ $this, 'coupon_x_plugin_deactivate' ]);
        add_action('wp_ajax_cx_admin_send_message_to_owner', [ $this, 'cx_admin_send_message_to_owner' ]);
        add_action('wp_ajax_coupon_x_update_signup_status', [ $this, 'coupon_x_update_signup_status' ]);
        add_filter('plugin_action_links_'.COUPON_X_PLUGIN_BASE, [ $this, 'upgrade_action_links' ]);
        add_action('admin_head', [$this, 'admin_head']);
        add_action('wp_ajax_search_woo_product', [$this, 'search_woo_product']);

    }//end __construct()


    /**
     * SVG icon for Coupon X menu.
     *
     * @return svg html;
     */
    public function get_icon()
    {
        $svg = '<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M29.1767 16.9706V31.5H6.82373V16.9706" stroke="#374151" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M31.9705 9.98535H4.0293V16.9706H31.9705V9.98535Z" stroke="#374151" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M18.0001 9.98529H11.7133C10.787 9.98529 9.89867 9.61732 9.24368 8.96232C8.58868 8.30732 8.2207 7.41895 8.2207 6.49265C8.2207 5.56634 8.58868 4.67797 9.24368 4.02297C9.89867 3.36797 10.787 3 11.7133 3C16.6031 3 18.0001 9.98529 18.0001 9.98529Z" stroke="#374151" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M18 9.98529H24.2868C25.2131 9.98529 26.1014 9.61732 26.7564 8.96232C27.4114 8.30732 27.7794 7.41895 27.7794 6.49265C27.7794 5.56634 27.4114 4.67797 26.7564 4.02297C26.1014 3.36797 25.2131 3 24.2868 3C19.3971 3 18 9.98529 18 9.98529Z" stroke="#374151" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M19.1176 9.98532C19.1176 9.36806 18.6172 8.86768 18 8.86768C17.3827 8.86768 16.8823 9.36806 16.8823 9.98532V18.0883H19.1176V9.98532ZM19.1176 30.3824H16.8823V30.9412C16.8823 31.5585 17.3827 32.0589 18 32.0589C18.6172 32.0589 19.1176 31.5585 19.1176 30.9412V30.3824Z" fill="#374151"/>
				<path d="M14.4015 28.4382C14.2048 28.4382 14.1065 28.3563 14.1065 28.1924C14.1065 28.1432 14.1229 28.0981 14.1556 28.0571L20.2289 20.0659C20.2863 19.9922 20.3437 19.9348 20.4011 19.8938C20.4666 19.8528 20.5568 19.8323 20.6715 19.8323H21.9501C22.1468 19.8323 22.2452 19.9143 22.2452 20.0782C22.2452 20.1274 22.2288 20.1725 22.196 20.2135L16.1227 28.2046C16.0653 28.2784 16.0039 28.3358 15.9383 28.3768C15.8809 28.4177 15.7949 28.4382 15.6801 28.4382H14.4015ZM21.0649 28.4997C20.4912 28.4997 20.024 28.3563 19.6634 28.0694C19.311 27.7744 19.1143 27.3809 19.0733 26.8892C19.0569 26.6761 19.0487 26.4835 19.0487 26.3113C19.0569 26.131 19.0651 25.9261 19.0733 25.6966C19.1061 25.1967 19.2946 24.8033 19.6388 24.5164C19.9913 24.2213 20.4666 24.0738 21.0649 24.0738C21.6715 24.0738 22.1468 24.2213 22.4911 24.5164C22.8353 24.8033 23.0238 25.1967 23.0566 25.6966C23.073 25.9261 23.0812 26.131 23.0812 26.3113C23.0812 26.4835 23.073 26.6761 23.0566 26.8892C23.0238 27.3809 22.8271 27.7744 22.4665 28.0694C22.1058 28.3563 21.6387 28.4997 21.0649 28.4997ZM21.0649 27.1719C21.1387 27.1719 21.1961 27.1555 21.2371 27.1228C21.278 27.09 21.3108 27.0449 21.3354 26.9875C21.36 26.9302 21.3723 26.8687 21.3723 26.8031C21.3887 26.6392 21.3969 26.4671 21.3969 26.2868C21.3969 26.1064 21.3887 25.9384 21.3723 25.7827C21.3641 25.6762 21.3354 25.5901 21.2862 25.5245C21.2453 25.4508 21.1715 25.4139 21.0649 25.4139C20.9584 25.4139 20.8805 25.4508 20.8314 25.5245C20.7904 25.5901 20.7658 25.6762 20.7576 25.7827C20.7494 25.9384 20.7453 26.1064 20.7453 26.2868C20.7453 26.4671 20.7494 26.6392 20.7576 26.8031C20.7658 26.8687 20.7781 26.9302 20.7945 26.9875C20.8191 27.0449 20.8518 27.09 20.8928 27.1228C20.942 27.1555 20.9994 27.1719 21.0649 27.1719ZM15.3359 24.1968C14.7622 24.1968 14.295 24.0533 13.9344 23.7665C13.5819 23.4714 13.3852 23.078 13.3442 22.5862C13.3278 22.3731 13.3196 22.1805 13.3196 22.0084C13.3278 21.8281 13.336 21.6232 13.3442 21.3937C13.377 20.8937 13.5655 20.5003 13.9098 20.2135C14.2622 19.9184 14.7376 19.7709 15.3359 19.7709C15.9424 19.7709 16.4178 19.9184 16.762 20.2135C17.1062 20.5003 17.2947 20.8937 17.3275 21.3937C17.3439 21.6232 17.3521 21.8281 17.3521 22.0084C17.3521 22.1805 17.3439 22.3731 17.3275 22.5862C17.2947 23.078 17.098 23.4714 16.7374 23.7665C16.3768 24.0533 15.9096 24.1968 15.3359 24.1968ZM15.3359 22.869C15.4096 22.869 15.467 22.8526 15.508 22.8198C15.549 22.787 15.5818 22.742 15.6064 22.6846C15.6309 22.6272 15.6432 22.5657 15.6432 22.5002C15.6596 22.3363 15.6678 22.1641 15.6678 21.9838C15.6678 21.8035 15.6596 21.6355 15.6432 21.4798C15.635 21.3732 15.6064 21.2872 15.5572 21.2216C15.5162 21.1478 15.4424 21.1109 15.3359 21.1109C15.2293 21.1109 15.1515 21.1478 15.1023 21.2216C15.0613 21.2872 15.0367 21.3732 15.0285 21.4798C15.0203 21.6355 15.0162 21.8035 15.0162 21.9838C15.0162 22.1641 15.0203 22.3363 15.0285 22.5002C15.0367 22.5657 15.049 22.6272 15.0654 22.6846C15.09 22.742 15.1228 22.787 15.1638 22.8198C15.2129 22.8526 15.2703 22.869 15.3359 22.869Z" fill="#374151"/>
				</svg>';
        return 'data:image/svg+xml;base64,'.base64_encode($svg);

    }//end get_icon()


    /**
     * Register Coupon X related menues
     */
    public function register_cx_settings_menu()
    {
        global $wpdb;
        $count = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
        // Widget listing menu.
        add_menu_page(
            __('Coupon X', 'coupon-x'),
            __('Coupon X', 'coupon-x'),
            'manage_options',
            'couponx',
            '',
            $this->get_icon()
        );

        add_submenu_page(
            'couponx',
            __('Dashboard', 'coupon-x'),
            __('Dashboard', 'coupon-x'),
            'manage_options',
            'couponx',
            [
                $this,
                'display_couponx_settings_widget',
            ]
        );

        if ('0' === $count) {
            // Create new widget menu.
            add_submenu_page(
                'couponx',
                __('Create New Widget', 'coupon-x'),
                __('Create New Widget', 'coupon-x'),
                'manage_options',
                'add_couponx',
                [
                    $this,
                    'add_coupon_settings',
                ]
            );
        } else {
            add_submenu_page(
                '',
                __('Create New Widget', 'coupon-x'),
                __('Create New Widget', 'coupon-x'),
                'manage_options',
                'add_couponx',
                [
                    $this,
                    'add_coupon_settings',
                ]
            );
            add_submenu_page(
                'couponx',
                __('Create New Widget', 'coupon-x'),
                __('Create New Widget', 'coupon-x'),
                'manage_options',
                admin_url('admin.php?page=couponx_pro_features')
            );
        }//end if

        // Create new leads menu.
        add_submenu_page(
            'couponx',
            __('Leads', 'coupon-x'),
            __('Leads', 'coupon-x'),
            'manage_options',
            'leads_list',
            [
                $this,
                'display_coupon_leads',
            ]
        );
        add_submenu_page(
            'couponx',
            __('Integrations', 'coupon-x'),
            __('Integrations', 'coupon-x'),
            'manage_options',
            'cx_integrations',
            [
                $this,
                'email_client_integration',
            ]
        );

        if(get_option('hide_couponx_plugins') != 1) {
            add_submenu_page(
                'couponx',
                __('Recommended Plugins', 'coupon-x'),
                __('Recommended Plugins', 'coupon-x'),
                'manage_options',
                'cx-recommended-plugins',
                [
                    $this,
                    'recommended_plugins',
                ]
            );
        }

        add_submenu_page(
            'couponx',
            __('Upgrade to Pro ⭐️', 'coupon-x'),
            __('Upgrade to Pro ⭐️', 'coupon-x'),
            'manage_options',
            'couponx_pricing_tbl',
            [
                $this,
                'add_couponx_pricing_tbl',
            ]
        );

        add_submenu_page(
            '',
            __('Coupon X Pro Features', 'coupon-x'),
            __('Coupon X Pro Features', 'coupon-x'),
            'manage_options',
            'couponx_pro_features',
            [
                $this,
                'display_couponx_pro_features',
            ]
        );

    }//end register_cx_settings_menu()


    /**
     * Load recommended plugins page.
     *
     * @return void
     */
    public function recommended_plugins()
    {
        include_once plugin_dir_path( __FILE__ ) . 'pages/recommended-plugins.php';
    }


    /**
     * Register custom post type cx_widget for Widget.
     */
    public function register_cx_post_type()
    {

        $labels = [
            'name'               => _x('CX Widget', 'Post type general name', 'coupon-x'),
            'singular_name'      => _x('CX Widget', 'Post type singular name', 'coupon-x'),
            'menu_name'          => _x('CX Widgets', 'Admin Menu text', 'coupon-x'),
            'name_admin_bar'     => _x('CX Widgets', 'Add New on Toolbar', 'coupon-x'),
            'add_new'            => __('Add New', 'coupon-x'),
            'add_new_item'       => __('Add New CX Widget', 'coupon-x'),
            'new_item'           => __('New CX Widget', 'coupon-x'),
            'edit_item'          => __('Edit CX Widget', 'coupon-x'),
            'view_item'          => __('View CX Widget', 'coupon-x'),
            'all_items'          => __('All CX Widgets', 'coupon-x'),
            'search_items'       => __('Search CX Widgets', 'coupon-x'),
            'not_found'          => __('No coupon found.', 'coupon-x'),
            'not_found_in_trash' => __('No coupon found in Trash.', 'coupon-x'),
        ];
        $args   = [
            'labels'             => $labels,
            'description'        => _x('CX Widget', 'coupon-x'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'cx_widget' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => [ 'title' ],
            'show_in_rest'       => false,
        ];

        register_post_type('cx_widget', $args);

    }//end register_cx_post_type()


    /**
     * Display pop up if WooCommerce is not active.
     * Otherwise display Widget List.
     */
    public function display_couponx_settings_widget()
    {
        if (get_option('cx_signup_popup') === false) {
            include_once 'class-cx-signup.php';
            new Cx_SignUp();
        } else {
            include_once 'class-cx-widget-list.php';
            new Cx_Widget_List();
        }

    }//end display_couponx_settings_widget()


    /**
     * Include required files.
     */
    public function add_coupon_settings()
    {
        if (get_option('cx_signup_popup') === false) {
            include_once 'class-cx-signup.php';
            new Cx_SignUp();
        } else {
            include_once 'class-cx-helper.php';
            include_once 'class-create-widget.php';
        }

    }//end add_coupon_settings()


    /**
     * Include appropriate scripts and styles on CX settings pages.
     *
     * @param : $hook menu slug.
     */
    public function include_admin_scripts($hook)
    {

        if ('admin_page_add_couponx' === $hook
            || 'toplevel_page_couponx' === $hook
            || 'coupon-x_page_add_couponx' === $hook
        ) {
            wp_enqueue_media();
            wp_enqueue_style('popin-font', 'https://fonts.googleapis.com/css?family=Poppins%3A100%2C200%2C300%2C400%2C500%2C600%2C700&#038;ver=5.2.4');

            wp_enqueue_style('ui-css', COUPON_X_URL.'assets/css/jquery-ui.css', '', COUPON_X_VERSION);
            wp_enqueue_style('spectrum-css', COUPON_X_URL.'assets/css/spectrum.min.css', '', COUPON_X_VERSION);
            wp_enqueue_style('select2-css', COUPON_X_URL.'assets/css/select2.min.css', '', COUPON_X_VERSION);

            wp_enqueue_style('cx-settings-style', COUPON_X_URL.'assets/css/settings.min.css', '', COUPON_X_VERSION);
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_script('js-timpepicker', COUPON_X_URL.'assets/js/timepicker.min.js', '', COUPON_X_VERSION);
            wp_enqueue_script('jscolorpicker', COUPON_X_URL.'assets/js/spectrum.js', '', COUPON_X_VERSION);
            wp_enqueue_script('select2-js', COUPON_X_URL.'assets/js/select2.min.js', '', COUPON_X_VERSION);

            wp_enqueue_script('cx-settings-script', COUPON_X_URL.'assets/js/settings.min.js', [ 'jquery', 'jquery-ui-tabs', 'jquery-ui-dialog', 'jscolorpicker', 'wp-i18n', 'js-timpepicker', 'jquery-ui-tooltip', 'jquery-ui-slider' ], COUPON_X_VERSION);
            wp_enqueue_script('cx-mailcheck-script', COUPON_X_URL.'assets/js/mailcheck.js', [ 'jquery' ], time());

            wp_localize_script(
                'cx-settings-script',
                'cx_data',
                [
                    'url'      => admin_url('admin-ajax.php'),
                    'site_url' => site_url(),
                    'cx_nonce' => wp_create_nonce('wp_rest')
                ]
            );
            wp_set_script_translations('cx-settings-script', 'coupon-x');
        } else if ('coupon-x_page_leads_list' === $hook) {
            wp_enqueue_style('popin-font', 'https://fonts.googleapis.com/css?family=Poppins%3A100%2C200%2C300%2C400%2C500%2C600%2C700&#038;ver=5.2.4');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_style('ui-css', COUPON_X_URL.'assets/css/jquery-ui.css', '', COUPON_X_VERSION);
            wp_enqueue_style('cx-datatable-css', COUPON_X_URL.'assets/css/datatable.min.css', '', COUPON_X_VERSION);
            wp_enqueue_script('cx-datatable-js', COUPON_X_URL.'assets/js/datatable.min.js', '', COUPON_X_VERSION);
            wp_enqueue_script('cx-datatable-btn', COUPON_X_URL.'assets/js/dataTables.buttons.min.js', '', COUPON_X_VERSION);

            wp_enqueue_script('cx-listing-js', COUPON_X_URL.'assets/js/listing.min.js', [ 'jquery', 'cx-datatable-js', 'wp-i18n' ], COUPON_X_VERSION);
            wp_enqueue_style('cx-listing-css', COUPON_X_URL.'assets/css/settings.min.css', '', COUPON_X_VERSION);
            wp_localize_script(
                'cx-listing-js',
                'cx_data',
                [
                    'url'      => admin_url('admin-ajax.php'),
                    'site_url' => site_url(),
                ]
            );

            wp_set_script_translations('cx-listing-js', 'coupon-x');
        } else if ('plugins.php' === $hook) {
            wp_enqueue_style('deactivation-css', COUPON_X_URL.'assets/css/deactivation-popup.min.css', '', COUPON_X_VERSION);
            wp_enqueue_script('deactivation-js', COUPON_X_URL.'assets/js/deactivation-popup.min.js', [ 'jquery', 'wp-i18n' ], COUPON_X_VERSION);

            wp_localize_script(
                'deactivation-js',
                'cx_data',
                [
                    'url'   => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('cx_deactivate_nonce'),
                ]
            );
            wp_set_script_translations('cx-listing-js', 'coupon-x');
        } else if ('coupon-x_page_couponx_pricing_tbl' === $hook) {
//            wp_enqueue_style('select2-css', COUPON_X_URL.'assets/css/select2.min.css', '', COUPON_X_VERSION);
            wp_enqueue_style('pricing-css', COUPON_X_URL.'assets/css/pricing-tbl.css', '', COUPON_X_VERSION);
//            wp_enqueue_script('select2-js', COUPON_X_URL.'assets/js/select2.min.js', '', COUPON_X_VERSION);
//            wp_enqueue_script('pricing-js', COUPON_X_URL.'assets/js/pricing.js', [ 'jquery' ], COUPON_X_VERSION);
            wp_enqueue_script('slick-js', COUPON_X_URL.'assets/js/slick.min.js', [ 'jquery' ], COUPON_X_VERSION);
            $queryArgs = [
                'family' => 'Poppins:wght@400;500;600;700&display=swap',
                'subset' => 'latin,latin-ext',
            ];
            wp_enqueue_style('google-poppins-fonts', add_query_arg($queryArgs, "//fonts.googleapis.com/css2"), [], null);
        } else if ('admin_page_couponx_pro_features' === $hook) {
            wp_enqueue_style('popin-font', 'https://fonts.googleapis.com/css?family=Poppins%3A100%2C200%2C300%2C400%2C500%2C600%2C700&#038;ver=5.2.4');
            wp_enqueue_style('pro-css', COUPON_X_URL.'assets/css/features.css', '', COUPON_X_VERSION);
        } else if ('coupon-x_page_cx_integrations' === $hook) {
            wp_enqueue_style('popin-font', 'https://fonts.googleapis.com/css?family=Poppins%3A100%2C200%2C300%2C400%2C500%2C600%2C700&#038;ver=5.2.4');
            wp_enqueue_style('integration-css', COUPON_X_URL.'assets/css/integration.css', '', COUPON_X_VERSION);
        }//end if

    }//end include_admin_scripts()

    function admin_head() {
        ?>
        <style>
            #adminmenu .toplevel_page_couponx > ul > li:last-child {
                padding: 5px 10px;
            }
            #adminmenu .toplevel_page_couponx > ul > li:last-child a {
                display: flex;
                background-color: #B78DEB;
                border-radius: 6px;
                font-size: 12px;
                gap: 4px;
                padding: 4px 8px;
                color: #ffffff;
                align-items: center;
                transition: all 0.2s linear;
                font-weight: normal;
                box-shadow: 0px 6px 8px 0px #B78DEB3D;
                justify-content: center;
            }
            #adminmenu .toplevel_page_couponx > ul > li:last-child a:hover, #adminmenu .toplevel_page_couponx > ul > li:last-child a.current {
                box-shadow: 0px 6px 8px 0px #B78DEB3D;
                color: #ffffff;
                background-color: #9565d0;
                font-weight: normal;
            }
            #adminmenu .toplevel_page_couponx > ul > li:last-child a span {
                flex: 0 0 16px;
                height: 16px;
                background-color: #c5a4ef;
                border-radius: 4px;
                padding: 2px;
                display: inline-flex;
                transition: all 0.2s linear;
            }
            #adminmenu .toplevel_page_couponx > ul > li:last-child a:hover span {
                background-color: #B78DEB;
            }
            #adminmenu .toplevel_page_couponx > ul > li:last-child a span svg {
                width: 100%;
                height: 100%;
            }
        </style>
        <?php
    }


    /**
     * Display list of captured emails.
     */
    public function display_coupon_leads()
    {
        global $wpdb;
        $leads_tbl = $wpdb->prefix.'cx_leads';
     //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $leads = $wpdb->get_results("SELECT * FROM $leads_tbl ORDER BY id DESC");
        ?>

        <div class='listing'>
            <input type='hidden' name='cx_nonce' value = '<?php echo wp_create_nonce('wp_rest'); ?>' />
            <table class='leads-listing display nowrap'>
                <thead>
                    <th> <input type='checkbox' class='select-all' /> </th>
                    <th class="text-left"><?php esc_html_e('Name', 'coupon-x'); ?></th>
                    <th class="text-left"><?php esc_html_e('Email', 'coupon-x'); ?></th>
                    <th><?php esc_html_e('Widget Name', 'coupon-x'); ?></th>
                    <th><?php esc_html_e('Date', 'coupon-x'); ?></th>
                    <th><?php esc_html_e('Ip Address', 'coupon-x'); ?></th>
                    <th></th>
                </thead>
                <tbody>
        <?php
        if (is_array($leads) && count($leads)) {
            foreach ($leads as $lead) {
                ?>
                            <tr>
                                <td> <input type='checkbox' class='chk_lead' value='<?php echo esc_attr($lead->id); ?>' /> </td>
                                <td class="text-left"> <?php echo esc_attr($lead->name); ?> </td>
                                <td class="text-left"> <?php echo esc_attr($lead->email); ?> </td>
                                <td> <?php echo esc_attr($lead->widget_name); ?> </td>
                                <td> 
                                    <?php
                                    $dt = $lead->date;
                                    echo esc_attr(gmdate('F j, Y', strtotime($dt)));
                                    ?>
                                </td>
                                <td> <?php echo esc_attr($lead->ip_address); ?> </td>
                                <td> 
                                    <a href='#' class='delete-lead' lead-id = '<?php echo esc_attr($lead->id); ?>' title='Delete'>
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
        <div id="lead-delete-confirm" class="couponapp-widget-dialog" title="<?php esc_attr_e('Delete Lead?', 'coupon-x'); ?>" style='display: none;'>
            <p class='desc'>
            </p>
            <input type="hidden" id="dashboard_lead_id" value="" />
        </div>
        <div id="loader" class="center">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="width:150px;height:150px;"><path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"><animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform></path></svg>
        </div>
        <div id="wp_flash_message" class="hide">
        <?php echo __('Record(s) deleted successfully', 'coupon-x'); ?>
            <span>
                <a href="#" class="close_flash_popup">&#x2715;</a>
            </span>
        </div>
        <?php

    }//end display_coupon_leads()


    /**
     * Display confirmation pop up on plugin deactivation
     */
    public function coupon_x_deactivate_modal()
    {

        if (current_user_can('manage_options')) {
            global $pagenow;

            if ('plugins.php' !== $pagenow) {
                return;
            }

            include_once 'class-cx-deactivation-form.php';
            new Cx_Deactivation_Form();
        }

    }//end coupon_x_deactivate_modal()


    /**
     * Coupon X plugin deactivation message
     */
    public function coupon_x_plugin_deactivate()
    {
        $error_counter       = 0;
        $response            = [];
        $response['status']  = 0;
        $response['message'] = '';
        $response['valid']   = 1;

        $reason = filter_input(INPUT_POST, 'reason');
        $nonce  = filter_input(INPUT_POST, 'nonce');
        if (empty($reason)) {
            $error_counter++;
            $response['message'] = 'Please provide reason';
        } else if (empty($nonce)) {
            $response['message'] = esc_html__('Your request is not valid', 'coupon-x');
            $error_counter++;
            $response['valid'] = 0;
        } else if (! current_user_can('manage_options')) {
            $response['message'] = esc_html__('Your request is not valid', 'coupon-x');
            $error_counter++;
            $response['valid'] = 0;
        } else {
            if (! wp_verify_nonce($nonce, 'cx_deactivate_nonce')) {
                $response['message'] = esc_html__('Your request is not valid', 'coupon-x');
                $error_counter++;
                $response['valid'] = 0;
            }
        }

        if (0 === $error_counter) {
            $current_user = wp_get_current_user();
            $email        = 'none@none.none';

            $email_id = filter_input(INPUT_POST, 'email_id');
            if (isset($email_id) && ! empty($email_id) && filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
                $email = $email_id;
            }

            filter_input(INPUT_POST, 'email_id');

            $domain    = site_url();
            $user_name = $current_user->first_name.' '.$current_user->last_name;

            $response['status'] = 1;

            // sending message to Crisp.
            $post_message = [];

            $message_data          = [];
            $message_data['key']   = 'Plugin';
            $message_data['value'] = 'Coupon X WooCommerce';
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Plugin Version';
            $message_data['value'] = COUPON_X_VERSION;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Domain';
            $message_data['value'] = $domain;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Email';
            $message_data['value'] = $email;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'WordPress Version';
            $message_data['value'] = esc_attr(get_bloginfo('version'));
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'PHP Version';
            $message_data['value'] = PHP_VERSION;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Message';
            $message_data['value'] = $reason;
            $post_message[]        = $message_data;

            $api_params = [
                'domain'  => $domain,
                'email'   => $email,
                'url'     => site_url(),
                'name'    => $user_name,
                'message' => $post_message,
                'plugin'  => 'Coupon X WooCommerce',
                'type'    => 'Uninstall',
            ];

            $api_url = 'https://premioapps.com/premio/send-message-api.php';

            // Sending message to Crisp API.
            $api_response = wp_safe_remote_post(
                $api_url,
                [
                    'body'      => $api_params,
                    'timeout'   => 15,
                    'sslverify' => true,
                ]
            );

            if (is_wp_error($api_response)) {
                wp_safe_remote_post(
                    $api_url,
                    [
                        'body'      => $api_params,
                        'timeout'   => 15,
                        'sslverify' => false,
                    ]
                );
            }
        }//end if

        echo json_encode($response);
        wp_die();

    }//end coupon_x_plugin_deactivate()


    /**
     * Coupon X send support email
     */
    public function cx_admin_send_message_to_owner()
    {
        $response            = [];
        $response['status']  = 0;
        $response['error']   = 0;
        $response['errors']  = [];
        $response['message'] = '';
        $error_array         = [];
        $error_message       = esc_attr__('%s is required', 'coupon-x');

        $textarea_text = filter_input(INPUT_POST, 'textarea_text');
        $user_email    = filter_input(INPUT_POST, 'user_email');
        $nonce         = filter_input(INPUT_POST, 'nonce');

        if (empty($textarea_text)) {
            $error         = [
                'key'     => 'textarea_text',
                'message' => esc_attr__('Please enter your message', 'coupon-x'),
            ];
            $error_array[] = $error;
        }

        if (empty($user_email)) {
            $error         = [
                'key'     => 'user_email',
                'message' => sprintf($error_message, esc_attr__('Email', 'coupon-x')),
            ];
            $error_array[] = $error;
        } else if (! filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error         = [
                'key'     => 'user_email',
                'message' => 'Email is not valid',
            ];
            $error_array[] = $error;
        }

        if (empty($error_array)) {
            if (empty($nonce)) {
                $error         = [
                    'key'     => 'nonce',
                    'message' => 'Your request is not valid',
                ];
                $error_array[] = $error;
            } else if (! wp_verify_nonce($nonce, 'cx_send_message_to_owner')) {
                $error         = [
                    'key'     => 'nonce',
                    'message' => 'Your request is not valid',
                ];
                $error_array[] = $error;
            }
        }

        if (empty($error_array)) {
            $current_user = wp_get_current_user();
            $text_message = sanitize_textarea_field($textarea_text);
            $email        = sanitize_email($user_email);
            $domain       = site_url();
            $user_name    = $current_user->first_name.' '.$current_user->last_name;

            // sending message to Crisp.
            $post_message = [];

            $message_data          = [];
            $message_data['key']   = 'Plugin';
            $message_data['value'] = 'Coupon X WooCommerce';
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Domain';
            $message_data['value'] = $domain;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Email';
            $message_data['value'] = $email;
            $post_message[]        = $message_data;

            $message_data          = [];
            $message_data['key']   = 'Message';
            $message_data['value'] = $text_message;
            $post_message[]        = $message_data;

            $api_params = [
                'domain'  => $domain,
                'email'   => $email,
                'url'     => site_url(),
                'name'    => $user_name,
                'message' => $post_message,
                'plugin'  => 'Coupon X WooCommerce',
                'type'    => 'Need Help',
            ];

            $api_url = 'https://premioapps.com/premio/send-message-api.php';

            // Sending message to Crisp API.
            $api_response = wp_safe_remote_post(
                $api_url,
                [
                    'body'      => $api_params,
                    'timeout'   => 15,
                    'sslverify' => true,
                ]
            );

            if (is_wp_error($api_response)) {
                wp_safe_remote_post(
                    $api_url,
                    [
                        'body'      => $api_params,
                        'timeout'   => 15,
                        'sslverify' => false,
                    ]
                );
            }

            $response['status'] = 1;
        } else {
            $response['error']  = 1;
            $response['errors'] = $error_array;
        }//end if

        echo json_encode($response);
        wp_die();

    }//end cx_admin_send_message_to_owner()


    /**
     * Coupon X email sign up
     */
    public function coupon_x_update_signup_status()
    {
        $nonce = filter_input(INPUT_POST, 'nonce');
        if (! empty($nonce) && wp_verify_nonce($nonce, 'cx_signup_status')) {
            $status = filter_input(INPUT_POST, 'status');
            $email  = filter_input(INPUT_POST, 'email');
            update_option('cx_signup_popup', true);
            if (1 === (int) $status) {
                $url       = 'https://premioapps.com/premio/signup/email.php';
                $apiParams = [
                    'plugin' => 'coupon',
                    'email'  => $email,
                ];

                // Signup Email for Chaty
                $apiResponse = wp_safe_remote_post($url, ['body' => $apiParams, 'timeout' => 15, 'sslverify' => true]);

                if (is_wp_error($apiResponse)) {
                    wp_safe_remote_post($url, ['body' => $apiParams, 'timeout' => 15, 'sslverify' => false]);
                }

                $response['status'] = 1;
            }
        }//end if

    }//end coupon_x_update_signup_status()


    /**
     * Coupon X pricing table
     */
    public function add_couponx_pricing_tbl()
    {
        include_once 'class-cx-pricing.php';

    }//end add_couponx_pricing_tbl()


    /**
     * Coupon X upgrade links
     *
     * @param  : $links Array of links.
     * @return Array of links.
     */
    public function upgrade_action_links($links)
    {
        $url = admin_url('admin.php?page=couponx_pricing_tbl');

        $links['need_help'] = '<a target="_blank" href="https://premio.io/help/?utm_source=pluginspage" >'.__('Need help?', 'coupon-x').'</a>';
        $links['go_pro']    = '<a  href="'.esc_url($url).'" style="color: #FF5983; font-weight: bold; display: inline-block; border: solid 1px #FF5983; border-radius: 4px; padding: 0 5px;" href="" class="chaty-plugins-gopro">'.esc_attr__('Upgrade', 'coupon-x').'</a>';
        return $links;

    }//end upgrade_action_links()


    /**
     * Coupon X Pro features listing
     */
    public function display_couponx_pro_features()
    {
        include_once 'class-pro-features.php';
        new Cx_Pro_Features();

    }//end display_couponx_pro_features()


    /**
     * Email client integrations screen
     */
    public function email_client_integration()
    {
        ?>
        <div class="couponapp-new-widget-wrap">
            <h2>Integrations</h2>
            <div class="couponapp-new-widget-row">
                <div class="couponapp-features">
                    <ul>
                        <li>
                            <div class="chaty-feature couponapp-feature">
                                <div class="chaty-feature-top couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/mailchimp.png'); ?>">
                                </div>
                                <div class="feature-title couponapp-feature-bottom">
                                    Connect your widget to Mailchimp                                    
                                    <table >
                                        <tbody>
                                            <tr>
                                                <td class='mc-td'>
                                                    <p>
                                                        <input type="button" class="integrate-element-form button-primary connect-to-mailchimp" name="btn-submit" value="Connect to Mailchimp">
                                                    </p>
                                                </td>                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p class="note">
                                        <a href="https://mailchimp.com/help/about-api-keys/" target="_blank">
                                            How to create your API key
                                        </a>
                                    </p>
                                </div>
                                <div class='overlay '></div>
                                <span class='popup-upgrade '>
                                    <a target='_blank' href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                                        <span class="dashicons dashicons-lock"></span>
                                        UPGRADE NOW
                                    </a>
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="chaty-feature couponapp-feature">
                                <div class="chaty-feature-top couponapp-feature-top">
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/klaviyo_icon.png'); ?>">
                                </div>
                                <div class="feature-title couponapp-feature-bottom">
                                    Connect your widget to Klaviyo
                                    <form method="post" action="" id="elements-klv-form">
                                        <table>
                                            <tbody>                                                                                
                                                <tr>
                                                    <td class='mc-td'>
                                                        <p>
                                                            <input type='button' class="integrate-element-form button-primary connect-klaviyo" name="connect_klaviyo" value="
                                                        Connect to Klaviyo">
                                                        </p>
                                                    </td>                                                    
                                                </tr>  
                                            </tbody>
                                        </table>   
                                        <p class="note">
                                            <a href="https://help.klaviyo.com/hc/en-us/articles/115005062267-How-to-Manage-Your-Account-s-API-Keys" target="_blank">
                                                How to create your API key
                                            </a>
                                        </p>                           
                                </div>
                                <div class='overlay'></div>
                                <span class='popup-upgrade '>
                                    <a target='_blank' href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                                        <span class="dashicons dashicons-lock"></span>
                                        UPGRADE NOW
                                    </a>
                                </span>
                            </div>
                        </li>     
                    </ul>
                    <div class="clear clearfix"></div>
                </div>                
            </div>
            <div id="disconnect-confirm" class="couponapp-widget-dialog" title="<?php esc_attr_e('Are you sure about that?', 'coupon-x'); ?>" style='display: none;'>
                <p class='desc'>
                Turning off the feature will <span class='red-text'>stop syncing</span> from submitted emails to <span class='client'></span>. You will not receive new contacts on <span class='client'></span>.
                </p>
            </div>            
        </div>
        <?php

    }//end email_client_integration()

    public function search_woo_product() {
        global $wpdb;

        $items = [];
        $search = filter_input(INPUT_POST,'search');
        $searchType = filter_input(INPUT_POST, "type");

        if(isset($search) && isset($searchType)) {
            if(!empty($search)) {
                if($searchType == "product") {
                    $query = "SELECT ID, post_title 
                        FROM ".$wpdb->posts."
                        WHERE post_status = 'publish' 
                            AND post_type = '".esc_attr($searchType)."'
                            AND post_title like '%".esc_sql($search)."%'
                            LIMIT 0,10";
                    $results = $wpdb->get_results($query);
                    if(!empty($results)) {
                        foreach ($results as $result) {
                            $item = [
                                'id' => $result->ID,
                                'title' => $result->post_title
                            ];
                            $items[] = $item;
                        }
                    }
                } elseif ($searchType == "product_cat") {
                    $args = array(
                        'taxonomy'      => $searchType, // taxonomy name
                        'orderby'       => 'name',
                        'order'         => 'ASC',
                        'hide_empty'    => false,
                        'fields'        => 'all',
                        'name__like'    => $search
                    );

                    $terms = get_terms( $args );
                    if(!empty($terms)) {
                        foreach($terms as $term) {
                            $item = [
                                'id' => $term->term_id,
                                'title' => $term->name
                            ];
                            $items[] = $item;
                        }
                    }
                }
            }
        }

        echo json_encode($items);
        exit;

    }


}//end class


new Dashboard();
