jQuery(document).ready(function($) {


	let updatecount = 0,
	is_updatevisitor = 0,
	is_clipboard = 0,
	clipboard,
	myReferer='',
	unique_code='',
	is_page_scroll_index = -1;


	let createCouponappCookie = function(name, value, days){
		let expires = "";
		if (days) {
			let expiry = new Date();
			expiry.setTime(expiry.getTime()+(days*24*60*60*1000));
			let expires = "; expires=" + expiry.toGMTString();
		} 
		document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/; SameSite=Lax";
	}

	let readCouponappCookie = function(name){
		let nameEQ = escape(name) + "=";
		let ca = document.cookie.split(';');
		for (let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ')
			c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0)
			return unescape(c.substring(nameEQ.length, c.length));
		}
		return null;
	}

    let updatecouponstats = function( widget_id, key ) {
    	url = cx_data.url;
    
    	$.ajax( {
    		url   :cx_data.url,
	    	data : {
	    		'nonce' : cx_data.nonce,
	    		'id'     : widget_id,
	    		'key'    : key,
				action: 'update_widget_stats'
	    	},
			type: 'post',
			dataType: 'json',
	    	success:function( response ) {
	    		console.log( response );
	    	}
	    });
    }

    let createCouponUniqueCode = function(  widget_id ) {
		
		unique_code = readCouponappCookie('couponx_unique'+widget_id);
		coupon_widget_id = 'tab-box-front-'+ widget_id;	
		if($('#' + coupon_widget_id + ' .coupon-code-link').length > 0 &&
			$('#' + coupon_widget_id + ' .coupon-code-link').attr('data-type') == 2
			) {
			return;
		}

		var couponapp_email = $( '#' + coupon_widget_id + ' .coupon-code-email-text input[name="couponapp-email"]' ).length;
		if ( unique_code == null && couponapp_email != '1' && $("#"+coupon_widget_id).data("type") != 4) {
			let url = cx_data.url;
			
			// $( '#' + coupon_widget_id + ' .tab-box-couponcode-content .coupon-code-text').hide();
			coupon_code = $('.cx-code').val();
			$.ajax( {
	    		url   :url,
		    	data : {
		    		'id' : widget_id,
		    		'coupon_code' : coupon_code,
		    		'nonce' : cx_data.nonce,
					action: 'generate_coupon'
		    	},
				type: 'post',
				dataType: 'json',
		    	success: function( response ) {
		    		
		    		if ( response.status == 200 ) {

						let discount_code = response.code.code;
						let discount_code_id = response.code.id;
						let  days = $('.cx-code').data('valid');
						createCouponappCookie('couponx_unique'+widget_id, discount_code, days);
						if( $('#' + coupon_widget_id + ' .cx-code').length > 0 ) {
							
							$('#' + coupon_widget_id + ' .cx-code').val( discount_code );
							$( '#' + coupon_widget_id + ' .tab-box-couponcode-content .coupon-code-text').show();
						}
						if( $('#' + coupon_widget_id + ' .code').length > 0 ) {
							$('#' + coupon_widget_id + ' .code').text( discount_code );
						}
						if( $("#copy-coupon-inputcode-" + widget_id).length > 0 ) {
							$("#copy-coupon-inputcode-" + widget_id).val( discount_code );
						}

						if($('#' + coupon_widget_id + ' .coupon-code-link').length > 0) {
							href = $('#' + coupon_widget_id + ' .coupon-code-link').attr('data-url');
							
							let link = href + discount_code;
							$('#' + coupon_widget_id + ' .coupon-code-link').attr('href', link)
						}
					}
		    	}
		    });
		}
		else {
			
			if( $('#' + coupon_widget_id + ' .cx-code').length > 0 ) {
				$('#' + coupon_widget_id + ' .cx-code').val( unique_code );
				
			}
			if( $('#' + coupon_widget_id + ' .code').length > 0 ) {
				
				$('#' + coupon_widget_id + ' .code').text( unique_code );
			}
			if( $("#copy-coupon-inputcode-" + widget_id).length > 0 ) {
				$("#copy-coupon-inputcode-" + widget_id).val( unique_code );
			}
			if($('#' + coupon_widget_id + ' .coupon-code-link').length > 0) {
				href = $('#' + coupon_widget_id + ' .coupon-code-link').attr('data-url');
				type = $('#' + coupon_widget_id + ' .coupon-code-link').attr('data-type');
				if( type == 1 ) {
					link = href + unique_code;				
					
					$('#' + coupon_widget_id + ' .coupon-code-link').attr('href', link)
				}
				
			}
		}
		
	}

	let page_scroll_functions = function (widget_id) {
		$(window).scroll(function () {	
		let tab_id = 'tab-box-front-' + widget_id;
		container = $('#'+tab_id);		
		
		if ( container.data('scroll') !== '0') {
			let scrollHeight = $(document).height() - $(window).height();
			let scrollPos = $(window).scrollTop();
			if (scrollPos != 0) {
				let scrollPer = ((scrollPos / scrollHeight) * 100);
				let widgetScroll = parseInt(container.data('scroll'));
				let couponapp_show = localStorage.getItem( 'couponapp_show'+widget_id );
				
				if (scrollPer >= widgetScroll && 
					is_page_scroll_index !=  widget_id && 
					couponapp_show != 'yes' ) {
					
					is_page_scroll_index = widget_id;
					container.removeClass('hide')
					container.find('.tab-box-wrap').removeClass('hide');
					//check_for_widget_data(widget_id);
					localStorage.setItem( 'couponapp_scroll'+widget_id, 'yes');
					localStorage.setItem( 'couponapp_show'+widget_id, 'yes');
				}
			}
		}
		});
	}

	let clearWidetSession = function(widget_id) {
		
		localStorage.removeItem( 'is_updatevisitor'+widget_id );
		localStorage.removeItem( 'is_updatecouponopen' + widget_id );
		localStorage.removeItem( 'is_updatecouponcodeget' + widget_id );
		localStorage.removeItem( 'couponapp_close'+widget_id );
		localStorage.removeItem( 'couponapp_show'+widget_id );
		localStorage.removeItem( 'couponapp_scroll'+widget_id );
		localStorage.removeItem( 'couponapp_close_widget'+widget_id );
		localStorage.removeItem( 'couponapp_tab_hide'+widget_id );
		localStorage.removeItem( 'show_coupon_code'+widget_id );
		localStorage.removeItem( 'couponapp_pending_message'+widget_id );
		localStorage.removeItem( 'couponapp_open'+widget_id );
		localStorage.removeItem( 'couponapp_animation'+widget_id );
		localStorage.removeItem( 'couponapp_hide_cta_icon'+widget_id );
		name = 'couponx_unique'+widget_id;
		document.cookie = escape(name) + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/; SameSite=Lax';
		name = 'couponx-exist-'+widget_id;
		document.cookie = escape(name) + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/; SameSite=Lax';
	}
	let set_widget_data = function(widget_id) {

		cookie_name = 'cx_logged_'+widget_id;
		if( get_cookie( cookie_name ) != 1 && localStorage.getItem('is_updatevisitor'+widget_id) == 'yes') {
			clearWidetSession(widget_id);
		}

		/* Check CTA Hide after First Click/Hover */
		let tab_id = 'tab-box-front-' + widget_id;
		container = $('#'+tab_id);	
		
		if( container.attr('data-type') == 2 ) {
			const d = new Date();
			let time = d.getTime().toString().substring(4);
			code = 'COUPONX'+ time + Math.random().toString().substring(2,3);
			console.log(code)
			$('.cx-code').val(code);
			$('#copy-coupon-inputcode-'+widget_id).val(code);
			$('.code').text(code)
			console.log($('.hide_coup_code').length)
			if( $('.hide_coup_code').length ) {
				$('.hide_coup_code').val(code);
				$('.coupon-email-button').attr( 'data-coupon-code', code );
			}
			if($('.coupon-code-link').length && $('.coupon-code-link').attr('data-type') == '1') {
				link = $('.coupon-code-link').attr('data-url') + code;
				$('.coupon-code-link').attr('href', link ) 

			}
		}

		version = container.data( 'version' );
		widget_version = localStorage.getItem( 'version'+widget_id);
		if(widget_version != version) {
			clearWidetSession( widget_id );
		}
		if( $('.cx-code').val() != '' && container.attr('data-type') != 2)	{
			let  days = $('.cx-code').data('valid');						
			createCouponappCookie('couponx_unique'+widget_id, $('.cx-code').val(), days);
		}
		
		localStorage.setItem('version'+widget_id , version );

		
		/* Remove Session Storage if always open class*/
		if ( container.hasClass('couponapp-open-always') ) {
			localStorage.removeItem('couponapp_close'+widget_id);
		}

		if ( container.hasClass('couponapp-open-state-open') && localStorage.getItem('couponapp_close_widget'+widget_id) == null) {
			createCouponUniqueCode( widget_id );
			container.addClass('couonapp-active');
			container.removeClass('hide');
			localStorage.setItem('couponapp_open'+widget_id, 'yes');
			container.find('.tab-box-wrap').removeClass('hide');
			
		}

        createCouponappCookie('countsticky', 'dismiss', 1);

		let exit_intent = container.data('isexit');
		let time_delay = container.data('delay');
		let page_scroll = container.data('scroll');
			
		let exist_popup = readCouponappCookie('couponx-exist-'+ widget_id);	
		
		if ( ( time_delay == 0 || time_delay == '') && 
			page_scroll == '' && 
			exit_intent == 1 && 
			exist_popup == null ) {
				
			container.addClass('hide');
		}

		if ( ( (time_delay == 0 || time_delay == '') && 
			page_scroll == '') ||
			localStorage.getItem('couponapp_show'+widget_id) == 'yes' ||
			localStorage.getItem('couponapp_open'+widget_id) == 'yes'
			) {
			
			container.removeClass('hide');
			$('.tab-box-wrap').removeClass('hide');
			
		}
		if( parseInt(time_delay) > 0 ) {
			delay = parseInt(time_delay);
			let show_widget_after_some_time = function( widget_id ){
				container.removeClass('hide')
				container.find('.tab-box-wrap').removeClass('hide');
				let main_width = container.find( '.tab-box-email-content').outerWidth();
				let button_width = container.find( '.coupon-button.coupon-email-button').outerWidth();
				if ( typeof main_width !== 'undefined' && typeof button_width !== 'undefined') {

					// container.find('.coupon-code-email-text').width( main_width - button_width - 100 );
				}
				localStorage.setItem( 'couponapp_show'+widget_id, 'yes');
			};
			setTimeout(show_widget_after_some_time, delay*1000, widget_id, container );
		}
		if( page_scroll != '' ) {
			page_scroll_functions(widget_id);
		}
		
		/* Hide Tab after conversation */
		if ( localStorage.getItem('couponapp_tab_hide'+widget_id) == 'yes' 
			&&  container.hasClass( 'couponapp-tab-hide' ) ) {
			container.hide();
		}
		
		$( '.tab-box.tab-front-box').each(function () {
			let main_width = $(this).find( '.tab-box-email-content').outerWidth();
			let button_width = $(this).find( '.coupon-button.coupon-email-button').outerWidth();
			if ( typeof main_width !== 'undefined' && typeof button_width !== 'undefined') {
				
				// $(this).find('.coupon-code-email-text').width( main_width - button_width - 100 );
			}

		})
		
		if ( localStorage.getItem('show_coupon_code'+widget_id) == 'yes') {
			container.find('.tab-box-content.tab-box-email-content').remove();
			container.addClass( 'open-coupon-code');
		}
		
		let coupon_pending_message = localStorage.getItem('couponapp_pending_message'+widget_id);	
		
		if ( coupon_pending_message === 'yes' || 
			container.hasClass( 'couponapp-open-state-open' ) ) {
			container.find('.coupon-pending-message').remove();
		}
		if ( container.hasClass( 'couponapp-open-state-open' ) )  {			
			container.find('.tab-text').hide();
			container.removeClass('hide');
			container.find('.tab-box-wrap').removeClass('hide');

		}
		
		if(container.hasClass( 'couponapp-open-state-open' ) &&
		  localStorage.getItem('couponapp_close_widget'+widget_id) == 'yes' && 
		  container.hasClass( "couponapp-open-always" ) ) {
			container.find('.tab-text').show();
		} 
		let couponapp_open = localStorage.getItem('couponapp_open'+widget_id);					
		if ( couponapp_open === 'yes' &&
			container.hasClass( 'couponapp-attention-once' ) &&
			container.hasClass( 'couponapp-open-state-open' ) ) {
			localStorage.setItem('couponapp_animation'+widget_id, 'yes');
			container.removeClass (function (index, className) {				
				return (className.match (/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
			});
		}

		let couponapp_animation = localStorage.getItem('couponapp_animation'+widget_id);
		if(couponapp_animation === 'yes') {
			container.removeClass (function (index, className) {
				return (className.match (/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
			});
		}
		
		let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? true : false;
		
		if ( isMobile === true ) {
			container.removeClass( "couponapp-open-state-hover" )
					.removeClass( "couponapp-open-state-open" )
					.addClass( "couponapp-open-state-click" );
		}
		
		let IsUpdatevisitor = localStorage.getItem( 'is_updatevisitor'+widget_id);
		
		/* Update Visitor */
		 // updatecount == 1 && isowner == 'no' &&
		if( is_updatevisitor == 0 &&  IsUpdatevisitor != 'yes' ){
            name = 'couponx_unique'+widget_id;
			document.cookie = escape(name) + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/; SameSite=Lax';
            updatecouponstats(widget_id, 'visitor');
			is_updatevisitor = 1;
			localStorage.setItem( 'is_updatevisitor'+widget_id, 'yes');
			document.cookie = 'cx_logged_'+widget_id+'=1';
        }
		
		let is_updatecouponopen = localStorage.getItem( 'is_updatecouponopen' + widget_id);
		if (container.hasClass( "couonapp-active" ) && is_updatecouponopen != 'yes' ) {
			updatecouponstats(widget_id, 'widget_open');
			localStorage.setItem( 'is_updatecouponopen' + widget_id, 'yes');
		}
		let session_tab = localStorage.getItem('couponapp_close'+widget_id);		
		if ( session_tab === 'close' ) {			
			container.find('.tab-text').hide();
		}

		if(container.hasClass('couponapp-hide-cta-icon')
			&& localStorage.getItem('couponapp_hide_cta_icon'+widget_id) == null ) {
			container.addClass('couonapp-active');
			container.removeClass('hide');
			container.find('.tab-box-wrap').addClass('hide');
		}

		if ( localStorage.getItem('couponapp_hide_cta_icon'+widget_id) == 'yes'
			&&  container.hasClass( 'couponapp-hide-cta-icon' ) ) {
			container.hide();
		}
    }

    $('.tab-front-box').each(function() {
    	let widget_id = $(this).data('widgetid');
    	set_widget_data(widget_id)
    })
    

	let handle_widget_open = function(widget_id, id) {
		container = $( '#' + id );
		if ( container.hasClass( "couonapp-active" ) ) {
			container.removeClass( 'couonapp-active');
			localStorage.setItem(  'couponapp_pending_message'+widget_id, 'yes');
			localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');
			if ( container.hasClass( "couponapp-open-always" ) ) {
				container.find('.tab-text').show();
			}
			return;
		}
		
		createCouponUniqueCode( widget_id );
		
		let is_updatecouponopen = localStorage.getItem( 'is_updatecouponopen' + widget_id);
		if ( !container.hasClass( "couonapp-active" ) && 
			is_updatecouponopen != 'yes' ) {
			updatecouponstats( widget_id, 'widget_open' );
			localStorage.setItem( 'is_updatecouponopen' + widget_id, 'yes');
		}
		
		container.addClass( 'couonapp-active');

		if (container.hasClass( 'couponapp-attention-once' ) ) {
			localStorage.setItem('couponapp_animation'+widget_id, 'yes');
			container.removeClass(function (index, className) {
				return (className.match(/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
			});
		}
		
		/* Save Close in Session Storage */
		let session_tab = localStorage.getItem('couponapp_close'+widget_id);		
		if ( session_tab === 'close' ) {			
			container.find('.tab-text').hide();
		}
		if ( container.hasClass( "couponapp-open-first" ) ) {
			localStorage.setItem( 'couponapp_close'+widget_id, 'close');
			container.find('.tab-text').hide();
		}
		localStorage.setItem(  'couponapp_open'+widget_id, 'yes');
		
		if ( $( '#' + id ).find( ".coupon-pending-message" ).length > 0) {
			localStorage.setItem('couponapp_pending_message'+widget_id, 'yes');
			container.find('.coupon-pending-message').remove();
		}
	}

	$(document).on("click touch", ".couponapp-open-state-click .tab-icon" , function(){				
		
		let id = $(this).closest('.tab-box').attr( 'id' );
		let widget_id = $('#' + id).data("widgetid");						
		handle_widget_open( widget_id, id );
		
	});

	/* Remove Animation on Hover */
	$(document).on("click touch", ".couponapp-open-state-hover-open .tab-icon" , function(){
		let id = $(this).closest('.tab-box').attr( 'id' );
		let widget_id = $('#' + id).data("widgetid");
		container = $( '#' + id );	
		if ( container.hasClass( "couonapp-active" ) ) {
			container.removeClass( 'couonapp-active');
			localStorage.setItem(  'couponapp_pending_message'+widget_id, 'yes');
			container.removeClass( 'couponapp-open-state-hover-open');
			container.addClass( 'couponapp-open-state-click');
			setTimeout(function(){
				container.addClass( 'couponapp-open-state-hover');
			}, 100 );
			
			return;
		}
	});

	//mouseover
	$(document).on("mouseenter touch", ".couponapp-open-state-hover .tab-icon" , function(){
		let id = $(this).closest('.tab-box').attr( 'id' );
		let widget_id = $('#' + id).data("widgetid");
		container = $( '#' + id );
		
		createCouponUniqueCode( widget_id );
		if ( container.hasClass( "couonapp-active" ) ) {				
			return;
		}
		
		let is_updatecouponopen = localStorage.getItem( 'is_updatecouponopen' + widget_id);
		if ( !$( '#' + id ).hasClass( "couonapp-active" ) && 
			is_updatecouponopen != 'yes' ) {
			updatecouponstats( widget_id, 'widget_open' );
			localStorage.setItem( 'is_updatecouponopen' + widget_id, 'yes');
		}

		if (container.hasClass( 'couponapp-attention-once' ) ) {
			localStorage.setItem('couponapp_animation'+widget_id, 'yes');
			container.removeClass(function (index, className) {
				return (className.match(/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
			});
		}
		container.addClass( 'couonapp-active');	
		
		container.addClass( 'couponapp-open-state-click');
		
		
		/* Save Close in Session Storage */
		let session_tab = localStorage.getItem( 'couponapp_close'+widget_id);		
		if ( session_tab === 'close' ) {			
			container.find('.tab-text').hide();
		}
		if ( container.hasClass( "couponapp-open-first" ) ) {
			localStorage.setItem( 'couponapp_close'+widget_id, 'close');
			container.find('.tab-text').hide();
		}
		
		localStorage.setItem( 'couponapp_open'+widget_id, 'yes');
		
		if ( container.find( ".coupon-pending-message" ).length > 0) {
			localStorage.setItem( 'couponapp_pending_message'+widget_id, 'yes');
			container.find('.coupon-pending-message').remove();
		}
	});

	/*  Coupon tab close event */
	$(document).on( "click touch", ".coupon-tab-close" , function(e){
		e.preventDefault();
		let id = $(this).closest('.tab-box').attr( 'id' );
		let widget_id = $('#' + id).data("widgetid");
		container = $( '#' + id );				
		
		container.removeClass( 'couonapp-active');
		
		$(this).parent().attr("style",'');
		
		localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');
		
		
		if ( container.hasClass( "couponapp-open-state-hover-open" ) ) {
			container.addClass( 'couponapp-open-state-hover')
				.removeClass( 'couponapp-open-state-hover-open');
		}

		if (container.hasClass( 'couponapp-attention-once' ) ) {
			localStorage.setItem('couponapp_animation'+widget_id, 'yes');
			container.removeClass(function (index, className) {
				return (className.match(/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
			});
		}
		
		localStorage.setItem( 'couponapp_open'+widget_id, 'yes');
		
		if ( container.hasClass( "coupon-pending-message" )) {
			localStorage.setItem('couponapp_pending_message'+widget_id, 'yes');
			container.find('.coupon-pending-message').remove();
		}
		
		if ( container.hasClass( "couponapp-open-always" ) ) {
			container.find('.tab-text').show();
		}

		if( container.hasClass( "couponapp-hide-cta-icon" ) ) {
			localStorage.setItem('couponapp_hide_cta_icon'+widget_id, 'yes');
		}
		
	});

	$(document).on( "click touch", ".copy-to-clipboard" , function(e){			
		e.preventDefault();

		let widget_id = $(this).data('widget-id');
		let copyText = $("#copy-coupon-inputcode-" + widget_id).val();

		var temp = $("<input>");
	    $("body").append(temp);
	    temp.val(copyText).select();
		/* Select the text field */			  
		//copyText.select();
		//copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy",  false, temp.val());
		temp.remove();
		$( '#tab-box-front-' +widget_id +' .coupon-code-text .label-tooltip' ).addClass('tooltip-show');
		setTimeout(function() {
			$('#tab-box-front-' +widget_id +' .coupon-code-text .label-tooltip').removeClass('tooltip-show');
		}, 1000);				  
		
		/* */
		
		let is_updatecouponcodeget = localStorage.getItem( 'is_updatecouponcodeget' + widget_id);
		if ( !$( this ).hasClass( "couoncode-copied" ) && is_updatecouponcodeget != 'yes' ) {
			updatecouponstats( widget_id, 'coupon' );				
			localStorage.setItem( 'is_updatecouponcodeget' + widget_id, 'yes');
		}
		
		$( this ).addClass( "couoncode-copied" );
		
		if ( typeof $( '#tab-box-front-' +widget_id ).data('close-widget') != 'undefined') {
			let close_widget_seconds = $( '#tab-box-front-' +widget_id ).data('close-widget') ;
			close_widget_seconds = close_widget_seconds.toString().replace(/'/g, '');
			close_widget_seconds = parseInt(close_widget_seconds)* 1000;
			
			let close_widget_after_seconds = function(widget_id){
				$('#tab-box-front-' +widget_id ).removeClass('couonapp-active');
				localStorage.setItem('couponapp_close_widget'+widget_id, 'yes');
			};
			setTimeout(close_widget_after_seconds, close_widget_seconds, widget_id);
		}
		
		if ( $( '#tab-box-front-' + widget_id ).hasClass('couponapp-open-state-open') ) {
			localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');
			
		}
		
		/* Hide Tab after Conversation */
		if ( $( '#tab-box-front-' + widget_id ).hasClass( 'couponapp-tab-hide' ) ) {
			localStorage.setItem( 'couponapp_tab_hide'+widget_id, 'yes');
		}
	});

	$(document).on( "click touch", ".coupon-code-link" , function(e){		
				
		let widget_id = $(this).data('widget-id');
		let container = $( '#tab-box-front-' +widget_id )
		let is_updatecouponcodeget = localStorage.getItem( 'is_updatecouponcodeget' + widget_id);
		if ( !$( this ).hasClass( "couoncode-copied" ) && is_updatecouponcodeget != 'yes' ) {
			updatecouponstats( widget_id, 'coupon' );
			localStorage.setItem( 'is_updatecouponcodeget'+widget_id, 'yes' );
		}
		
		if ( typeof container.data('close-widget') != 'undefined') {
			let close_widget_seconds = container.data('close-widget') * 1000;
			
			let close_widget_after_seconds = function(widget_id){
				container.removeClass('couonapp-active');
				localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');
			};
			setTimeout(close_widget_after_seconds, close_widget_seconds, widget_id);
		}				
		if ( container.hasClass('couponapp-open-state-open') ) {
			localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');
			container.removeClass('couonapp-active');
		}
		
		/* Hide Tab after Conversation */
		if ( container.hasClass( 'couponapp-tab-hide' ) ) {
			localStorage.setItem( 'couponapp_tab_hide'+widget_id, 'yes');
		}

		return true;
		
	});
	
	$(document).on( "click touch", ".couponapp-open-state-open .tab-icon" , function(e){
		let id = $(this).closest('.tab-box').attr( 'id' );
		
		let widget_id = $('#' + id).data("widgetid");
		container = $( '#' + id );
		
		if ( container.hasClass( "couonapp-active" ) ) {
			container.removeClass( "couonapp-active" )
			localStorage.setItem(  'couponapp_open_widget' + widget_id, 'yes');
			localStorage.setItem( 'couponapp_pending_message' + widget_id, 'yes');
			localStorage.setItem(  'couponapp_close_widget' + widget_id, 'yes');
			$('#' + id + ' .coupon-pending-message').remove();
			if ( container.hasClass( "couponapp-open-always" ) ) {
				$('#' + id + ' .tab-text').show();
			}
		} else {
			createCouponUniqueCode( widget_id );
			container.addClass( "couonapp-active" )
			localStorage.setItem(  'couponapp_open' + widget_id, 'yes');
		}
	});

	$(document).on( "click", ".coupon-email-button" , function(e) {			
		let widget_id = $(this).data( 'widget-id' );
		let coupon_widget_id = 'tab-box-front-'+ widget_id
		let container = $( '#tab-box-front-' +widget_id );
		let email		= container.find('.tab-box-email-content input[name="couponapp-email"]').val();
		let customer_name		= container.find('.tab-box-email-content input[name="couponapp-name"]').val();
		let coupon_code = $(this).data('coupon-code');
		var required = $("input[name='couponapp-name']").hasClass("required-name");
		if(customer_name == "" && (typeof required !== 'undefined' && required !== false)) {
			$(".required-text-msg").addClass("active");

		} else {
			$(".required-text-msg").removeClass("active");
		}
		
		
		let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			email = '';				
		}
		
		let consent_id	= $( this).data( 'consent-id' );
		let consent		= $( this).data( 'consent' );
		if ( consent == 1 && 
			$('#' + consent_id).prop("checked") == false &&  
			$('#' + consent_id).attr('required') == 'required') {
			
			return true;
			
		} else if ( widget_id != '' && email != '' && ((customer_name != "" && required) || ((customer_name == "" || customer_name != "") && required == false))) {
			e.preventDefault();

			$(this).attr("disabled", true);
				localStorage.setItem( 'couponapp_close_widget'+widget_id, 'yes');

				let url = cx_data.url;
				$.ajax( {
					url   :url,
					data : {
						'nonce': cx_data.nonce,
						'email': email,
						'customer_name': customer_name,
						'widget_id' : widget_id,
						'coupon_code' : ( coupon_code != '' ) ? coupon_code : '',
						'is_consent': ($('#' + consent_id).length != 0 && $('#' + consent_id).prop("checked") == true ) ? 1 : 0,
						action: 'capture_email',
					},
					type: 'post',
					dataType: 'json',
					success: function( response ) {
						$(this).attr("disabled", false);
						if ( response.status == 401 ) {
							$( '#' + coupon_widget_id + ' .tab-box-email-content p.coupon-email-error').remove();
							$( '#' + coupon_widget_id + ' .tab-box-email-content .form-wrap')
								.after('<p class="coupon-email-error">'+ response.error +'</p>');

							setTimeout(function () {
								$('#' + coupon_widget_id + ' .tab-box-email-content p.coupon-email-error').slideUp("slow");

							}, 5000);
						}
						if ( response.show_coupon === true ) {
							let discount_code = response.discount_code;
							if( $('#' + coupon_widget_id + ' .cx-code').length > 0 ) {
								$('#' + coupon_widget_id + ' .cx-code').val( discount_code );

							}
							if( $('#' + coupon_widget_id + ' .code').length > 0 ) {

								$('#' + coupon_widget_id + ' .code').text( discount_code );
							}
							if( $("#copy-coupon-inputcode-" + widget_id).length > 0 ) {
								$("#copy-coupon-inputcode-" + widget_id).val( discount_code );
							}
							if($('#' + coupon_widget_id + ' .coupon-code-link').length > 0 &&
								$('#' + coupon_widget_id + ' .coupon-code-link').attr('data-type') != 2
							) {
								href = $('#' + coupon_widget_id + ' .coupon-code-link').attr('data-url');
								let link = href +discount_code;
								$('#' + coupon_widget_id + ' .coupon-code-link').attr('href', link)
							}
							let  days = $('.cx-code').data('valid');
							createCouponappCookie('couponx_unique'+widget_id, discount_code, days);

							$( '#' + coupon_widget_id + ' .tab-box-email-content').fadeOut(100);

							let show_widget_coupon_code = function(coupon_widget_id){
								$( '#' + coupon_widget_id + ' .tab-box-couponcode-content').fadeIn('slow');
							};
							setTimeout(show_widget_coupon_code, 200, coupon_widget_id);

							$( '#' + coupon_widget_id ).addClass('couponapp-email-coupon-code-show');
							$( '#' + coupon_widget_id ).find('.tab-box-couponcode-content').removeClass('hide');
							localStorage.setItem( 'show_coupon_code'+widget_id, 'yes');

						}

					}
				});
			
			return false;
		} else {				
			if ( consent == 1 && 
				$('#' + consent_id).prop("checked") == false && 
				$('#' + consent_id).attr('required') == 'required') {
				return true;
			}
			if ( email == '' ) {
				return true;
			}
		}
		
		return false;
	});

	$(document).mouseleave(function (e) {
		let top = e.clientY;
		let right = document.body.clientWidth - e.pageX;
		let bottom = $(window).height() - e.clientY;
		let left = e.pageX;    
		if(right > 0 && bottom > 0 && top <=0){
			$('.tab-front-box').each(function(i, val) {
				let is_exit = $(this).data('isexit');
				let widget_id = $(this).data("widgetid");
				var id = jQuery(this).attr( 'id' );	
				
				if(is_exit == '1' && localStorage.getItem('couponapp_open'+widget_id) !== 'yes'){
					let exist_popup = readCouponappCookie('couponx-exist-'+ widget_id);
					if( exist_popup == null ) {
						
						createCouponUniqueCode(widget_id);
						$(this).removeClass('hide');
						$('#' + id + ' .tab-box-wrap').removeClass('hide');
						$(this).addClass('couonapp-active');
						$(this).addClass('couponapp-open-state-click');
														
						createCouponappCookie('couponx-exist-'+ widget_id, 'yes' , 1);
						
						if ( $( this ).find( ".coupon-pending-message" ).length) {
							localStorage.setItem( 'couponapp_pending_message' +widget_id, 'yes');
							$('.coupon-pending-message').remove();
						}

						if ($(this).hasClass( 'couponapp-attention-once' ) ) {
							localStorage.setItem('couponapp_animation'+widget_id, 'yes');
							$(this).removeClass(function (index, className) {
								return (className.match(/(^|\s)couponapp-\S+-animation/g) || []).join(' ');
							});
						}
						
						/* Save Close in Session Storage */
						let session_tab = localStorage.getItem('couponapp_close'+widget_id);		
						if ( session_tab === 'close' ) {			
							$('#' + id + ' .tab-text').hide();
						}
						if ( $(this).hasClass( "couponapp-open-first" ) ) {
							localStorage.setItem('couponapp_close'+widget_id, 'close');
							$('#' + id + ' .tab-text').hide();
						}
						localStorage.setItem( 'couponapp_open'+widget_id, 'yes');
						
						let main_width = $(this).find( '.tab-box-email-content .form-wrap').outerWidth();
						let button_width = $(this).find( '.coupon-button.coupon-email-button').outerWidth();
						if ( typeof main_width !== 'undefined' && typeof button_width !== 'undefined') {		
							// $(this).find('.coupon-code-email-text').width( main_width - button_width - 37 );
						}
					} 
				}
			});
		}
	});
	$('.close-an').click(function(e) {
		e.preventDefault();
		$('.coupon-tab-close').trigger('click')
		$(this).closest('.tab-box').find('.tab-box-wrap').addClass('hide')
		widget_id = $(this).closest('.tab-box').data('widgetid');		
		localStorage.setItem( 'couponapp_tab_hide'+widget_id, 'yes');
	})
	$('.open-an').click(function(e) {
		e.preventDefault()
		link = $(this).attr('url');
		if( $(this).hasClass('blank') ) {
			window.open(
				link,
				'_blank' 
			  );
		}
		else {
			location.href = link;
		}
		
	});

	var coupon_height = parseInt($(".tab-front-box .tab-box-content").outerHeight());
	var cookie_height = getCookie("coupon-box-height");
	if(cookie_height == null) {
		setCookie("coupon-box-height", coupon_height, 2);
	}

	
});
function get_cookie(Name) {
    var search = Name + "="
    var returnvalue = "";
    if (document.cookie.length > 0) {
        offset = document.cookie.indexOf(search)
        // if cookie exists
        if (offset != -1) { 
            offset += search.length
            // set index of beginning of value
            end = document.cookie.indexOf(";", offset);
            // set index of end of cookie value
            if (end == -1) end = document.cookie.length;
            returnvalue=unescape(document.cookie.substring(offset, end))
        }
    }
    return returnvalue;
}

function getCookie(name) {
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : null;
}

function setCookie(name, value, days) {
	var d = new Date;
	d.setTime(d.getTime() + 24*60*60*1000*days);
	document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
}

function deleteCookie(name) {
	setCookie(name, '', -1);
}

function launch_couponx() {
	if (jQuery(".tab-front-box").length) {
		if(jQuery(".tab-front-box").hasClass("couponapp-open-state-click")) {
			jQuery(".tab-front-box.couponapp-open-state-click .tab-icon").trigger("click");
		}
		if(jQuery(".tab-front-box").hasClass("couponapp-open-state-hover")) {
			jQuery(".tab-front-box.couponapp-open-state-hover .tab-icon").trigger("mouseenter");
		}
		if(jQuery(".tab-front-box").hasClass("couponapp-open-state-open")) {
			jQuery(".tab-front-box.couponapp-open-state-open .tab-icon").trigger("click");
		}
	}
}

function close_couponx() {
	if (jQuery(".tab-front-box").length) {
		jQuery(".tab-front-box .coupon-tab-close").trigger("click");
	}
}