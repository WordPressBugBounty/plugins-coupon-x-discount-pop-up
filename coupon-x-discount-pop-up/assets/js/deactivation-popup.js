(function ($) {
    $(function () {
        var cxPluginSlug = 'coupon-x-discount-pop-up';
        // Code to fire when the DOM is ready.
        $(document).on('click', 'tr[data-slug="' + cxPluginSlug + '"] .deactivate', function (e) {
            e.preventDefault();
            $('.cx-popup-overlay').addClass('cx-active');
            $('body').addClass('cx-hidden');
        });
        $(document).on('click', '.cx-popup-button-close', function () {
            close_popup();
        });
        $(document).on('click', ".cx-serveypanel,tr[data-slug='" + cxPluginSlug + "'] .deactivate", function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            close_popup();
        });
        $('.cx-reason label').on('click', function () {
            $(".cx-hidden-input").hide();
            jQuery(".cx-error-message").remove();
            if ($(this).find('input[type="radio"]').is(':checked')) {
                $(this).closest("li").find('.cx-hidden-input').show();
            }
        });
        $(document).on("keyup", "#cx-deactivation-comment", function(){
            if($.trim($(this).val()) == "") {
                $(".cx-popup-allow-deactivate").attr("disabled", true);
            } else {
                $(".cx-popup-allow-deactivate").attr("disabled", false);
            }
        });
        $('input[type="radio"][name="cx-selected-reason"]').on('click', function (event) {
            $(".cx-popup-allow-deactivate").removeAttr('disabled');
        });
        $(document).on('submit', '#cx-deactivate-form', function (event) {
            event.preventDefault();
            _reason = "";
            if(jQuery.trim(jQuery("#cx-deactivation-comment").val()) == "") {
                jQuery("#alt_plugin").after("<span class='cx-error-message'>Please provide your feedback</span>");
                return false;
            } else {
                _reason = jQuery.trim(jQuery("#cx-deactivation-comment").val());
            }
            jQuery('[name="cx-selected-reason"]:checked').val();
            var email_id = jQuery.trim(jQuery("#cx-deactivation-email_id").val());
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'coupon_x_plugin_deactivate',
                    reason: _reason,
                    email_id: email_id,
                    nonce: cx_data.nonce
                },
                beforeSend: function () {
                    $(".cx-spinner").show();
                    $(".cx-popup-allow-deactivate").attr("disabled", "disabled");
                }
            }).done(function () {
                $(".cx-spinner").hide();
                $(".cx-popup-allow-deactivate").removeAttr("disabled");
                window.location.href = $("tr[data-slug='" + cxPluginSlug + "'] .deactivate a").attr('href');
            });
        });
        $('.cx-popup-skip-feedback').on('click', function (e) {
            window.location.href = $("tr[data-slug='" + cxPluginSlug + "'] .deactivate a").attr('href');
        });
        function close_popup() {
            $('.cx-popup-overlay').removeClass('cx-active');
            $('#cx-deactivate-form').trigger("reset");
            $(".cx-popup-allow-deactivate").attr('disabled', 'disabled');
            $(".cx-reason-input").hide();
            $('body').removeClass('cx-hidden');
            $('.message.error-message').hide();
        }
    });
})(jQuery);