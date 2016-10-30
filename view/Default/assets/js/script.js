/**
 * Created by emsm on 30/10/2016.
 */

$( function () {
	$( '.subNavTab a' ).click( function ( e ) {
		e.preventDefault()
		$( this ).tab( 'show' )
	} )
} );