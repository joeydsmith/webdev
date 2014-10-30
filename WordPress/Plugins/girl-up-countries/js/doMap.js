jQuery(document).ready(function(){

	// Cache objects
	var _map        = jQuery('#gup-map');
	var _map_marker = jQuery('#gup-map_marker');
	var _form_x     = jQuery('input[name="coordinates_x');
	var _form_y     = jQuery('input[name="coordinates_y');

	// Cache form values
	var _current_x  = _form_x.val();
	var _current_y  = _form_y.val();

	// Cache parent's offset and dimensions
	var _map_offset = _map.offset();
	var _map_height = _map.outerHeight();
	var _map_width  = _map.outerWidth();
	
	// On click, calulate mouse position
	_map.click(function(e){

		// Mouse position - parent's offset in percent
		var x = ( ( ( e.pageX - _map_offset.left ) - 10 ) / _map_width ) * 100 + '%';
		var y = ( ( ( e.pageY - _map_offset.top )  - 70 ) / _map_height ) * 100 + '%';
		var _y = ( ( ( e.pageY - _map_offset.top )  - 100 ) / _map_height ) * 100 + '%';

		// Fill in form
		_form_x.val(x);
		_form_y.val(y);

		// Position marker
		positionMarker(_map_marker, x, _y);
   	
	})

	// If saved values, position marker
	if ( _current_x != '' && _current_y != '' ) {
		positionMarker( _map_marker, _current_x, _current_y );
	}
	
})

function positionMarker( element, x, y ){
	
	// Position marker
	element.css({ 
		'left' : x, 
		'top' : y
	}).show();

	// Dev
	console.log(x + ', ' + y);
}