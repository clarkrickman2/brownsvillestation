/**
 *  Searchable dropdown
 */
 /* global BronzeAdminParams */
;( function( $ ) {

	'use strict';

	$( '.bronze-searchable' ).chosen( {
		no_results_text: BronzeAdminParams.noResult,
		width: '100%'
	} );

	$( document ).on( 'hover', '#menu-to-edit .pending', function() {
		if ( ! $( this ).find( '.chosen-container' ).length && $( this ).find( '.bronze-searchable' ).length ) {
			$( this ).find( '.bronze-searchable' ).chosen( {
				no_results_text: BronzeAdminParams.noResult,
				width: '100%'
			} );
		}
	} );

} )( jQuery );