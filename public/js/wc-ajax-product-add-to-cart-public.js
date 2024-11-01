/* global wc_prod_ajax_to_cart */
(function( $ ) {
	'use strict';

	var $supports_html5_storage = true;

	try {
		$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
		window.sessionStorage.setItem( 'wc', 'test' );
		window.sessionStorage.removeItem( 'wc' );
		window.localStorage.setItem( 'wc', 'test' );
		window.localStorage.removeItem( 'wc' );
	} catch( err ) {
		$supports_html5_storage = false;
	}

	$(document).on('submit', 'body.single-product form.cart', function(e){
		e.preventDefault();
		var $this = $(this);
		$( document.body ).trigger( 'adding_to_cart' );
		if( wc_prod_ajax_to_cart.enable_blockui === '1' ) {
			$this.block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		}
		$.ajax({
			method: 'POST',
			url: wc_prod_ajax_to_cart.ajax_url,
			data: $this.serialize(),
			success: function( data ) {

				if ( data && data.fragments ) {
					$.each( data.fragments, function( key, value ) {
						$( key ).replaceWith( value );
					});

					if( wc_prod_ajax_to_cart.enable_blockui === '1' ) {
						$this.unblock();
					}

					if ( typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage && typeof wc_cart_fragments_params !== 'undefined' && wc_cart_fragments_params ) {
						sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( data.fragments ) );
						set_cart_hash( data.cart_hash );
	
						if ( data.cart_hash ) {
							set_cart_creation_timestamp();
						}
					}
	
					$( document.body ).trigger( 'wc_fragments_refreshed' );
				}
			},
			error: function( response ) {
				$( document.body ).trigger( 'added_to_cart' );
				if( wc_prod_ajax_to_cart.enable_blockui === '1' ) {
					$this.unblock();
				}
			},
		});
	});	

})( jQuery );
