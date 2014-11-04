/*!
 * jQuery Title Swap
 * Swap title on window blur
 * http://sparkexperience.com
 * by SPARK Experience
 */

function titleSwap( k ) {

	// Cache Variables
	var g = jQuery(document);
	var h = (jQuery("body"), jQuery(window));
	var j = g.find("title").text();

	// Text
	k = k || "Don't forget to read this...";

	// Chity, chity; bang, bang.
	h.on("focus", function() {
		c(j), setTimeout(function() {
		    c("."), c(j)
		}, 1e3)
	}).on("blur", function() {
		c(k)
	});

	// Be a Magician
	function c(a) {
	    document.title = a;
	}
}