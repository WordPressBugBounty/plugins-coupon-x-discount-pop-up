<?php
/**
 * Create Coupon- Tab design
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create new widget - Tab design
 */
class Cx_Widget_Tab
{


    /**
     * Constructor function
     *
     * @param settings $settings array of widget settings.
     */
    public function __construct($settings)
    {
        $this->render_tab_design($settings);

    }//end __construct()


    /**
     * Renders Tab design tab html
     *
     * @param settings $settings array of widget settings.
     */
    public function render_tab_design($settings)
    {

        $coupon_tab_icon = Cx_Helper::coupon_tab_icon();
        $widget_title = $settings['widget_title'];
        $number = get_option('cx_total_widget', 1);

        ?>
        <div class='cx-tab'>
            <div class='tab-settings'>
                <h3><?php esc_html_e('Icon design', 'coupon-x'); ?></h3>
                <div class="row">
                    <div class="row-elements full d-flex">
                        <label><?php esc_html_e('Show icon', 'coupon-x'); ?></label>
                        <label class='couponapp-switch'>
                            <input type="hidden" name="cx_settings[tab][show_icon]" value="0">
                            <input type='checkbox' name='cx_settings[tab][show_icon]' class='show-icon'
                                   value='1' <?php echo checked(esc_attr($settings['show_icon']), 1, false); ?>>
                            <span class="cx-slider round">
                                <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="show-icon-info <?php echo ($settings['show_icon'] == 1) ? "" : "active" ?>">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 15V11M11 7H11.01M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Hide the icon to display the pop up based on the triggers you set in Step 4
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label>
                            <?php esc_html_e('Name Your Widget', 'coupon-x'); ?>
                        </label>
                        <input type='text' name='cx_settings[tab][widget_title]' class='input-element'
                               placeholder="<?php echo esc_html__("What's the your widget's name?", 'coupon-x'); ?>"
                               value="<?php echo esc_attr($widget_title); ?>">
                    </div>
                </div>
                <div class="show-tab-settings <?php echo ($settings['show_icon'] == 1) ? '' : 'hide'; ?>">
                    <div class='row'>
                        <div class='row-elements half color-row'>
                            <?php echo Cx_Helper::color_picker_template('Icon background color', 'tab_color', 'jsspan tab-clr', 'cx_settings[tab][tab_color]', $settings['tab_color']) ?>
                        </div>
                        <div class='row-elements half color-row'>
                            <?php echo Cx_Helper::color_picker_template('Icon Color', 'icon_color', 'jsspan tab-clr', 'cx_settings[tab][icon_color]', $settings['icon_color']) ?>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements'>
                            <label>
                                <?php esc_html_e('Icon', 'coupon-x'); ?>
                            </label>
                            <ul class="cx-tab-icon">
                                <?php
                                $tab_icon = $settings['tab_icon'];
                                foreach ($coupon_tab_icon as $key => $value) {
                                    $checked = $tab_icon === $key ? 'checked' : '';
                                    ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="cx_settings[tab][tab_icon]"
                                                   value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($checked); ?>
                                                   class="input-field-radio tab-icon">
                                            <span id="<?php echo esc_attr($key); ?>">
                                            <?php echo wp_kses($value, Cx_Helper::get_svg_ruleset()); ?>
                                        </span>
                                        </label>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li>
                                    <span class="seperator"></span>
                                </li>
                                <li>
                                    <label class="upload">
                                        <!-- <input id="tab-custom-icon-upload" type="file" class="fileClass" name="cx_settings[tab][tab_custom_icon]" class="input-field-radio" accept="image/*" /> -->
                                        <input id="tab-custom-icon-option" type="radio"
                                               name="cx_settings[tab][tab_icon]" value="custom"
                                               class="input-field-radio tab-icon"
                                            <?php
                                            if ('custom' === $tab_icon) {
                                                echo esc_attr('checked');
                                            }
                                            ?>
                                        />
                                        <input type="hidden" name="cx_settings[tab][tab_custom_icon]"
                                               id="tab_custom_icon"
                                               value="<?php echo esc_attr($settings['tab_custom_icon']); ?>"/>
                                        <span id="tab-custom-icon">                     
                                          <?php
                                          echo Cx_Helper::custom_tab_icon();
                                          ?>

                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Icon background shape', 'coupon-x'); ?>
                            </label>
                            <select name='cx_settings[tab][tab_shape]' class='input-element tab-shape'>
                                <option value=''>
                                    <?php esc_html_e('--- Select Icon background shape ---', 'coupon-x'); ?>
                                </option>
                                <?php
                                $tab_shapes = [
                                    'circle' => esc_html__('Circle', 'coupon-x'),
                                    'square' => esc_html__('Square', 'coupon-x'),
                                    'leaf' => esc_html__('Leaf', 'coupon-x'),
                                    'hexagon' => esc_html__('Hexagon', 'coupon-x'),
                                ];
                                $shape = $settings['tab_shape'];
                                foreach ($tab_shapes as $key => $value) {
                                    $selected = $shape === $key ? 'selected' : '';
                                    ?>
                                    <option value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($selected); ?>>
                                        <?php echo esc_attr($value); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='row mx-height-110'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Position', 'coupon-x'); ?>
                            </label>
                            <div>
                                <ul class='custom-list'>
                                    <?php
                                    $positions = [
                                        'left' => esc_html__('Left', 'coupon-x'),
                                        'right' => esc_html__('Right', 'coupon-x'),
                                        'custom' => esc_html__('Custom', 'coupon-x'),
                                    ];
                                    $pos = $settings['position'];

                                    foreach ($positions as $key => $value) {
                                        $checked = $key === $pos ? 'checked' : '';
                                        ?>
                                        <li>
                                            <label>
                                                <input type='radio' name='cx_settings[tab][position]' class='custom-pos'
                                                       value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($checked); ?>>
                                                <?php echo esc_attr($value); ?>
                                            </label>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='row custom-position first <?php echo esc_attr('custom' !== $settings['position'] ? 'hide' : ''); ?>'>
                        <div class='row-elements'>
                            <label>
                                <?php esc_html_e('Slide Selection', 'coupon-x'); ?>
                            </label>
                            <div>
                                <ul class='custom-list'>
                                    <?php
                                    $custom_pos = $settings['custom_position'];
                                    $custom_positions = [
                                        'left' => esc_html__('Left', 'coupon-x'),
                                        'right' => esc_html__('Right', 'coupon-x'),
                                    ];

                                    foreach ($custom_positions as $key => $value) {
                                        $checked = $key === $custom_pos ? 'checked' : '';
                                        ?>
                                        <li>
                                            <label>
                                                <input type='radio' name='cx_settings[tab][custom_position]'
                                                       value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($checked); ?>
                                                       class='custom_position'>
                                                <?php echo esc_attr($value); ?>
                                            </label>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='row  custom-position last <?php echo esc_attr('custom' !== $settings['position'] ? 'hide' : ''); ?>'>
                        <div class='row-elements half'>
                            <label>
                                <?php esc_html_e('Bottom Spacing (px)', 'coupon-x'); ?>
                            </label>
                            <input type='number' name='cx_settings[tab][bottom_spacing]'
                                   value='<?php echo esc_attr($settings['bottom_spacing']); ?>'
                                   class='input-element num bottom-spacing'>
                        </div>
                        <div class='row-elements half'>
                            <label>
                                <?php esc_html_e('Side Spacing (px)', 'coupon-x'); ?>
                            </label>
                            <input type='number' name='cx_settings[tab][side_spacing]'
                                   value='<?php echo esc_attr($settings['side_spacing']); ?>'
                                   class='input-element num side-spacing'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements'>
                            <label>
                                <?php esc_html_e('Icon background size (px)', 'coupon-x'); ?>
                            </label>
                            <input type='number' name='cx_settings[tab][tab_size]'
                                   value='<?php echo esc_attr($settings['tab_size']); ?>' min='20'
                                   class='input-element num tab-size'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Call to action', 'coupon-x'); ?>
                            </label>
                            <input type='text' name='cx_settings[tab][call_action]'
                                   value='<?php echo esc_attr($settings['call_action']); ?>'
                                   class='input-element call-action'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements half color-row'>
                            <?php echo Cx_Helper::color_picker_template('Call to action color', 'action_color', 'jsspan tab-clr', 'cx_settings[tab][action_color]', $settings['action_color']) ?>
                        </div>
                        <div class='row-elements half extra color-row'>
                            <?php echo Cx_Helper::color_picker_template('Call to action background', 'action_bgcolor', 'jsspan tab-clr', 'cx_settings[tab][action_bgcolor]', $settings['action_bgcolor']) ?>
                        </div>
                    </div>
                    <div class='row mx-height-110'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Show CTA', 'coupon-x'); ?>
                            </label>
                            <ul class='custom-list'>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_cta]'
                                               value='1' <?php echo checked(esc_attr($settings['show_cta']), 1, false); ?>>
                                        <?php esc_html_e('Always', 'coupon-x'); ?>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_cta]'
                                               value='2' <?php echo checked(esc_attr($settings['show_cta']), 2, false); ?>>
                                        <?php esc_html_e('Until 1st click/hover', 'coupon-x'); ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='row mx-height-110'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Show Icon', 'coupon-x'); ?>
                            </label>
                            <ul class='custom-list'>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_tab]'
                                               value='1' <?php echo checked(esc_attr($settings['show_tab']), 1, false); ?>>
                                        <?php esc_html_e('Always', 'coupon-x'); ?>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_tab]'
                                               value='2' <?php echo checked(esc_attr($settings['show_tab']), 2, false); ?>>
                                        <?php esc_html_e('Hide after conversion', 'coupon-x'); ?>

                                        <span class="icon label-tooltip coupon-tab-design"
                                              title="<?php esc_html_e('Hide the icon after a user has converted, which means copied the coupon code or submitted their email.', 'coupon-x'); ?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span>
                                    </label>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label>
                            <span class="icon label-tooltip coupon-tab-design"
                                  title="<?php esc_html_e("Increase your click-rate by displaying a pending messages icon near your Coupon widget to let your visitors know that you're waiting for them to contact you.", 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                                <?php esc_html_e('Pending messages', 'coupon-x'); ?>
                            </label>
                            <label class='couponapp-switch'>
                                <input type='checkbox' name='cx_settings[tab][msg]' class='pmsg'
                                       value='1' <?php echo checked(esc_attr($settings['msg']), 1, false); ?>>
                                <span class="cx-slider round">
                                <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                            </span>
                            </label>
                        </div>
                    </div>
                    <div class='pending-msg <?php echo esc_attr(1 === (int)$settings['msg'] ? '' : 'hide'); ?> '>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Number of messages', 'coupon-x'); ?>
                            </label>
                            <input type='number' name='cx_settings[tab][no_msg]' min-value='1'
                                   value='<?php echo esc_attr($settings['no_msg']); ?>' min='1'
                                   class='no_msg input-element'>
                        </div>
                        <div class="row">
                            <div class='row-elements half color-row'>
                                <?php echo Cx_Helper::color_picker_template('Number color', 'no_color', 'jsspan tab-clr', 'cx_settings[tab][no_color]', $settings['no_color']) ?>
                            </div>
                            <div class='row-elements half color-row'>
                                <?php echo Cx_Helper::color_picker_template('Background color', 'no_bgcolor', 'jsspan tab-clr', 'cx_settings[tab][no_bgcolor]', $settings['no_bgcolor']) ?>
                            </div>
                        </div>
                    </div>
                    <div class='row-elements full'>
                        <label>
                            <?php esc_html_e('Font Family', 'coupon-x'); ?>
                        </label>
                        <select name='cx_settings[tab][font]' class='fonts-input input-element'>
                            <?php
                            $fnt = $settings['font'];
                            $fonts = Cx_Helper::couponx_fonts();
                            foreach ($fonts as $key => $val) {
                                ?>
                                <optgroup label="<?php echo esc_attr($key); ?>">
                                    <?php
                                    foreach ($val as $font) {
                                        $font_value = str_replace(' ', '_', $key) . '-' . str_replace(' ', '_', $font);
                                        ?>
                                        <option value='<?php echo esc_attr($font_value); ?>' <?php echo selected($fnt, $font_value, false); ?>>
                                            <?php echo esc_attr($font); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class='row'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Attention Effect', 'coupon-x'); ?>
                            </label>
                            <select name='cx_settings[tab][effect]' class='input-element animation-effect'>
                                <option value='none'>
                                    <?php esc_html_e('None', 'coupon-x'); ?>
                                </option>
                                <?php
                                $effect = $settings['effect'];
                                $tab_shapes = [
                                    'flash' => esc_html__('Flash', 'coupon-x'),
                                    'shake' => esc_html__('Shake', 'coupon-x'),
                                    'swing' => esc_html__('Swing', 'coupon-x'),
                                    'tada' => esc_html__('Tada', 'coupon-x'),
                                    'heartbeat' => esc_html__('Heartbeat', 'coupon-x'),
                                    'wobble' => esc_html__('Wobble', 'coupon-x'),
                                ];
                                foreach ($tab_shapes as $key => $value) {
                                    ?>
                                    <option value='<?php echo esc_attr($key); ?>' <?php echo selected($effect, $key, false); ?>>
                                        <?php echo esc_attr($value); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php $showAttention = isset($settings['show_attention']) ? $settings['show_attention'] : "2"; ?>
                    <div class='row show-attention-effect <?php echo ($settings['effect'] == "none") ? 'hide' : '' ?>'>
                        <div class='row-elements full'>
                            <label>
                                <?php esc_html_e('Show Attention Effect', 'coupon-x'); ?>
                            </label>
                            <ul class='custom-list'>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_attention]'
                                               value='1' <?php echo checked(esc_attr($showAttention), 1, false); ?>>
                                        <?php esc_html_e('Always', 'coupon-x'); ?>
                                        <span class="icon label-tooltip coupon-tab-design"
                                              title="<?php esc_html_e('Display the attention effect at all times, even if the visitor has already clicked on the icon.', 'coupon-x'); ?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type='radio' name='cx_settings[tab][show_attention]'
                                               value='2' <?php echo checked(esc_attr($showAttention), 2, false); ?>>
                                        <?php esc_html_e('Until 1st click', 'coupon-x'); ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $this->render_tab_preview($settings);
            ?>
        </div>
        <?php

    }//end render_tab_design()


    /**
     * Renders Tab design preview html
     *
     * @param settings $settings array of widget settings.
     */
    public function render_tab_preview($settings)
    {

        // Generate css from settings and load it in style tag.
        $css = Cx_Helper::get_tab_css($settings);
        $coupon_tab_icon = Cx_Helper::coupon_tab_icon();
        $couponapp_class = [];
        // Create an array of all applicable class and assign it to parent div.
        if ('custom' === $settings['position']) {
            $couponapp_class[] = 'couponapp-position-' . $settings['custom_position'];
        } else {
            $couponapp_class[] = 'couponapp-position-' . $settings['position'];
        }

        $couponapp_class[] = 'couponapp-tab-shape-' . $settings['tab_shape'];
        $couponapp_class[] = 'couponapp-' . $settings['effect'] . '-animation';

        $couponapp_classes = join(' ', $couponapp_class);
        ?>
        <style>
            <?php echo esc_attr($css); ?>
        </style>
        <div class="mobile-preview-btn">
            <a class="btn-previewbtn" href="#">
                <?php esc_html_e('Preview', 'coupon-x'); ?>
            </a>
        </div>
        <div class='tab-preview'>
            <div class='preview-containter'>
                <label class='preview-lbl'>
                    <?php esc_html_e('Preview', 'coupon-x'); ?>
                </label>
                <div class='preview-box'>
                    <a href="#" class="coupon-preview-close hide">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px"
                             version="1.1"
                             style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                             viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path class="fil0"
                                  d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                        </svg>
                    </a>
                    <?php $showIcon = isset($settings['show_icon']) ? $settings['show_icon'] : 1; ?>
                    <div class="tab-box <?php echo esc_attr($couponapp_classes); ?> <?php echo ($showIcon == 1) ? "" : "hide"; ?>">
                        <div class="tab-box-wrap">
                            <div class="tab-text">
                                <?php echo esc_attr($settings['call_action']); ?>
                            </div>
                            <span class="tab-tooltip"
                                  data-title="<?php esc_attr_e('Pop up preview will be displayed in the "Pop Up Design" step', 'coupon-x'); ?>"></span>
                            <div class="tab-icon">
                            <span class='icon-img'>
                                <?php if ('hexagon' === $settings['tab_shape']) : ?>
                                    <span class="after hexagon-after">
                                                        </span>
                                    <span class="before hexagon-before">
                                                        </span>
                                <?php endif; ?>
                                <?php if ('custom' === $settings['tab_icon'] && '' !== $settings['tab_custom_icon']) : ?>
                                    <img class="custom-tab-img"
                                         src="<?php echo esc_url($settings['tab_custom_icon']); ?>"/>
                                <?php
                                elseif ('custom' === $settings['tab_icon'] && '' === $settings['tab_custom_icon']) :
                                    $customFile = '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" r="18"></circle><path d="M24.7528 25.463H20.8737H19.8292H19.6036V20.2599H21.3053C21.7368 20.2599 21.9918 19.7695 21.7368 19.4164L18.4266 14.8361C18.2158 14.5419 17.7793 14.5419 17.5685 14.8361L14.2583 19.4164C14.0033 19.7695 14.2534 20.2599 14.6898 20.2599H16.3915V25.463H16.1659H15.1214H10.6244C8.04986 25.3208 6 22.913 6 20.304C6 18.5043 6.97589 16.935 8.42256 16.0866C8.29015 15.7286 8.2215 15.3461 8.2215 14.944C8.2215 13.105 9.7074 11.6191 11.5464 11.6191C11.9436 11.6191 12.3261 11.6878 12.6841 11.8202C13.7483 9.56436 16.0433 8 18.7111 8C22.1635 8.0049 25.0078 10.6481 25.3314 14.0172C27.9845 14.4732 30 16.9301 30 19.7107C30 22.6825 27.6853 25.257 24.7528 25.463Z" fill="rgb(96, 93, 236)"></path></svg>';
                                    ?>
                                    <?php echo wp_kses($coupon_tab_icon['tab-icon-1'], Cx_Helper::get_svg_ruleset()); ?>
                                <?php
                                else :
                                    echo wp_kses($coupon_tab_icon[$settings['tab_icon']], Cx_Helper::get_svg_ruleset());
                                endif;
                                ?>
                            </span>
                                <span id='coupon-pending-message'
                                      class="coupon-pending-message <?php echo esc_attr('1' === $settings['msg'] ? '' : 'hide'); ?>">
                                <?php echo esc_attr($settings['no_msg']); ?>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="show-icon-notice <?php echo ($showIcon == 1) ? "" : "active"; ?>"><?php esc_html_e('The Icon is currently hidden. If you want to display it, enable the "Show icon" option.', 'coupon-x') ?></div>
            </div>
        </div>
        <?php

    }//end render_tab_preview()


}//end class

