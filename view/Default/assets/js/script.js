/**
 * Created by emsm on 30/10/2016.
 */

$( function () {
	$( '.subNavTab a' ).click( function ( e ) {
		e.preventDefault()
		$( this ).tab( 'show' )
	} );


	$( '.selectizeListImg' ).selectize( {
		plugins:     [ 'remove_button', 'drag_drop' ],
		delimiter:   ',',
		persist:     false,
		options:     selectToJSON( $( '#images' ) ),
		render:      {
			item:   function ( item, escape ) {
				return '<div class="itemSelectize inline">' +
					(item.link ? '<img src="'+ escape( item.link ) +'" height="30"/>' : '') +
					(item.libel ? '<div class="libel"><span>' + escape( item.libel ) + '</span></div>' : '') +
					'</div>';
			},
			option: function ( item, escape ) {
				return '<div class="itemSelectize flex">' +
					(item.link ? '<img src="'+ escape( item.link ) +'" height="30"/>' : '') +
					(item.libel ? '<div class="libel"><span>' + escape( item.libel ) + '</span></div>' : '') +
					'</div>';
			}
		},
		searchField: [ 'libel' ],
		maxItems:    null,
		valueField:  'key',
		labelField:  'libel',
		create:      function ( input ) {
			return {
				value: input,
				text:  input
			}
		}
	} );
} );

function selectToJSON( select ) {
	var json = [];

	select.find( 'option' ).each( function () {
		var val   = $( this ).val();
		var label = $( this )[ 0 ].label;
		var link  = $( this )[ 0 ].innerHTML;

		json.push( {
			key:   val,
			libel: label,
			link:  link
		} );
	} );

	return json;
};