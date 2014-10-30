<?php

if ( $loop->have_posts() ) { 

	echo "<div id='gup-countries-container'>";

	echo "<div id='gup-map'>";

		$counter = 1;

		while ( $loop->have_posts() ) {

			$loop->the_post();
			$x_axis = get_post_meta( get_the_ID(), 'coordinates_x', true ); 
			$y_axis = get_post_meta( get_the_ID(), 'coordinates_y', true ); 

			echo "<div class='gup-anchor ";
				if($counter == 1) { echo "gup-active"; } 
			echo "' style=' left: ";

				if(!empty($x_axis)) { 
					echo $x_axis; 
				}  

			echo "; top: ";

				if(!empty($y_axis)) { 
					echo $y_axis; 
				}  

			echo ";' data-country='gup-ctry-" . get_the_ID() . "'></div>";

			$counter++;

		}

	echo "</div>";

	echo "<div id='gup-control'>";
		echo "<div id='gup-prev'><a href='javasctip:;'></a></div>";

		$counter = 1;

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$image  = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()),  'country-thumbnail' );

			echo "<div class='gup-country "; 
			 	if($counter == 1) { echo "gup-show"; } 
			echo "' id='gup-ctry-" . get_the_ID() . "' data-order='" . $counter . "'>";
				echo "<h2>" . get_the_title() . "</h2>";
				echo "<p>" . get_the_excerpt() . "<br />";
				echo "<a href='" . get_the_permalink() . "'>Learn More > </a></p>";
			echo "</div>";

			$counter++;

		}

		echo "<div id='gup-next'><a href='javasctip:;'></a></div>";
	echo "</div>";

	echo "</div>";

} 