function fontSize() {
     var windowWidth = jQuery(window).width();
     var fontSize = (windowWidth / 100) + 1;
     jQuery('body').css({'fontSize' : fontSize + 'px'});
}

jQuery(window).resize(function(){ fontSize(); })