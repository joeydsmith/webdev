<?php
// Copy this file to your theme and rename if you would liek to overwrite it. 
// [gallery tpl="your_file.php"] will look for the file located in your theme folder.

// The Loop
if ( $img_loop->have_posts() ) :

	// Create some unique IDs
	$spk_gallery = uniqid();

	// Container
	echo '<div id="spk_gallery-' . $spk_gallery .'" class="spk_gallery">';
		
		// Large Images
		echo '<div class="spk_gallery-main flexslider">';
			echo '<ul class="slides">';
				while ( $img_loop->have_posts() ) : $img_loop->the_post();

					// Get the image file
					$image = wp_get_attachment_image_src( get_the_id() ,  'large');
	
					echo '<li>';
						echo '<img src="' . $image[0] . '" />';
						echo '<caption>' . get_the_excerpt() . '</caption>';
					echo '</li>';

				endwhile;
			echo '</ul>';
		echo '</div>';

		// Large Images
		echo '<div class="spk_gallery-carousel flexslider">';
			echo '<ul class="slides">';
				while ( $img_loop->have_posts() ) : $img_loop->the_post();

					// Get the image file
					$image = wp_get_attachment_image_src( get_the_id() ,  'thumbnail');

					echo '<li><img src="' . $image[0] . '" /></li>';

				endwhile;
			echo '</ul>';
		echo '</div>';

	// Close Container
	echo '</div>';

	// Flexlsider
	?>
	<script type="text/javascript">

		jQuery(document).ready( function() {

			jQuery('#spk_gallery-<?php echo $spk_gallery; ?>').each(function(){

				// Cache objects
				var _carousel = jQuery(this).find('.spk_gallery-carousel');
				var _main     = jQuery(this).find('.spk_gallery-main');

				// Prepare for some math
				var count     = jQuery(_carousel).find( '.slides li' ).length;

				// Set the width to show 4 at a time
				var thumb_w  = jQuery(window).width()/4;

				// Intialize thumbnail carousel
				jQuery(_carousel).flexslider({
					animation: "slide",
					controlNav: false,
					animationLoop: false,
					slideshow: false,
					itemWidth: thumb_w,
					itemMargin: 0,
					asNavFor: _main,
				});

				// Initialize main slider
				jQuery(_main).flexslider({
					animation: "slide",
					controlNav: false,
					animationLoop: false,
					slideshow: false,
					directionNav: true,
					sync: _carousel,
				});

			})
			
		});

	</script>

	<?

endif;