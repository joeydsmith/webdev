jQuery(document).ready(function(){

	// Load country snapshot upon click of anchor
	jQuery(".gup-anchor").click(function() {

		var _id = jQuery(this).data("country");

		//Remove any active classes
		jQuery(".gup-anchor").removeClass("gup-active");

		//Add class to just clicked
		jQuery(this).addClass("gup-active");

		//Hide all country snapshots
		jQuery(".gup-country").removeClass("gup-show");

		//Show correct
		jQuery("#" + _id).addClass("gup-show");

	});

	// Use left nav to toggle countries
	jQuery("#gup-prev").click(function() {

		var _id 	 = jQuery(".gup-show").attr("id");
		var _current = jQuery("#" + _id).data("order");
		var _next    = 1;
		var _max     = jQuery(".gup-country").length;

		//Hide currently selected country
		jQuery("#" + _id).removeClass("gup-show");

		if(_current > 1) {
			_next = _current - 1;
		} else {
			_next = _max;
		}

		console.log(_next);

		//Show correct
		jQuery(".gup-country[data-order='" + _next + "']").addClass("gup-show");

		var _country_id = jQuery(".gup-country[data-order='" + _next + "']").attr('id');
		var _new_id = jQuery(".gup-show").attr("id");

		//Remove any active classes from anchors
		jQuery(".gup-anchor").removeClass("gup-active");

		//Add class to anchor with corrent data country
		jQuery(".gup-anchor[data-country='" + _new_id + "']").addClass("gup-active");

	});

	// Use right nav to toggle countries
	jQuery("#gup-next").click(function() {

		var _id 	 = jQuery(".gup-show").attr("id");
		var _current = jQuery("#" + _id).data("order");
		var _next    = 1;
		var _max     = jQuery(".gup-country").length;

		//Hide currently selected country
		jQuery("#" + _id).removeClass("gup-show");

		if(_current < _max) {
			_next = _current + 1;;
		} else {
			_next = 1;
		}

		console.log(_next);

		//Show correct
		jQuery(".gup-country[data-order='" + _next + "']").addClass("gup-show");

		var _country_id = jQuery(".gup-country[data-order='" + _next + "']").attr('id');
		var _new_id = jQuery(".gup-show").attr("id");

		//Remove any active classes from anchors
		jQuery(".gup-anchor").removeClass("gup-active");

		//Add class to anchor with corrent data country
		jQuery(".gup-anchor[data-country='" + _new_id + "']").addClass("gup-active");

	});

	
})
