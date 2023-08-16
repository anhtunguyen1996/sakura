if ( _.isUndefined( window.vc ) ) {
	var vc = {atts: {}};
}

jQuery( document ).ready( function( $ ) {
	$( '.imgradio label' ).click( function() {
		$( this ).addClass( 'selected' ).siblings().removeClass( 'selected' );
		$( this ).closest( '.imgradio' ).find( 'input[type=radio]' ).removeClass( 'wpb_vc_param_value' );
		$( this ).prev().addClass( 'wpb_vc_param_value' );
	} );
} );
