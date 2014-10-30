function collapseHeader(){
	var _header = jQuery('header#header');
	var _body = jQuery('body');
	if ( _header.length > 0 ) {
		jQuery(window).scroll(function(){
			if ( jQuery(window).scrollTop() > 0 ) {
				var height = jQuery('#wpadminbar').outerHeight();
				_header.addClass('compact').css({'top' : height});
				_body.css({'paddingTop' : _header.outerHeight()});
			} else {
				_header.removeClass('compact').css({'top' : ''});
				_body.css({'paddingTop' : ''});
			}
		})
	}
}