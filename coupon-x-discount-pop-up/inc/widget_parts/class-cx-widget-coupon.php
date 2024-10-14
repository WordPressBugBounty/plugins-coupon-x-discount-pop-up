<?php
/**
 * Create Coupon - Popup Design
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;
require_once COUPON_X_PATH.'/inc/class-dashboard.php';
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create new widget - coupon design
 */
class Cx_Widget_Coupon
{


    /**
     * Constructor function
     *
     * @param : $settings array of widget settings.
     */
    public function __construct($settings)
    {
        $this->render_coupon_design($settings);

    }//end __construct()


    /**
     * Renders choose coupon tab html
     *
     * @param : $settings array of widget settings.
     */
    public function render_coupon_design($settings)
    {

        $popup     = $settings['popup'];
        $type      = (int) $popup['coupon_type'];
        $wc_status = defined('WC_VERSION') ? 1 : 0;
        ?>
        <div id="couponapp-wp-coupon-types" class="couponapp-conversation-data coupon-choose-dialogbox">
            <div class='cx-tab'>
                <div class="wp-coupon-types-wrap">
                    <?php
                    if (0 === $wc_status) {
                        ?>
                        <div class="coupon-code-option4  select-no-coupon-code coupon-type <?php echo esc_attr(4 === $type ? 'active-type' : ''); ?>">
                            <div class="coupon-code-option-titlebox">
                                <span><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#000" style='width:60%; float:left'> <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/> </svg></span>
                                <h4><?php esc_html_e("Announcement Pop up - don't show a coupon code", 'coupon-x'); ?></h4>
                            </div>
                            <p><?php esc_html_e("Don't want to show coupons? Use the widget for only collecting emails, showing announcements, or showing promotional offers via attention-grabbing widget pop-ups!", 'coupon-x'); ?></p>
                            <span class='svg-icon'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none"> <circle cx="31.5" cy="31.5" r="31.5" class="icon-morbox" fill="#C4CED8"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M33.7672 16.1979C34.7625 15.2409 36.3451 15.272 37.3021 16.2672L51.4077 30.9371L37.3648 46.665C36.4453 47.695 34.8649 47.7844 33.835 46.8648C32.805 45.9453 32.7156 44.3649 33.6352 43.335L42.4164 33.5H14C12.6193 33.5 11.5 32.3807 11.5 31C11.5 29.6193 12.6193 28.5 14 28.5H42.1279L33.6979 19.7328C32.7409 18.7375 32.772 17.1549 33.7672 16.1979Z" fill="white"></path> </svg>
                                <button class=' btn-blue btn-selected'><?php esc_html_e('Selected', 'coupon-x'); ?> </button>
                            </span>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="custom-coupon-code coupon-type <?php echo esc_attr(3 === $type ? 'active-type' : ''); ?><?php echo esc_attr(0 === $wc_status ? 'disable' : ''); ?>">
                        <div class="coupon-code-option-titlebox">
                            <span><img src="<?php echo esc_url(COUPON_X_URL.'assets/img/Icon1.svg'); ?>"></span>
                            <h4><?php esc_html_e('Create a new Woocommerce discount with Coupon X', 'coupon-x'); ?></h4>
                        </div>
                        <p><?php esc_html_e("Create a new Woocommerce percentage or fixed discount coupon for your users. You can also customize the targeting on a coupon level and it's active dates from one plugin!", 'coupon-x'); ?></p>
                        <span class='svg-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none"> <circle cx="31.5" cy="31.5" r="31.5" class="icon-morbox" fill="#C4CED8"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M33.7672 16.1979C34.7625 15.2409 36.3451 15.272 37.3021 16.2672L51.4077 30.9371L37.3648 46.665C36.4453 47.695 34.8649 47.7844 33.835 46.8648C32.805 45.9453 32.7156 44.3649 33.6352 43.335L42.4164 33.5H14C12.6193 33.5 11.5 32.3807 11.5 31C11.5 29.6193 12.6193 28.5 14 28.5H42.1279L33.6979 19.7328C32.7409 18.7375 32.772 17.1549 33.7672 16.1979Z" fill="white"></path> </svg>
                            <button class=' btn-blue btn-selected'><?php esc_html_e('Selected', 'coupon-x'); ?> </button>
                        </span>
                        <?php
                        if (0 === $wc_status) {
                            ?>
                            <div class='cx-wc-missing'>
                            </div>
                            <div class='cx-wc-msg'>
                                <span>
                                    <a href='<?php echo esc_url(admin_url().'plugin-install.php?s=WooCommerce&tab=search&type=term'); ?>'>
                                        <?php esc_html_e('Install WooCommerce', 'coupon-x'); ?>
                                    </a>
                                </span>
                                <span><?php esc_html_e('to use this feature', 'coupon-x'); ?>  </span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="coupon-code-option2 select-wp-exisitng-coupon coupon-type <?php echo esc_attr(1 === $type ? 'active-type' : ''); ?><?php echo esc_attr(0 === $wc_status ? 'disable' : ''); ?>">
                        <div class="coupon-code-option-titlebox">
                            <span><img src="<?php echo esc_url(COUPON_X_URL.'assets/img/Icon2.svg'); ?>"></span>
                            <h4><?php esc_html_e('Use a pre-existing Woocommerce discount coupon', 'coupon-x'); ?></h4>
                        </div>
                        <p><?php esc_html_e('Have an existing Woocommerce coupon? Use it with Coupon X!', 'coupon-x'); ?></p>

                        <span class='svg-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none"> <circle cx="31.5" cy="31.5" r="31.5" class="icon-morbox" fill="#C4CED8"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M33.7672 16.1979C34.7625 15.2409 36.3451 15.272 37.3021 16.2672L51.4077 30.9371L37.3648 46.665C36.4453 47.695 34.8649 47.7844 33.835 46.8648C32.805 45.9453 32.7156 44.3649 33.6352 43.335L42.4164 33.5H14C12.6193 33.5 11.5 32.3807 11.5 31C11.5 29.6193 12.6193 28.5 14 28.5H42.1279L33.6979 19.7328C32.7409 18.7375 32.772 17.1549 33.7672 16.1979Z" fill="white"></path> </svg>
                            <button class=' btn-blue btn-selected'><?php esc_html_e('Selected', 'coupon-x'); ?> </button>
                        </span>
                        <?php
                        if (0 === $wc_status) {
                            ?>
                            <div class='cx-wc-missing'>
                            </div>
                            <div class='cx-wc-msg'>
                                <span>
                                    <a href='<?php echo esc_url(admin_url().'plugin-install.php?s=WooCommerce&tab=search&type=term'); ?>'>
                                    <?php esc_html_e('Install WooCommerce', 'coupon-x'); ?>
                                    </a>
                                </span>
                                <span><?php esc_html_e('to use this feature', 'coupon-x'); ?>  </span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="coupon-code-option3  select-wp-generate-unique-coupon coupon-type <?php echo esc_attr(2 === $type ? 'active-type' : ''); ?><?php echo esc_attr(0 === $wc_status ? 'disable' : ''); ?>">
                        <div class="coupon-code-option-titlebox">
                            <span><img src="<?php echo esc_url(COUPON_X_URL.'assets/img/Icon3.svg'); ?>"></span>
                            <h4><?php esc_html_e('Generate unique Woocommerce coupons for each new visitor', 'coupon-x'); ?></h4>
                        </div>
                        <p><?php esc_html_e('Coupon X will create unique coupons for every new visitor. Coupon X will create many new coupons.', 'coupon-x'); ?></p>
                        <span class='svg-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none"> <circle cx="31.5" cy="31.5" r="31.5" class="icon-morbox" fill="#C4CED8"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M33.7672 16.1979C34.7625 15.2409 36.3451 15.272 37.3021 16.2672L51.4077 30.9371L37.3648 46.665C36.4453 47.695 34.8649 47.7844 33.835 46.8648C32.805 45.9453 32.7156 44.3649 33.6352 43.335L42.4164 33.5H14C12.6193 33.5 11.5 32.3807 11.5 31C11.5 29.6193 12.6193 28.5 14 28.5H42.1279L33.6979 19.7328C32.7409 18.7375 32.772 17.1549 33.7672 16.1979Z" fill="white"></path> </svg>
                            <button class=' btn-blue btn-selected'><?php esc_html_e('Selected', 'coupon-x'); ?> </button>
                        </span>
                        <?php
                        if (0 === $wc_status) {
                            ?>
                            <div class='cx-wc-missing'>
                            </div>
                            <div class='cx-wc-msg'>
                                <span>
                                    <a href='<?php echo esc_url(admin_url().'plugin-install.php?s=WooCommerce&tab=search&type=term'); ?>'>
                                        <?php esc_html_e('Install WooCommerce', 'coupon-x'); ?>
                                    </a>
                                </span>
                                <span><?php esc_html_e('to use this feature', 'coupon-x'); ?>  </span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    if (1 === $wc_status) {
                        ?>
                        <div class="coupon-code-option4  select-no-coupon-code coupon-type <?php echo esc_attr(4 === $type ? 'active-type' : ''); ?>">
                            <div class="coupon-code-option-titlebox">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#000" style='width:60%; float:left'> <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/> </svg>
                                </span>
                                <h4><?php esc_html_e("Announcement Pop up - don't show a coupon code", 'coupon-x'); ?></h4>
                            </div>
                            <p><?php esc_html_e("Don't want to show coupons? Use the widget for only collecting emails, showing announcements, or showing promotional offers via attention-grabbing widget pop-ups!", 'coupon-x'); ?></p>
                            <span class='svg-icon'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none"> <circle cx="31.5" cy="31.5" r="31.5" class="icon-morbox" fill="#C4CED8"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M33.7672 16.1979C34.7625 15.2409 36.3451 15.272 37.3021 16.2672L51.4077 30.9371L37.3648 46.665C36.4453 47.695 34.8649 47.7844 33.835 46.8648C32.805 45.9453 32.7156 44.3649 33.6352 43.335L42.4164 33.5H14C12.6193 33.5 11.5 32.3807 11.5 31C11.5 29.6193 12.6193 28.5 14 28.5H42.1279L33.6979 19.7328C32.7409 18.7375 32.772 17.1549 33.7672 16.1979Z" fill="white"></path> </svg>
                                <button class=' btn-blue btn-selected'><?php esc_html_e('Selected', 'coupon-x'); ?> </button>
                            </span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class='existing-coupon <?php echo esc_attr(1 !== $type ? 'hide' : ''); ?>'>
            <?php $this->existing_coupon_code($settings); ?>
        </div>
        <div class='unique-coupon <?php echo esc_attr(2 === $type || 3 === $type ? '' : 'hide'); ?>'>
            <?php $this->unique_coupon_code($settings); ?>
        </div>
        <?php

    }//end render_coupon_design()


    /**
     * Existing coupon code listing dialog
     *
     * @param : $settings array of widget settings.
     */
    public function existing_coupon_code($settings)
    {
        $existing_coupon = $settings['ex_coupon']['coupon'];
        ?>
        <div id="couponapp-wp-coupon-codes" class="couponapp-conversation-data">
            <div class='existing-inner-wrap'>
                <div class='existing-coupon-form'>
                    <p>
                        <?php esc_html_e('Please select one of your wp discount codes (you can create a new discount code in your Discounts page)', 'coupon-x'); ?>
                    </p>
                    <div id="search-wp-coupon-codes-data">
                        <span class="search-svg">
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true"><path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414z"></path></svg>
                        </span>
                        <input type="text" id="search-wp-coupon-codes-text" name="search-wp-coupon-codes-text"
                               placeholder="<?php esc_attr_e('Search existing coupon code', 'coupon-x'); ?>"
                               autocomplete="off"/>
                    </div>
                    <div class="coupon-details-table">
                        <?php
                        // Get a list of existing coupon codes.
//                        $coupons = get_posts(
//                            [
//                                'post_type'      => 'shop_coupon',
//                                'post_status'    => 'publish',
//                                'posts_per_page' => -1,
//                            ]
//                        );

                        global $wpdb;
                        $db_prefix = $wpdb->prefix;
                        $time = time();

                        $query = "SELECT {$db_prefix}posts.*
                            FROM {$db_prefix}posts
                            INNER JOIN {$db_prefix}postmeta
                            ON ( {$db_prefix}posts.ID = {$db_prefix}postmeta.post_id )
                            WHERE 1=1
                            AND ( ( {$db_prefix}postmeta.meta_key = 'date_expires'
                            AND CAST({$db_prefix}postmeta.meta_value AS SIGNED) >= '".$time."' )
                            OR ( {$db_prefix}postmeta.meta_key = 'date_expires'
                            AND {$db_prefix}postmeta.meta_value IS NULL )
                            OR ( {$db_prefix}postmeta.meta_key = 'date_expires'
                            AND {$db_prefix}postmeta.meta_value = '' ) )
                            AND {$db_prefix}posts.post_type = 'shop_coupon'
                            AND (({$db_prefix}posts.post_status = 'publish'))
                            GROUP BY {$db_prefix}posts.ID
                            ORDER BY {$db_prefix}posts.post_title ASC";

                        // Get the coupons using get_posts
                        $coupons = $wpdb->get_results($query);
                        ?>
                        <table class='tbl-coupons'>
                            <?php
                            if (is_array($coupons) && count($coupons) > 0) {
                                ?>
                                <thead>
                                <th></th>
                                <th><?php esc_html_e('Coupon code', 'coupon-x'); ?> </th>
                                <th><?php esc_html_e('Coupon type', 'coupon-x'); ?> </th>
                                <th><?php esc_html_e('Coupon value', 'coupon-x'); ?> </th>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($coupons as $coupon) {
                                    $id     = $coupon->ID;
                                    $row_id = 'td-'.$id;
                                    ?>
                                    <tr>
                                        <td>
                                            <input type='radio' id='<?php echo esc_attr($row_id); ?>'
                                                   name='cx_settings[ex_coupon][coupon]'
                                                   value='<?php echo esc_attr($id); ?>' <?php echo checked($id, $existing_coupon, false); ?>
                                                   class='ex-coupon'
                                                   data-code='<?php echo esc_attr($coupon->post_title); ?>'/>
                                        </td>
                                        <td>
                                            <label for='<?php echo esc_attr($row_id); ?>' class="coupon-text">
                                                <?php echo esc_attr($coupon->post_title); ?>
                                            </label>
                                        </td>
                                        <td>
                                            <?php
                                            $discount_type = get_post_meta($id, 'discount_type', true);
                                            if ('percent' === $discount_type) {
                                                echo esc_html__('Percentage discount', 'coupon-x');
                                            } else {
                                                echo esc_html__('Fixed cart discount', 'coupon-x');
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo esc_attr(get_post_meta($id, 'coupon_amount', true));
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }//end foreach
                                ?>
                                </tbody>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan=4>
                                        <?php esc_html_e('No coupon codes found', 'coupon-x'); ?>
                                    </td>
                                </tr>
                                <?php
                            }//end if
                            ?>

                        </table>
                    </div>
                    <div class="no-coupon-found">No results are found</div>
                    <div id="wp-coupon-codes-data-loading" class='hide'>
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style="width:150px; height:150px;"><path fill="#000" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"> <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform> </path></svg>
                    </div>
                </div>
                <p class='hide ex-error'><?php esc_attr_e('Please select one coupon code from the list', 'coupon-x'); ?> </p>
            </div>
        </div>
        <?php

    }//end existing_coupon_code()


    /**
     * Unique coupon code
     *
     * @param : $settings array of widget settings.
     */
    public function unique_coupon_code($settings)
    {
        $type     = (int) $settings['popup']['coupon_type'];
        $settings = $settings['unique_coupon'];

        ?>
        <!-- Generate Unique wp Coupon Code -->
        <div id="couponapp-wp-unique-coupon-code" class="couponapp-conversation-data couponapp-wp-unique-coupon-code">
            <div class='unique-coupon-div'>
                <p class='hide'>
                    <?php esc_html_e('Coupon X will create a new coupon code for each store visitor. If you want to show the same coupon code for all your visitors, please', 'coupon-x'); ?>
                    <strong><a href="#"
                               class="select-wp-exisitng-coupon"><?php esc_html_e('select an existing code', 'coupon-x'); ?></a>
                    </strong><?php esc_html_e(' or ', 'coupon-x'); ?><strong><a href="#"
                                                                                class="custom-coupon-code"><?php esc_html_e('create a new coupon code', 'coupon-x'); ?></a></strong>
                </p>
                <div class="unique-coupon-code-wrap discount-code-wrap <?php echo esc_attr(3 !== $type ? 'hide' : ''); ?>">
                    <label for="discount-code">
                        <?php esc_html_e('Discount Code', 'coupon-x'); ?>
                    </label>
                    <input type="text" id="discount-code" class="discount-code"
                           placeholder="<?php echo esc_attr__('Discount name', 'coupon-x'); ?>"
                           name="cx_settings[unique_coupon][discount_code]"
                           value="<?php echo esc_attr($settings['discount_code']); ?>" step="any"/>
                    <p class="discount_code_error hide" style="color:#FF0000;">
                        <?php esc_html_e('Please fill out the Discount code value', 'coupon-x'); ?>
                    </p>
                </div>
                <div class="unique-coupon-code-wrap">
                    <h3><?php esc_html_e('Type', 'coupon-x'); ?></h3>
                    <ul>
                        <li>
                            <label>
                                <input type="radio" class="discount_type_percentage"
                                       name="cx_settings[unique_coupon][discount_type]"
                                       value="percent" <?php echo checked('percent', $settings['discount_type'], false); ?> />
                                <?php esc_html_e('Percentage', 'coupon-x'); ?>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" class="discount_type_fixed"
                                       name="cx_settings[unique_coupon][discount_type]"
                                       value="fixed" <?php echo checked('fixed', $settings['discount_type'], false); ?> />
                                <?php esc_html_e('Fixed amount', 'coupon-x'); ?>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="unique-coupon-code-wrap">
                    <h3><?php esc_html_e('Value', 'coupon-x'); ?></h3>
                    <label for="discount-value">
                        <?php esc_html_e('Discount value', 'coupon-x'); ?>
                    </label>
                    <input type="number" id="discount-value" class="discount-value" placeholder=""
                           name="cx_settings[unique_coupon][discount_value]"
                           value="<?php echo esc_attr($settings['discount_value']); ?>" step="any" min="1"/>
                    <p class="discount_value_error hide" style="color:#FF0000;">
                        <?php esc_html_e('Please fill out the Discount value field', 'coupon-x'); ?>
                    </p>
                </div>
                <?php
                $freeShipping = isset($settings['free_shipping']) ? $settings['free_shipping'] : 0;
                ?>
                <div class="unique-coupon-code-wrap">
                    <h3><?php esc_html_e('Free Shipping', 'coupon-x'); ?></h3>
                    <div class='row'>
                        <div class='row-elements full mb-0'>
                            <label for="cx_free_shipping">
                                <input type="hidden" name="cx_settings[unique_coupon][free_shipping]" value="0">
                                <input id="cx_free_shipping" type='checkbox' name='cx_settings[unique_coupon][free_shipping]' value='1' <?php echo checked($freeShipping, 1); ?> class='coupon-free-shipping'>
                                <?php esc_html_e('Allow free shipping', 'coupon-x'); ?>
                                <span class="img-tooltip">
                                    <span class="dashicons dashicons-editor-help"></span>
                                    <span class="tooltiptext">
                                        <?php printf( __( 'A <a href="%s" target="_blank">free shipping method</a> must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).', 'coupon-x' ), 'https://docs.woocommerce.com/document/free-shipping/' ) ?>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                $applies_to          = [
                    'order'       => esc_html__('All Products', 'coupon-x'),
                    'collections' => esc_html__('Specific collections', 'coupon-x'),
                    'products'    => esc_html__('Specific products', 'coupon-x'),
                ];
                $collections = get_terms(
                    [
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                    ]
                );
                $products = get_posts(
                    [
                        'post_type'   => 'product',
                        'post_status' => 'publish',
                        'numberposts' => -1,
                    ]
                );
                $applies_to_products = isset($settings['products']) ? $settings['products'] : [];
                $applies_to_collections = isset($settings['cats']) ? $settings['cats'] : [];
                ?>
                <div class="unique-coupon-code-wrap">
                    <h3><?php esc_html_e('Applies to', 'coupon-x'); ?></h3>
                    <ul class="discount-applies-to">
                        <?php
                        foreach ($applies_to as $key => $val) {
                            ?>
                            <li>
                                <label>
                                    <input type="radio" class="applies_to" name="cx_settings[unique_coupon][applies_to]"
                                           value="<?php echo esc_attr($key); ?>" <?php echo checked($key, $settings['applies_to'], false); ?>/>
                                    <?php echo esc_attr($val); ?>
                                </label>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div class="applies-to-collections <?php echo esc_attr('collections' !== $settings['applies_to'] ? 'hide' : ''); ?>">
                        <select class="cart_collections couponx-select2 applies_to_collections"
                                name="cx_settings[unique_coupon][cats][]" multiple="multiple">
                            <?php
                            if (!empty($collections)) :
                                foreach ($collections as $collection) :
                                    ?>
                                    <option value="<?php echo esc_attr($collection->term_id); ?>"
                                        <?php
                                        if (in_array((string) $collection->term_id, $applies_to_collections, true)) {
                                            echo esc_attr('selected');
                                        }
                                        ?>
                                    ><?php echo esc_attr($collection->name); ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                        <p class="applies_to_collections_error hide" style="color:#FF0000;">
                            <?php esc_html_e('Specific collections  must be added', 'coupon-x'); ?>
                        </p>
                    </div>
                    <div class="applies-to-products <?php echo esc_attr('products' !== $settings['applies_to'] ? 'hide' : ''); ?>">
                        <select class="cart_products couponx-select2 applies_to_products"
                                name="cx_settings[unique_coupon][products][]" multiple="multiple">
                            <?php
                            if (!empty($products)) :
                                foreach ($products as $product) :
                                    ?>
                                    <option value="<?php echo esc_attr($product->ID); ?>"
                                        <?php
                                        if (in_array((string) $product->ID, $applies_to_products, true)) {
                                            echo esc_attr('selected');
                                        }
                                        ?>
                                    ><?php echo esc_attr($product->post_title); ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                        <p class="applies_to_products_error hide" style="color:#FF0000;">
                            <?php esc_html_e('Specific products must be added', 'coupon-x'); ?>
                        </p>
                    </div>
                </div>
                <div class="unique-coupon-code-wrap">
                    <h3><?php esc_html_e('Minimum requirements', 'coupon-x'); ?></h3>
                    <select name="cx_settings[unique_coupon][min_req]" class="min-req">
                        <option value="none" <?php echo selected($settings['min_req'], 'none', false); ?>>
                            <?php esc_html_e('None', 'coupon-x'); ?>
                        </option>
                        <option value="subtotal" <?php echo selected($settings['min_req'], 'subtotal', false); ?>>
                            <?php esc_html_e('Minimum purchase amount', 'coupon-x'); ?>
                        </option>
                    </select>
                    <div class="discount-min-requirements <?php echo esc_attr('subtotal' !== $settings['min_req'] ? 'hide' : ''); ?>">
                        <br/>&nbsp;
                        <input type="text" id="discount-min-req" class="discount-min-req" placeholder=""
                               name="cx_settings[unique_coupon][min_val]"
                               value="<?php echo esc_attr($settings['min_val']); ?>"/>
                        <?php esc_html_e('Applies to all products.', 'coupon-x'); ?>
                        <p class="min_val_error hide" style="color:#FF0000;">
                            <?php esc_html_e('Please fill out the Minimum purchase amount', 'coupon-x'); ?>
                        </p>
                    </div>
                    <div class="discount-min-qty-items <?php echo 'qty' !== $settings['min_req'] ? 'hide' : ''; ?>">
                        <input type="text" id="discount-value" class="discount-min-req" placeholder=""
                               name="cx_settings[unique_coupon][discount_perqty]"
                               value="<?php echo esc_attr($settings['discount_perqty']); ?>"/>
                        <?php esc_html_e('Applies to all products.', 'coupon-x'); ?>
                    </div>
                </div>
                <?php
                $enable_usage_limits  = isset($settings['enable_usage_limits']) ? (int) $settings['enable_usage_limits'] : 0;
                $enable_user_limit    = isset($settings['enable_user_limit']) ? (int) $settings['enable_user_limit'] : 0;
                $enable_no_item_limit = isset($settings['enable_no_item_limit']) ? (int) $settings['enable_no_item_limit'] : 0;
                $enable_date          = isset($settings['enable_date']) ? (int) $settings['enable_date'] : 0;
                ?>
                <div class="unique-coupon-code-wrap">
                    <h3>
                        <?php esc_html_e('Usage limits', 'coupon-x'); ?>
                        <label class="couponapp-switch">
                            <input type="checkbox" name="cx_settings[unique_coupon][enable_usage_limits]"
                                   value="1" <?php echo checked($enable_usage_limits, 1, false); ?>
                                   class='usage-limit'/>
                            <span class="cx-slider round">
                            <span class="on"><?php esc_html_e('On', 'coupon-x'); ?></span>
                            <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                        </span>
                        </label>
                    </h3>
                    <ul class="enable_usage_limits <?php echo 1 !== $enable_usage_limits ? 'hide' : ''; ?>">
                        <li>
                            <label>
                                <input type="checkbox" name="cx_settings[unique_coupon][enable_no_item_limit]"
                                       value="1" <?php echo checked($enable_no_item_limit, 1, false); ?>
                                       class='enable-item-limit'/>
                                <?php esc_html_e('Limit number of times this discount can be used in total per unique discount code', 'coupon-x'); ?>
                                <span class="icon label-tooltip coupon-tab-design usage-limits"
                                      title="<?php esc_html_e('Control how many times the coupon can be used in total per unique discount code. For example, if you set 5, the user that gets a unique discount code, can use the coupon a maximum of 5 times in total', 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </label>
                            <div class="discount-total-usage-limit <?php echo 1 !== $enable_no_item_limit ? 'hide' : ''; ?>"
                                 style="display: inline-block;width: 100%;">
                                <input type="text" id="discount-value" class="total-usage-limit" placeholder=""
                                       name="cx_settings[unique_coupon][no_item_limit]"
                                       value="<?php echo esc_attr($settings['no_item_limit']); ?>" style="float:left;"/>
                            </div>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" name="cx_settings[unique_coupon][enable_user_limit]"
                                       value="1" <?php echo checked($enable_user_limit, 1, false); ?>/>
                                <?php esc_html_e('Limit to one use per customer', 'coupon-x'); ?>
                                <span class="icon label-tooltip coupon-tab-design perperson"
                                      title="<?php esc_html_e('If a user has already bought something with the coupon, the user cannot use the same coupon more than once', 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="unique-coupon-code-wrap">
                    <h3>
                        <?php esc_html_e('Active dates', 'coupon-x'); ?>
                        <label class="couponapp-switch">
                            <input type="checkbox" name="cx_settings[unique_coupon][enable_date]" value="1"
                                   class='active-dates' <?php echo checked($enable_date, 1, false); ?> />
                            <span class="cx-slider round">
                            <span class="on"><?php esc_html_e('On', 'coupon-x'); ?></span>
                            <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                        </span>
                        </label>

                    </h3>
                    <div class="unique-coupon-code-start-dates <?php echo 1 !== $enable_date ? 'hide' : ''; ?>">
<!--                        <div class="row-elements  half">-->
<!--                            <label>--><?php //esc_html_e('Start date', 'coupon-x'); ?><!--</label>-->
<!--                            <input type="text" name="cx_settings[unique_coupon][start_date]"-->
<!--                                   value="--><?php //echo esc_attr($settings['start_date']); ?><!--"-->
<!--                                   class="coupon-required date-picker ui-datepicker-input-active-st-date active_start_date"/>-->
<!--                        </div>-->
                        <div class="row-elements  half">
                            <label><?php esc_html_e('End date', 'coupon-x'); ?></label>
                            <input type="text" name="cx_settings[unique_coupon][end_date]"
                                   value="<?php echo esc_attr($settings['end_date']); ?>"
                                   class="coupon-required date-picker ui-datepicker-input-active-end-date active_end_date"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }//end unique_coupon_code()


}//end class

