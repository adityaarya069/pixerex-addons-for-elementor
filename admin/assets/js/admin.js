( function ( $ ) {
    
    var redirectionLink = " https://pixerexaddons.com/pro/?utm_source=wp-menu&utm_medium=wp-dash&utm_campaign=get-pro&utm_term=";
    "use strict";
    
    $(".pr-checkbox").on("click", function() {
       if($(this).prop("checked") == true) {
           $(".pr-elements-table input").prop("checked", 1);
       }else if($(this).prop("checked") == false){
           $(".pr-elements-table input").prop("checked", 0);
       }
    });
   
   $(".pro-slider").on('click', function(){

        swal({
            title: '<span class="pr-swal-head">Get PRO Widgets & Addons<span>',
            html: 'Supercharge your Elementor with PRO widgets and addons that you won’t find anywhere else.',
            type: 'warning',
            showCloseButton: true,
	  		showCancelButton: true,
            cancelButtonText: "More Info",
	  		focusConfirm: true
        }).then(function(json_data) {}, function(dismiss) {
            if (dismiss === 'cancel') { 
                window.open( redirectionLink + settings.theme, '_blank' );
            } 
        });
    });

    $( 'form#pr-settings' ).on( 'submit', function(e) {
		e.preventDefault();
		$.ajax( {
			url: settings.ajaxurl,
			type: 'post',
			data: {
                action: 'pr_save_admin_addons_settings',
                security: settings.nonce,
				fields: $( 'form#pr-settings' ).serialize(),
			},
            success: function( response ) {
				swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
				);
			},
			error: function() {
				swal(
				  'Oops...',
				  'Something Wrong!',
				);
			}
		} );

	} );
        
    $('form#pr-maps').on('submit',function(e){
       e.preventDefault();
       $.ajax( {
            url: settings.ajaxurl,
            type: 'post',
            data: {
                action: 'pr_maps_save_settings',
                security: settings.nonce,
                fields: $('form#pr-maps').serialize(),
            },
            success: function (response){
                swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
                );
            },
            error: function(){
                swal(
                    'Oops...',
                    'Something Wrong!',
                );
            }
        });
    });
    
    
     $('form#pr-beta-form').on('submit',function(e){
       e.preventDefault();
       $.ajax( {
            url: settings.ajaxurl,
            type: 'post',
            data: {
                action: 'pr_beta_save_settings',
                security: settings.nonce,
                fields: $('form#pr-beta-form').serialize(),
            },
            success: function (response){
                swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
                );
            },
            error: function(){
                swal(
                    'Oops...',
                    'Something Wrong!',
                );
            }
        });
    });



    $( '.pr-rollback-button' ).on( 'click', function( event ) {
				event.preventDefault();

				var $this = $( this ),
					dialogsManager = new DialogsManager.Instance();

				dialogsManager.createWidget( 'confirm', {
					headerMessage: pixerexRollBackConfirm.i18n.rollback_to_previous_version,
					message: pixerexRollBackConfirm.i18n.rollback_confirm,
					strings: {
						cancel: pixerexRollBackConfirm.i18n.cancel,
                        confirm: pixerexRollBackConfirm.i18n.yes,
					},
					onConfirm: function() {
						$this.addClass( 'loading' );

						location.href = $this.attr( 'href' );
					}
				} ).show();
			} );
    
} )(jQuery);