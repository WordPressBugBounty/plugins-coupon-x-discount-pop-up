const { __, _x, _n, _nx } = wp.i18n;

jQuery('document').ready(function($) {

	$('.leads-listing').DataTable({
		dom: 'Bfrtip',
		"pageLength": 20,
		"lengthChange": false,
		"oLanguage": {
	        "sEmptyTable": __("You don't have any leads yet. Once you collect email leads, the data will appear in this table.", 'coupon-x' )
	    },
		buttons: [
            {
		        extend: 'csv',
		        exportOptions: {
		            columns: [1,2,3,4] 
		        }

		    },
            {
                text: __('Delete', 'coupon-x'),
                attr: {id: 'btn-delete'},
                action: function ( e, dt, node, config ) {
                	if( $('.chk_lead:checked').length == 0 ) {
                		alert(__('Please select at least one record','coupon-x') );
                	}
                	else {
                		let lead_ids = [];
                		$('#lead-delete-confirm p').text( __('Are you sure you want to delete selected leads?', 'coupon-x') );
                		$('.chk_lead:checked').each(function() {
							lead_ids.push( $(this).val() );
                		})
                		leads = lead_ids.join(',');
                		$('#dashboard_lead_id').val(leads);
			    		delete_lead_dialog.dialog("open");
                	}
                }

            }
        ]
       
	});
	$('.select-all').click(function() {
		if( $(this).is(':checked')) {
			$('.chk_lead').prop('checked', true);	
		}
		else {
			$('.chk_lead').prop('checked', false);	
		}
		
	});
	$('.chk_lead').click(function() {
		if( !$(this).is(':checked')) {
			$('.select-all').prop('checked', false);	
		}
	});

	let delete_lead_dialog = $( "#lead-delete-confirm" ).dialog({
		resizable: false,
		modal: true,
		draggable: false,
		height: 'auto',
		width: 400,
		overflow: 'auto',
		autoOpen : false,
		buttons:[
			{
				text: __("Cancel", 'coupon-x'),
				"class": 'btn btn-cancel',
				click: function () {
					$(this).dialog('close');
				}
			},
			{
				text: __("Delete Lead", 'coupon-x'),
				"class": 'btn btn-red',
				click: function () {
					url = cx_data.url;
					leads = $('#dashboard_lead_id').val();
					let lead_ids = [];
					$('#lead-delete-confirm p').text( __('Are you sure you want to delete selected leads?', 'coupon-x') );
					// $('.chk_lead:checked').each(function() {
					// 	lead_ids.push( $(this).val() );
					// })
					if(leads != "") {
						lead_ids = leads.split(",");
					}
			    	$('#loader').show();
			    	$.ajax( {
			    		url   :url,
				    	data : {
				    		'id' : lead_ids,
							action: 'delete_leads',
							nonce: $('input[name="cx_nonce"]').val()
				    	},
						type: 'post',
						dataType: 'json',
				    	success: function( response ) {
				    		console.log( response );
				    		
				    		ids = leads.split(',');
				    		$.each(ids, function( index, id ) {
				    			$('.chk_lead[value="'+id+'"').closest('tr').hide();
				    		});
				    		$('#loader').hide();
				    		$('#wp_flash_message').removeClass('hide');
				    		setTimeout(function(){ 
				    			$('#wp_flash_message').addClass('hide'); 
				    			location.reload();
				    		}, 2000);

				    	}
				    });
					$(this).dialog('close');
				}

			}
		]
	});
	$('body').on('click', '.ui-widget-overlay', function() {
		console.log('called')
		delete_lead_dialog.dialog( "close" );
	})
	$('.close_flash_popup').click(function() {
		$('#wp_flash_message').addClass('hide')
	});


    $('.delete-lead').click(function(e) {
    	e.preventDefault();
    	link = $(this).closest('tr');
    	$('#lead-delete-confirm p').text( __('Are you sure you want to delete this lead?', 'coupon-x') );
    	let lead_id = $(this).attr( 'lead-id' );
    	$('#dashboard_lead_id').val(lead_id);
    	delete_lead_dialog.dialog("open");
    	
    })

})
