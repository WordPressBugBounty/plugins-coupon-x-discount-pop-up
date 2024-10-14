<?php
/**
 * Coupon X settings
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Frontend;
require_once 'class-cx-helper.php';
use Coupon_X\Dashboard\Cx_Helper;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Coupon X widget frontend
 */
class Couponx_Frontend
{


    /**
     * Constructor.
     */
    public function __construct()
    {

        add_action('wp_enqueue_scripts', [ $this, 'include_coupon_scripts' ]);
        add_action('wp_head', [ $this, 'load_fonts' ], 5);
        add_action('wp_footer', [ $this, 'display_coupon_widget' ]);
        add_action('init', [ $this, 'apply_cx_coupon_link' ]);
//        add_action('woocommerce_before_cart_table', [ $this, 'apply_coupon_from_session' ]);
        add_action('wp_loaded', [$this, 'apply_coupon_from_session'], 30);
        add_action('woocommerce_add_to_cart', [$this, 'apply_coupon_from_session']);

    }//end __construct()


    /**
     * Load coupon x fonts.
     */
    public function load_fonts()
    {

        $widgets = get_posts(
            [
                'numberposts' => -1,
                'post_type'   => 'cx_widget',
                'meta_query'  => [
                    [
                        'key'     => 'status',
                        'value'   => 1,
                        'compare' => '=',
                    ],
                ],
            ]
        );

        if (is_array($widgets) && count($widgets)) {
            foreach ($widgets as $widget) {
                $widget_id       = $widget->ID;
                $widget_settings = unserialize($widget->post_content);
                $showIcon = isset($widget_settings['tab']['show_icon']) ? $widget_settings['tab']['show_icon'] : 1;
                $popupFont = isset($widget_settings['popup']['font']) ? $widget_settings['popup']['font'] : "Google_Fonts-Poppins";
                if($showIcon == 1) {
                    $font = explode('-', $widget_settings['tab']['font']);
                } else {
                    $font = explode('-', $popupFont);
                }
                $font_type       = str_replace('_', ' ', $font[0]);
                $font_family     = str_replace('_', ' ', $font[1]);

                if ('System stack' !== $font_family) {
                    $font_url = 'https://fonts.googleapis.com/css?family='.esc_attr($font_family).':400,500,600,700';
                    wp_enqueue_style('google-front-fonts', $font_url);
                }

                $css  = Cx_Helper::get_tab_css_frontend($widget_settings['tab']);
                $css .= Cx_Helper::get_css_frontend($widget_settings, $widget_id);
            }
        }
        ?>
        <style>
        <?php echo esc_attr($css); ?>        
        </style>
        <?php

    }//end load_fonts()


    /**
     *  Include required scripts and css.
     */
    public function include_coupon_scripts()
    {
        wp_enqueue_style('cx-style', COUPON_X_URL.'assets/css/frontend.min.css', '', COUPON_X_VERSION);
        wp_enqueue_script('cx-script', COUPON_X_URL.'assets/js/frontend.min.js', [ 'jquery' ], COUPON_X_VERSION);
        wp_localize_script(
            'cx-script',
            'cx_data',
            [
                'site_url' => site_url(),
                'nonce'    => wp_create_nonce('wp_rest'),
                'url' => admin_url('admin-ajax.php')
            ]
        );
        if ( version_compare( get_bloginfo( 'version' ), '6.3', '>=' ) ) {
            wp_script_add_data( 'cx-script', 'strategy', 'defer' );
        }


    }//end include_coupon_scripts()


    /**
     * Get active widgets and display it on frontend.
     */
    public function display_coupon_widget()
    {

        $widgets = get_posts(
            [
                'numberposts' => -1,
                'post_type'   => 'cx_widget',
                'meta_query'  => [
                    [
                        'key'     => 'status',
                        'value'   => 1,
                        'compare' => '=',
                    ],
                ],
            ]
        );
        if (is_array($widgets) && count($widgets)) {
            foreach ($widgets as $widget) {
                $widget_id       = $widget->ID;
                $widget_settings = unserialize($widget->post_content);

                $this->render_discount_tab($widget_settings, $widget_id);
            }
        }

    }//end display_coupon_widget()


    /**
     * Check if discount is applicable
     *
     * @param : widget_settings $widget_settings widget settings array.
     *
     * @return boolean
     */
    public function is_discount_applicable($widget_settings)
    {

        if ('2' === $widget_settings['popup']['coupon_type']
            || '3' === $widget_settings['popup']['coupon_type']
        ) {
            $is_valid_product = false;
            $is_valid_min     = true;
            $is_valid_date    = true;
            $applies_to       = $widget_settings['unique_coupon']['applies_to'];
            if ('order' === $applies_to) {
                $is_valid_product = true;
            } else {
                $is_valid_product = $this->is_valid_product($applies_to, $widget_settings['unique_coupon']);
            }

            if (! $is_valid_product) {
                return false;
            }

            if ('none' !== $widget_settings['unique_coupon']['min_req']) {
                $is_valid_min = $this->is_valid_min_req($widget_settings['unique_coupon']);
            }

            if (! $is_valid_min) {
                return false;
            }

            if (isset($widget_settings['unique_coupon']['enable_date'])
                && 1 === (int) $widget_settings['unique_coupon']['enable_date']
            ) {
                $is_valid_date = $this->is_valid_date($widget_settings['unique_coupon']);
            }

            if (! $is_valid_date) {
                return false;
            }

            return true;
        }//end if

    }//end is_discount_applicable()


    /**
     * Check if product is applicable for discount
     *
     * @param : applies_to            $applies_to            string.
     * @param : unique_coupon_setting $unique_coupon_setting coupon settings.
     *
     * @return boolean
     */
    public function is_valid_product($applies_to, $unique_coupon_setting)
    {

        $product_id = get_the_ID();

        if ('collections' === $applies_to) {
            $terms = get_the_terms($product_id, 'product_cat');

            $term_ids = [];
            foreach ($terms as $term) {
                $term_ids[] = $term->term_id;
            }

            $ids = array_intersect($term_ids, $unique_coupon_setting['cats']);
            if (is_array($ids) && count($ids) > 0) {
                return true;
            } else {
                return false;
            }
        } else if ('products' === $applies_to) {
            if (in_array((string) $product_id, $unique_coupon_setting['products'], true)) {
                return true;
            } else {
                return false;
            }
        }//end if

        return false;

    }//end is_valid_product()


    /**
     * Check if cart satisfies the minimum requirement
     *
     * @param unique_coupon_setting $unique_coupon_setting coupon settings.
     *
     * @return boolean
     */
    public function is_valid_min_req($unique_coupon_setting)
    {
        if(function_exists('WC')) {
            if ('subtotal' === $unique_coupon_setting['min_req']) {
                // discount type is cart totals. Get cart total and compare it with settings value.
                $cart_total = WC()->cart->subtotal;
                if ($cart_total >= $unique_coupon_setting['min_val']) {
                    return true;
                } else {
                    return false;
                }
            } else if ('qty' === $unique_coupon_setting['min_req']) {
                // discount type is number of cart items. Get total number of products in cart and compare it with settings value.
                $cart_product_count = WC()->cart->get_cart_contents_count();
                if ($cart_product_count >= $unique_coupon_setting['discount_perqty']) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }

    }//end is_valid_min_req()


    /**
     * Check if coupon date is valid.
     *
     * @param start_date $start_date valid start date.
     * @param end_date   $end_date   valid end date.
     *
     * @return boolean
     */
    public function is_valid_date($start_date, $end_date)
    {
        $date1 = $start_date.' 00:00';
        $date2 = $end_date.' 23:59';

        $dt         = strtotime(gmdate('Y-m-d H:i'));
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);

        if ($dt >= $timestamp1 && $dt <= $timestamp2) {
            return true;
        }

        return false;

    }//end is_valid_date()


    /**
     * Get a string of applicable widget classes.
     *
     * @param widget_settings $widget_settings widget settings.
     *
     * @return string coupon classes
     */
    public function get_coupon_classes($widget_settings)
    {

        $settings        = $widget_settings['tab'];
        $couponapp_class = [];
        if($settings['show_icon'] == 1) {
            if ('custom' === $settings['position']) {
                $couponapp_class[] = 'couponapp-position-custom couponapp-position-' . $settings['custom_position'];
            } else {
                $couponapp_class[] = 'couponapp-position-' . $settings['position'];
            }
        } else {
            if('custom' === $widget_settings['popup']['slide_in_position']) {
                $couponapp_class[] = 'couponapp-position-custom couponapp-position-' . $widget_settings['popup']['custom_position'];
            } else {
                $couponapp_class[] = 'couponapp-position-' . $widget_settings['popup']['slide_in_position'];
            }
        }

        if (1 !== (int) $settings['show_icon']) {
            $couponapp_class[] = 'couponapp-hide-cta-icon';
        }

        $couponapp_class[] = 'couponapp-tab-shape-'.esc_attr($settings['tab_shape']);
        $couponapp_class[] = 'couponapp-'.esc_attr($settings['effect']).'-animation';

        $couponapp_class[] = 'couponapp-'.esc_attr($widget_settings['popup']['style']);

        if (isset($widget_settings['trigger']['display_desktop'])
            && 1 === (int) $widget_settings['trigger']['display_desktop']
        ) {
            $couponapp_class[] = 'couponapp-desktop';
        }

        if (isset($widget_settings['trigger']['display_mobile'])
            && 1 === (int) $widget_settings['trigger']['display_mobile']
        ) {
            $couponapp_class[] = 'couponapp-mobile';
        }

        $couponapp_class[] = 'couponapp-open-state-'.esc_attr($widget_settings['trigger']['when']);

        // Call to action always show then assign class.
        if (1 === (int) $settings['show_cta']) {
            $couponapp_class[] = 'couponapp-open-always';
        } else {
            $couponapp_class[] = 'couponapp-open-first';
        }

        if(1 == (int) @$settings['show_attention']) {
            $couponapp_class[] = "couponapp-attention-always";
        } else {
            $couponapp_class[] = "couponapp-attention-once";
        }

        if (2 === (int) $settings['show_tab']
            || ( isset($widget_settings['announcement']['enable_btn']) && 1 === (int) $widget_settings['announcement']['enable_btn'] && 1 === (int) $widget_settings['announcement']['btn_action'] )
        ) {
            $couponapp_class[] = 'couponapp-tab-hide';
        }

        $couponapp_classes = join(' ', $couponapp_class);
        return $couponapp_classes;

    }//end get_coupon_classes()


    /**
     * Render widget.
     *
     * @param widget_settings $widget_settings widget settings.
     * @param widget_id       $widget_id       widget id.
     */
    public function render_discount_tab($widget_settings, $widget_id)
    {

        global $wpdb;

        $settings        = $widget_settings['tab'];
        $coupon_tab_icon = Cx_Helper::coupon_tab_icon();

        $couponapp_classes = $this->get_coupon_classes($widget_settings);

        $widgetcounter      = $widget_id;
        $widget_close_after = '';
        $exit_intent        = isset($widget_settings['trigger']['exit_intent']) ? $widget_settings['trigger']['exit_intent'] : '';
        $delay    = isset($widget_settings['trigger']['enable_time_delay']) &&
        1 === (int) $widget_settings['trigger']['enable_time_delay'] ? $widget_settings['trigger']['delay_time'] : '';
        $scroll   = isset($widget_settings['trigger']['enable_page_scroll']) &&
        1 === (int) $widget_settings['trigger']['enable_page_scroll'] ? $widget_settings['trigger']['scroll_percent'] : '';
        $end_date = isset($widget_settings['unique_coupon']['end_date']) ? $widget_settings['unique_coupon']['end_date'] : '';

        if ('' !== $end_date) {
            $start        = strtotime(gmdate('Y-m-d'));
            $end          = strtotime($end_date);
            $days_between = ceil(abs($end - $start) / 86400);
        } else {
            $days_between = 365;
        }

        $version = get_post_meta($widget_id, 'version', true);

        $coupon_type      = $widget_settings['popup']['coupon_type'];
        $coupon_code_text = '';
        if (1 === (int) $coupon_type) {
            $coupon_code_text = get_the_title($widget_settings['ex_coupon']['coupon']);
        } else if (3 === (int) $coupon_type) {
            $coupon_code_text = $widget_settings['unique_coupon']['discount_code'];
        } else {
            $coupon_code_text = '';
        }

        $auto_close = '';
        if (isset($widget_settings['popup']['auto_close'])
            && 1 === (int) $widget_settings['popup']['auto_close']
            && $widget_settings['popup']['auto_time'] > 0
        ) {
            $auto_close = str_replace("'", '', $widget_settings['popup']['auto_time']);
        }
        ?>
        <div id="tab-box-front-<?php echo esc_attr($widgetcounter); ?>" class="tab-box tab-front-box tab-box-front-<?php echo esc_attr($widgetcounter); ?> <?php echo esc_attr($couponapp_classes); ?> hide" <?php echo esc_attr($widget_close_after); ?> data-isexit = '<?php echo esc_attr($exit_intent); ?>' data-delay='<?php echo esc_attr($delay); ?>' data-scroll='<?php echo esc_attr($scroll); ?>' data-widgetid = '<?php echo esc_attr($widget_id); ?>' data-version='<?php echo esc_attr($version); ?>' data-style='<?php echo esc_attr($widget_settings['popup']['style']); ?>' <?php echo esc_attr('' !== $auto_close ? 'data-close-widget='.$auto_close : ''); ?> data-type= '<?php echo esc_attr($coupon_type); ?>'>

        <?php
        $this->render_coupon_form($widget_settings, $widget_id, $coupon_code_text);
        ?>

            <div class="tab-box-wrap hide">
                <input type='hidden' class='cx-code' data-widget-id = '<?php echo esc_attr($widget_id); ?>' data-coupon-id = '' value='<?php echo esc_attr($coupon_code_text); ?>' data-valid='<?php echo esc_attr($days_between); ?>'/>
                <div class="tab-text" style="color:<?php echo esc_attr($settings['action_color']); ?>;" >
        <?php echo esc_attr($settings['call_action']); ?>
                </div>
                <div class="tab-icon " style="background-color:<?php echo esc_attr($settings['tab_color']); ?>" >
                    <span class='icon-img'>
        <?php if ('hexagon' === $settings['tab_shape']) : ?>
                        <span class="after hexagon-after" style="background-color:<?php echo esc_attr($settings['tab_color']); ?>;" >
                        </span>
                        <span class="before hexagon-before" style="background-color:<?php echo esc_attr($settings['tab_color']); ?>;" >
                        </span>
        <?php endif; ?>
        <?php if ('custom' === $settings['tab_icon'] && '' !== $settings['tab_custom_icon']) : ?>
                        <img class="custom-tab-img" src="<?php echo esc_attr($settings['tab_custom_icon']); ?>" />
            <?php
            elseif ('custom' === $settings['tab_icon'] && '' === $settings['tab_custom_icon']) :
                $customFile = '<svg class="tab-icon-svg" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" r="18"></circle><path d="M24.7528 25.463H20.8737H19.8292H19.6036V20.2599H21.3053C21.7368 20.2599 21.9918 19.7695 21.7368 19.4164L18.4266 14.8361C18.2158 14.5419 17.7793 14.5419 17.5685 14.8361L14.2583 19.4164C14.0033 19.7695 14.2534 20.2599 14.6898 20.2599H16.3915V25.463H16.1659H15.1214H10.6244C8.04986 25.3208 6 22.913 6 20.304C6 18.5043 6.97589 16.935 8.42256 16.0866C8.29015 15.7286 8.2215 15.3461 8.2215 14.944C8.2215 13.105 9.7074 11.6191 11.5464 11.6191C11.9436 11.6191 12.3261 11.6878 12.6841 11.8202C13.7483 9.56436 16.0433 8 18.7111 8C22.1635 8.0049 25.0078 10.6481 25.3314 14.0172C27.9845 14.4732 30 16.9301 30 19.7107C30 22.6825 27.6853 25.257 24.7528 25.463Z" fill="rgb(96, 93, 236);"></path></svg>';
                ?>
                <?php echo wp_kses($coupon_tab_icon['tab-icon-1'], Cx_Helper::get_svg_ruleset()); ?>
                <?php
        else :
            echo wp_kses($coupon_tab_icon[$settings['tab_icon']], Cx_Helper::get_svg_ruleset());
        endif;
        ?>
                    <svg class="tab-icon-close" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" width="24" height="24" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"></path>
                    </svg>
                    </span>
        <?php
        if (isset($settings['msg']) && 1 === (int) $settings['msg']) {
            ?>
                        <span class="coupon-pending-message" style="color: <?php echo esc_attr($settings['no_color']); ?>; background: <?php echo esc_attr($settings['no_bgcolor']); ?> none repeat scroll 0% 0%;" >
            <?php echo esc_attr($settings['no_msg']); ?>
                        </span>
            <?php
        }
        ?>
                </div>
            </div>
        </div>        
        <?php

    }//end render_discount_tab()


    /**
     * Render widget.
     *
     * @param widget_settings  $widget_settings  widget settings.
     * @param widget_id        $widget_id        widget id.
     * @param coupon_code_text $coupon_code_text code.
     */
    public function render_coupon_form($widget_settings, $widget_id, $coupon_code_text)
    {

        $popup_settings  = $widget_settings['popup'];
        $coupon_settings = $widget_settings['coupon'];

        if ('style-1' === $popup_settings['style']) {
            $this->render_coupon_dialog($widget_settings, $widget_id, $coupon_code_text);
        } else if ('style-2' === $popup_settings['style']) {
            $this->render_email_dialog($widget_settings, $widget_id, $coupon_code_text);
            $this->render_coupon_dialog($widget_settings, $widget_id, $coupon_code_text);
        } else if ('style-3' === $popup_settings['style']) {
            $this->render_link_dialog($widget_settings, $widget_id, $coupon_code_text);
        } else if ('style-4' === $popup_settings['style']) {
            $this->render_an_dialog($widget_settings, $widget_id);
        } else {
            $this->render_email_dialog($widget_settings, $widget_id, $coupon_code_text);
            $this->render_an_dialog($widget_settings, $widget_id);
        }

    }//end render_coupon_form()


    /**
     * Render widget coupon dialog.
     *
     * @param settings         $settings         widget settings.
     * @param widget_id        $widget_id        widget id.
     * @param coupon_code_text $coupon_code_text code.
     */
    public function render_coupon_dialog($settings, $widget_id, $coupon_code_text)
    {
        $coupon_settings = $settings['coupon'];
        $popup_settings  = $settings['popup'];
        $style = $popup_settings['style'];
        $email_settings = $settings['main'];
        $widgetcounter   = $widget_id;

        $enable_style = isset($coupon_settings['enable_styles']) ? (int) $coupon_settings['enable_styles'] : 0;

        if($enable_style == 1 && $style == "style-2") {
            $isImage = isset($email_settings['add_image']) ? $email_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($email_settings['image_url']) ? $email_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($email_settings['img_position']) ? $email_settings['img_position'] : "left";
            }
        } else {
            $isImage = isset($coupon_settings['add_image']) ? $coupon_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($coupon_settings['image_url']) ? $coupon_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($coupon_settings['img_position']) ? $coupon_settings['img_position'] : "left";
            }
        }

        if($style == "style-2" && $enable_style == 1) {
            $isElements = isset($email_settings['add_elements']) ? $email_settings['add_elements'] : 1;
            $elementType = isset($email_settings['element_type']) ? $email_settings['element_type'] : 'confetti';
        } else {
            $isElements = isset($coupon_settings['add_elements']) ? $coupon_settings['add_elements'] : 1;
            $elementType = isset($coupon_settings['element_type']) ? $coupon_settings['element_type'] : 'confetti';
        }

        $allowedTags = [
            'a'       => [
                'href'   => [],
                'title'  => [],
                'target' => [],
            ],
            'abbr'    => [ 'title' => [] ],
            'acronym' => [ 'title' => [] ],
            'code'    => [],
            'pre'     => [],
            'em'      => [],
            'strong'  => [],
            'ul'      => [],
            'ol'      => [],
            'li'      => [],
            'span'    => [
                'style' => []
            ],
            'p'       => [],
            'br'      => [],
            'img'     => [
                'src' => [],
                'alt' => []
            ]
        ];

        ?>
        <style>
            <?php if(!empty($imageUrl) && $imgPosition == "cover") { ?>
            .tab-box-content.type-coupon.has-image.cover .content-preview {background-image: url("<?php echo $imageUrl ?>")}
            <?php } ?>
        </style>

        <div class="tab-box-content type-coupon tab-box-couponcode-content <?php echo $imageClass ?> <?php echo $imgPosition ?> <?php echo ($isElements == 1) ? "element-".$elementType : "" ?>">
            <a href="javascript:void(0);" class="coupon-tab-close" >
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd;clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                </svg>
            </a>
            <?php if(!empty($imageUrl)) { ?>
                <div class="img-preview">
                    <img src="<?php echo $imageUrl ?>">
                </div>
            <?php } ?>
            <div class="content-preview">
                <h4 >
                    <?php echo wp_kses($coupon_settings['headline'], $allowedTags); ?>
                </h4>
                <div class="form-wrap cx-clear" >
                    <div class="coupon-code-text">
                    <span id="copy-couponapp-code-<?php echo esc_attr($widgetcounter); ?>" class="label-tooltip" data-title="<?php echo esc_attr($coupon_settings['cpy_msg']); ?>">   <div class="sr-only">
                        <input id="copy-coupon-inputcode-<?php echo esc_attr($widgetcounter); ?>" type="text" value="<?php echo esc_attr($coupon_code_text); ?>" readonly />
                        </div>
                        <span class='code'><?php echo esc_attr($coupon_code_text); ?></span>
                    </span>
                    </div>
                    <button class="button btn btn-blue coupon-button copy-to-clipboard" data-clipboard-action="copy"  data-clipboard-target="#copy-couponapp-code-<?php echo esc_attr($widgetcounter); ?>" data-widget-id="<?php echo esc_attr($widget_id); ?>" data-widget-count="<?php echo esc_attr($widgetcounter); ?>">
                        <?php echo esc_attr($coupon_settings['cpy_btn']); ?>
                    </button>
                    <svg class="vector <?php echo esc_attr('style-3' === $popup_settings['style'] ? 'hide' : ''); ?> " id='vector-nonfloat-bar' width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.584 3.384C4.722 3.084 4.8 2.754 4.8 2.4C4.8 1.074 3.726 0 2.4 0C1.074 0 0 1.074 0 2.4C0 3.726 1.074 4.8 2.4 4.8C2.754 4.8 3.084 4.722 3.384 4.584L4.8 6L3.384 7.416C3.084 7.278 2.754 7.2 2.4 7.2C1.074 7.2 0 8.274 0 9.6C0 10.926 1.074 12 2.4 12C3.726 12 4.8 10.926 4.8 9.6C4.8 9.246 4.722 8.916 4.584 8.616L6 7.2L10.2 11.4H12V10.8L4.584 3.384ZM2.4 3.6C1.74 3.6 1.2 3.066 1.2 2.4C1.2 1.734 1.74 1.2 2.4 1.2C3.06 1.2 3.6 1.734 3.6 2.4C3.6 3.066 3.06 3.6 2.4 3.6ZM2.4 10.8C1.74 10.8 1.2 10.266 1.2 9.6C1.2 8.934 1.74 8.4 2.4 8.4C3.06 8.4 3.6 8.934 3.6 9.6C3.6 10.266 3.06 10.8 2.4 10.8ZM6 6.3C5.832 6.3 5.7 6.168 5.7 6C5.7 5.832 5.832 5.7 6 5.7C6.168 5.7 6.3 5.832 6.3 6C6.3 6.168 6.168 6.3 6 6.3ZM10.2 0.6L6 4.8L7.2 6L12 1.2V0.6H10.2Z" fill='<?php echo esc_attr($coupon_settings['coupon_brdcolor']); ?> '/>
                    </svg>
                </div>
                <div class="coupon-description" >
                    <?php echo wp_kses($coupon_settings['desc'], $allowedTags); ?>
                </div>
            </div>
        </div>
        <?php

    }//end render_coupon_dialog()


    /**
     * Render widget email dialog.
     *
     * @param settings         $settings         widget settings.
     * @param widget_id        $widget_id        widget id.
     * @param coupon_code_text $coupon_code_text code.
     */
    public function render_email_dialog($settings, $widget_id, $coupon_code_text)
    {

        $email_settings = $settings['main'];
        $widgetcounter  = $widget_id;
        $allowedTags = [
            'a'       => [
                'href'   => [],
                'title'  => [],
                'target' => [],
            ],
            'abbr'    => [ 'title' => [] ],
            'acronym' => [ 'title' => [] ],
            'code'    => [],
            'pre'     => [],
            'em'      => [],
            'strong'  => [],
            'ul'      => [],
            'ol'      => [],
            'li'      => [],
            'span'    => [
                'style' => []
            ],
            'p'       => [],
            'br'      => [],
            'img'     => [
                'src' => [],
                'alt' => []
            ]
        ];

        $isImage = isset($email_settings['add_image']) ? $email_settings['add_image'] : 0;
        $imageUrl = "";
        $imageClass = "";
        $imgPosition = "";
        if($isImage == 1) {
            $imageUrl = isset($email_settings['image_url']) ? $email_settings['image_url'] : '';
            $imageClass = "has-image";
            $imgPosition = isset($email_settings['img_position']) ? $email_settings['img_position'] : "left";
        }
        $isElements = isset($email_settings['add_elements']) ? $email_settings['add_elements'] : 1;
        $elementType = isset($email_settings['element_type']) ? $email_settings['element_type'] : 'confetti';
        ?>
        <style>
            <?php if(!empty($imageUrl) && $imgPosition == "cover") { ?>
            .tab-box-content.type-email.has-image.cover .content-preview {background-image: url("<?php echo $imageUrl ?>")}
            <?php } ?>
        </style>

        <div class="tab-box-content type-email tab-box-email-content <?php echo $imageClass ?> <?php echo $imgPosition ?> <?php echo ($isElements == 1) ? "element-".$elementType : "" ?>">
            <a href="#" class="coupon-tab-close" >
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd;  clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                </svg>
            </a>
            <?php if(!empty($imageUrl)) { ?>
                <div class="img-preview">
                    <img src="<?php echo $imageUrl ?>">
                </div>
            <?php } ?>
            <div class="content-preview">
                <h4><?php echo wp_kses($email_settings['headline'], $allowedTags); ?></h4>
                <?php
                $consent = isset($email_settings['consent']) ? $email_settings['consent'] : 0;
                ?>
                <form class="tab-box-front-<?php echo esc_attr($widgetcounter); ?>" action="" method="post">
                    <div class="form-wrap cx-clear cx-form-wrap <?php echo (@$email_settings['collect_name'] == 1) ? "" : "hide" ?> mb-10">
                        <p class="customer-name-text coupon-code-email-text">
                            <input type="text" name="couponapp-name" value="" placeholder=" <?php echo esc_attr(@$email_settings['name']); ?>" class="<?php echo (@$email_settings['required_name'] == 1) ? "required-name" : "" ?>" />
                        </p>
                    </div>
                    <span class="required-text-msg"><?php echo esc_attr(@$email_settings['validation_text']) ?></span>
                    <div class="form-wrap cx-clear cx-form-wrap">
                        <p class="coupon-code-email-text">
                            <input type="hidden" name="hide_coup_code" class='hide_coup_code' value="<?php echo esc_attr($coupon_code_text); ?>">
                            <input type="email" name="couponapp-email" value="" placeholder=" <?php echo esc_attr($email_settings['email']); ?>" data-widget-id="<?php echo esc_attr($widget_id); ?>" required pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}"/>
                        </p>
                        <button type="submit" class="button btn btn-blue coupon-button coupon-email-button" data-widget-id="<?php echo esc_attr($widgetcounter); ?>" data-consent="<?php echo esc_attr($consent); ?>" data-consent-id="email-content-<?php echo esc_attr($widgetcounter); ?>" data-email-msgcolor="<?php echo esc_attr($email_settings['error_color']); ?>" data-coupon-code = "<?php echo esc_attr($coupon_code_text); ?>">
                            <?php echo esc_attr($email_settings['btn_text']); ?>
                        </button>
                    </div>
                    <?php
                    $required = ( isset($email_settings['consent_required']) && 1 === (int) $email_settings['consent_required'] ) ? 'required' : '';
                    echo ( 1 === (int) $consent ) ? '<label class="email-content-checkbox"><input type="checkbox" name="" value="1" id="email-content-'.esc_attr($widgetcounter).'" '.esc_attr($required).'/>&nbsp;'. wp_kses($email_settings['consent_text'], $allowedTags) .'</label>' : '';
                    ?>
                </form>
                <div class="coupon-description">
                    <?php echo wp_kses($email_settings['desc'], $allowedTags); ?>
                </div>
            </div>
        </div>
        <?php

    }//end render_email_dialog()


    /**
     * Render widget link dialog.
     *
     * @param settings         $settings         widget settings.
     * @param widget_id        $widget_id        widget id.
     * @param coupon_code_text $coupon_code_text code.
     */
    public function render_link_dialog($settings, $widget_id, $coupon_code_text)
    {
        $coupon_settings = $settings['coupon'];
        $email_settings = $settings['main'];
        $style = $settings['popup']['style'];
        $couponcode_link = $settings['coupon']['custom_link'];
        $link = '';
        if(function_exists('wc_get_cart_url')) {
            $link = wc_get_cart_url() . '?cx_code=';
            if (1 === (int)$settings['coupon']['link_type']) {
                $couponcode_link = wc_get_cart_url() . '?cx_code=' . esc_attr($coupon_code_text);
            }
        }

        $target = '';
        if (isset($settings['coupon']['new_tab'])
            && 1 === (int) $settings['coupon']['new_tab']
        ) {
            $target = 'target="_blank"';
        }

        $enable_style = isset($coupon_settings['enable_styles']) ? (int) $coupon_settings['enable_styles'] : 0;
        if($enable_style == 1 && $style == "style-2") {
            $isImage = isset($email_settings['add_image']) ? $email_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($email_settings['image_url']) ? $email_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($email_settings['img_position']) ? $email_settings['img_position'] : "left";
            }
        } else {
            $isImage = isset($coupon_settings['add_image']) ? $coupon_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($coupon_settings['image_url']) ? $coupon_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($coupon_settings['img_position']) ? $coupon_settings['img_position'] : "left";
            }
        }
        $isElements = isset($coupon_settings['add_elements']) ? $coupon_settings['add_elements'] : 1;
        $elementType = isset($coupon_settings['element_type']) ? $coupon_settings['element_type'] : 'confetti';

        $allowedTags = [
            'a'       => [
                'href'   => [],
                'title'  => [],
                'target' => [],
            ],
            'abbr'    => [ 'title' => [] ],
            'acronym' => [ 'title' => [] ],
            'code'    => [],
            'pre'     => [],
            'em'      => [],
            'strong'  => [],
            'ul'      => [],
            'ol'      => [],
            'li'      => [],
            'span'    => [
                'style' => []
            ],
            'p'       => [],
            'br'      => [],
            'img'     => [
                'src' => [],
                'alt' => []
            ]
        ];

        ?>

        <style>
            <?php if(!empty($imageUrl) && $imgPosition == "cover") { ?>
            .tab-box-content.type-coupon.has-image.cover .content-preview {background-image: url("<?php echo $imageUrl ?>")}
            <?php } ?>
        </style>

        <div class="tab-box-content type-coupon tab-box-couponcode-content <?php echo $imageClass ?> <?php echo $imgPosition ?> <?php echo ($isElements == 1) ? "element-".$elementType : "" ?>">
            <a href="#" class="coupon-tab-close" >
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd;  clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink"><path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                </svg>
            </a>
            <?php if(!empty($imageUrl)) { ?>
                <div class="img-preview">
                    <img src="<?php echo $imageUrl ?>">
                </div>
            <?php } ?>
            <div class="content-preview">
                <h4>
                    <?php
                    echo wp_kses($coupon_settings['headline'], $allowedTags);
                    ?>
                </h4>
                <div class="form-wrap cx-clear">
                    <a href="<?php echo esc_attr($couponcode_link); ?>" class="button btn btn-blue coupon-button coupon-code-link"  <?php echo esc_attr($target); ?> data-widget-id="<?php echo esc_attr($widget_id); ?>" data-type="<?php echo esc_attr($settings['coupon']['link_type']); ?>" data-url = '<?php echo esc_url($link); ?>' >
                        <?php echo esc_attr($coupon_settings['cpy_btn']); ?>
                    </a>
                </div>
                <div class="coupon-description">
                    <?php echo wp_kses($coupon_settings['desc'], $allowedTags); ?>
                </div>
            </div>
        </div>
        <?php

    }//end render_link_dialog()


    /**
     * Render announcement dialog.
     *
     * @param settings  $settings  widget settings.
     * @param widget_id $widget_id widget id.
     */
    public function render_an_dialog($settings, $widget_id)
    {

        $btn_link        = $settings['announcement']['redirect_url'];
        $an_settings     = $settings['announcement'];
        $email_settings = $settings['main'];
        $coupon_settings = $settings['coupon'];
        $style           = $settings['popup']['style'];
        $enable_timer    = @$settings['coupon']['enable_timer'] ? $settings['coupon']['enable_timer'] : 0;

        $mins = 0;
        $sec  = 0;
        $days = 0;
        $hrs  = 0;
        $expired_date_time = '';
        $timezone          = '';
        $class =  "";

        if (1 === (int) @$coupon_settings['timer_type']) {
            $mins = @$coupon_settings['timer_minute'];
            $sec  = @$coupon_settings['timer_seconds'];
        } else {
            $expire_date = @$coupon_settings['timer_date'];
            $expire_time = @$coupon_settings['timer_time'];
            $timezone    = @$coupon_settings['timer_timezone'];

            $expired_date_time = gmdate('Y-m-d H:i:s', strtotime("$expire_date $expire_time"));
        }

        if ('style-5' === $style) {
            $class = ' hide';
        }

        if (1 === (int) $settings['announcement']['btn_action']) {
            $cls = ' close-an';
        } else if (2 === (int) $settings['announcement']['btn_action']) {
            $cls = ' open-an';
        }

        $enable_style = isset($an_settings['enable_styles']) ? (int) $an_settings['enable_styles'] : 0;
        if($enable_style == 1 && $style == "style-5") {
            $isImage = isset($email_settings['add_image']) ? $email_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($email_settings['image_url']) ? $email_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($email_settings['img_position']) ? $email_settings['img_position'] : "left";
            }
        } else {
            $isImage = isset($an_settings['add_image']) ? $an_settings['add_image'] : 0;
            $imageUrl = "";
            $imageClass = "";
            $imgPosition = "";
            if($isImage == 1) {
                $imageUrl = isset($an_settings['image_url']) ? $an_settings['image_url'] : '';
                $imageClass = "has-image";
                $imgPosition = isset($an_settings['img_position']) ? $an_settings['img_position'] : "left";
            }
        }

        if($enable_style == 1 && $style == "style-5") {
            $isElements = isset($email_settings['add_elements']) ? $email_settings['add_elements'] : 1;
            $elementType = isset($email_settings['element_type']) ? $email_settings['element_type'] : 'confetti';
        } else {
            $isElements = isset($an_settings['add_elements']) ? $an_settings['add_elements'] : 1;
            $elementType = isset($an_settings['element_type']) ? $an_settings['element_type'] : 'confetti';
        }

        $allowedTags = [
            'a'       => [
                'href'   => [],
                'title'  => [],
                'target' => [],
            ],
            'abbr'    => [ 'title' => [] ],
            'acronym' => [ 'title' => [] ],
            'code'    => [],
            'pre'     => [],
            'em'      => [],
            'strong'  => [],
            'ul'      => [],
            'ol'      => [],
            'li'      => [],
            'span'    => [
                'style' => []
            ],
            'p'       => [],
            'br'      => [],
            'img'     => [
                'src' => [],
                'alt' => []
            ]
        ];

        ?>
        <style>
            <?php if(!empty($imageUrl) && $imgPosition == "cover") { ?>
            .tab-box-content.type-announcement.has-image.cover .content-preview {background-image: url("<?php echo $imageUrl ?>")}
            <?php } ?>
        </style>

        <div class="tab-box-content tab-box-couponcode-content type-announcement <?php echo ($isElements == 1) ? "element-".$elementType : "" ?> <?php echo $imageClass ?> <?php echo $imgPosition ?> tab-box-an <?php echo esc_attr($class); ?>">
            <a href="#" class="coupon-tab-close" >
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd;  clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink"><path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                </svg>
            </a>
            <?php if(!empty($imageUrl)) { ?>
            <div class="img-preview">
                <img src="<?php echo $imageUrl ?>">
            </div>
            <?php } ?>
            <div class="content-preview">
                <h4>
                    <?php
                    echo wp_kses($an_settings['headline'], $allowedTags);
                    ?>
                </h4>
                <?php
                if (1 === (int) @$an_settings['enable_btn']) {
                    $new_tab = isset($an_settings['new_tab']) ? $an_settings['new_tab'] : 0;
                    $target  = 1 === (int) $new_tab ? 'blank' : '';
                    ?>
                    <div class="form-wrap cx-clear">
                        <a href="#"  url="<?php echo esc_attr($btn_link); ?>" class="button btn btn-blue coupon-button <?php echo esc_attr($cls).' '.esc_attr($target); ?>" >
                    <?php echo esc_attr($an_settings['cpy_btn']); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="coupon-description">
                    <?php echo wp_kses($an_settings['desc'], $allowedTags); ?>
                </div>
            </div>
        </div>
            <?php

    }//end render_an_dialog()


    /**
     * Get coupon code from url and save it in the wc session.
     */
    public function apply_cx_coupon_link()
    {

        if (isset($_GET['cx_code'])) {
            if(function_exists('WC')) {
                if (!WC()->session->has_session()) {
                    WC()->session->set_customer_session_cookie(true);
                }

                $coupon_code = WC()->session->get('cx_code');
                if (empty($coupon_code) && isset($_GET['cx_code'])) {
                    $coupon_code = filter_input(INPUT_GET, 'cx_code');

                    WC()->session->set('cx_code', $coupon_code);
                    // Set the coupon code in session.
                }
            }
        }

    }//end apply_cx_coupon_link()


    /**
     * Apply coupon code from session.
     */
    public function apply_coupon_from_session()
    {
        if(function_exists('WC')) {
            if(isset(WC()->session) && WC()->session->get('cx_code') != null) {
                $coupon_code = sanitize_text_field(WC()->session->get('cx_code'));
                if (!empty($coupon_code) && !WC()->cart->has_discount($coupon_code)) {
                    WC()->cart->add_discount($coupon_code);
                    // apply the coupon discount.
                    WC()->session->__unset('cx_code');
                    // remove coupon code from session.
                }
            }
        }

    }//end apply_coupon_from_session()


}//end class


new Couponx_Frontend();
