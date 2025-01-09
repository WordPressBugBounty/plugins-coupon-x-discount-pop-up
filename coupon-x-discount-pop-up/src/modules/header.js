import withLayoutChange from "../hoc/with-layout-change";
import withRoute from "../hoc/with-route";
import saveButton from '../components/save-button';
import compose from '../compose';

const $ = window.jQuery;
function headerModule( props ) {

    const $header       = $('.chaty-header');
    const $widgetBody   = $('#cx-widget-body-tab');
    const $channels     = $('#cx-btn-icon-design');
    const $backButton   = $('.back-button');
    const $nextButton   = $('.next-button');
    const $chatyTab     = $('.cx-widget-tab');
    const $stepTitle    = $('#process-step');
    const $currentStep  = $('#current-step');
    const $stepProgress = $('#step-progress');
    const tabList       = ['cx-icon-design', 'cx-choose-coupon', 'cx-pop-up-design', 'cx-triggers-targeting'];
    let activeTab       = Number( props.route.get('step') || 0 );
    $("#wpbody-content").css("padding-top", $header.outerHeight() + 40);

    if( $header.length === 0 || $channels.length === 0 ) return;

    /**
     * on wordpress sidebar change, change the header position
     * @props style = { left: value, top: value, width: value }
     */
    props.onLayoutChange( style => {
        $header.css(style);
        $("#wpbody-content").css("padding-top", $header.outerHeight() + 40);
    })

    let validateStepTwo = function() {
        let hasError = false
        $('.discount_code_error, .applies_to_products_error, .applies_to_collections_error, .min_val_error').addClass('hide');
        $('.ex-error').addClass('hide');
        if(!$(".active-type").length) {
            $('.validation-popup').dialog('open');
            hasError = true;
        }
        if($(".custom-coupon-code").hasClass('active-type') && $("#discount-code").val() == '') {
            $('.discount_code_error').removeClass('hide');
            hasError = true;
        }

        if($(".coupon-code-option2").hasClass('active-type') && !$("input[name='cx_settings[ex_coupon][coupon]']:checked").length) {
            $('.ex-error').removeClass('hide');
            hasError = true;
        }

        let hasCustomCoupon = $(".custom-coupon-code").hasClass('active-type') || $(".coupon-code-option3").hasClass('active-type');
        if(hasCustomCoupon && $(".discount-value").val() == '') {
            $('.discount_value_error').removeClass('hide');
            hasError = true;
        }

        if(hasCustomCoupon && $('.applies_to:checked').val() == 'collections' &&
            $('.cart_collections').next('.select2').find('ul.select2-selection__rendered').find('li').length < 1 ) {
            $('.applies_to_collections_error').removeClass('hide');
            hasError = true;
        }

        if(hasCustomCoupon && $('.applies_to:checked').val() == 'products' &&
            $('.cart_products').next('.select2').find('ul.select2-selection__rendered').find('li').length < 1 ) {
            $('.applies_to_products_error').removeClass('hide');
            hasError = true;
        }

        if(hasCustomCoupon && $('.min-req  option:selected').val() == 'subtotal' && $('.discount-min-req').val() == '' ) {
            hasError = true;
            $('.min_val_error').removeClass('hide');
        }
        return hasError;
    }

    let validateStepThree = function() {
        let hasError = false;
        if($("#popup_type").val() == '') {
            $('.layout-validation').dialog('open');
            hasError = true;
        }
        return hasError;
    }

    /**
     * Show tab
     */
    const showTab = index => {

        if( index < tabList.length && index >= 0 ) {
            console.log(`activeTab: ${activeTab}`)
            console.log(index)
            let hasError = false;
            if(activeTab == 1 && (index == 2 || index ==3)) { // Check for
                if(validateStepTwo()) {
                    hasError = true;
                }
            }

            if(activeTab == 2 && index ==3) { // Check for
                if(validateStepThree()) {
                    hasError = true;
                }
            }

            if(hasError) {
                return false
            }

            activeTab = index;
            // active the tab content
            $('.social-channel-tabs').removeClass('active');
            $(`#${tabList[index]}`).addClass('active');

            //active tab label or header
            $('.chaty-tab').removeClass('active completed').each(function(){
                $(this).addClass('completed');
                if( this.dataset.tabId === tabList[index] ) {
                    $(this).addClass('active');
                    return false;
                }
            });

            if(activeTab == 2) {
                if($('#cx-pop-up-design .popup-wrapper').hasClass('hide')) {
                    $("#cx-pop-up-design").addClass('has-no-popup');
                } else {
                    $("#cx-pop-up-design").removeClass('has-no-popup');
                }
            }

            $("#current_step").val(index);

            $currentStep.text(`${index+1}/4`)
            $stepTitle.text(setStepTitle(index))

            //next and back button show/hide
            $backButton.removeClass('cht-disable');
            $nextButton.removeClass('cht-disable');
            const $progress = strokeFullProgress() - ((index+1) / 4) * strokeFullProgress();
            $stepProgress.css({strokeDashoffset: $progress})

            if( index <= 0 ) {
                $backButton.addClass('cht-disable');
            }

            if( index >= (tabList.length - 1) ) {
                $nextButton.addClass('cht-disable');
            }

            $chatyTab.removeClass(['step-0','step-1','step-2','step-3'])
            $chatyTab.addClass(`step-${index}`)
        }
    }

    function strokeFullProgress() {
        return 46.5 * 2 * Math.PI
    }

    const setStepTitle = index => {
        if(index == 0) {
            return "Icon Design";
        } else if(index == 1) {
            return "Choose Coupon";
        } else if(index == 2) {
            return "Pop up Design";
        }
        return "Trigger & Targeting";
    }

    /**
     * bring content into view
     */
    showTab( activeTab )
    $header.find('.chaty-tab').on('click', function(){
        // show tab setter method takes only the index of the tab
        showTab( tabList.indexOf(this.dataset.tabId) );
        $widgetBody.removeClass(["step-0", "step-1", "step-2", "step-3"]);
        $widgetBody.addClass('step-'+tabList.indexOf(this.dataset.tabId))
        if( $header.css('position') === 'fixed' ) {
            window.scrollTo({
                top: ( innerWidth > 768 ? $header.outerHeight() : 0 ) + 32 + 'px',
                left: 0,
                behavior: 'smooth'
            });
        }
    })

    /**
     * Next button handler
     */
    $nextButton.on('click', ()=>{
        showTab( activeTab + 1 );
    })
    /**
     * Prev button handler
     */
    $backButton.on('click', () => {
        showTab( activeTab - 1 );
    })

    // save button handler
    saveButton();
}

export default compose(
    withLayoutChange(),
    withRoute()
)( headerModule )