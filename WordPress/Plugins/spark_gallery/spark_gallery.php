<?php

/*
Plugin Name: SPARK Gallery
Plugin URI: http://your-plugin-url
Description: Use templates to override the default [gallery] shortcode
Version: 1.0
Author: SPARK Experience
Author URI: http://sparkexperience.com
*/


if ( !class_exists( 'spark_gallery' ) ) {
	class spark_gallery {

		public function __construct(){		
			// Remove the default WordPress gallery
			remove_shortcode( 'gallery' );

			// Let's define our own, dare we say, 'better' gallery shortcode
			add_shortcode( 'gallery', array( &$this, 'spark_gallery_shortcode' ) );

			// Oh flexslider... you're so awesome
			add_action( 'wp_enqueue_scripts', array( &$this, 'frontendAssets' ) );
		}

		public function frontendAssets(){			
			wp_enqueue_script( 'flexslider_js', plugin_dir_url(__FILE__) . 'flexslider/jquery.flexslider.js', array( 'jquery' ) );
			wp_register_style( 'flexslider_css', plugin_dir_url(__FILE__) . 'flexslider/flexslider.css', false, '1.0' );
			wp_enqueue_style( 'flexslider_css' );
		}

		// And, away we go!
		public function spark_gallery_shortcode( $atts, $content = null ) {

		    // Get provided IDs
		    extract( shortcode_atts( array(
		        'ids' => '',
		        'tpl' => 'spk_gallery.php'
		    ), $atts ) );

	    	// Arrrrrrgs
		 	$args = array(
		 				'post_type'      => 'attachment',
		 				'post_mime_type' => 'image/jpeg,image/gif,image/jpg,image/png',
		 				'post_status'    => 'inherit'
		 			);

		    if ( $ids != '' ) {
			 	
			 	// Get the attachments based on shortcode attributes
			 	$args['post__in'] = explode( ',', $ids );

			} else {
				
				// Get the post
				global $post;

				// Get the attachemnts for the parent post
				$args['post_parent'] = $post->ID;
			}

		 	// Output Buffer
			ob_start();

		 	// Initialize the loop
		 	$img_loop = new WP_Query( $args );

		 	// Find template in theme
			$in_theme = locate_template( $tpl );
			
			// If can find tempalte, include it
			if ( !empty( $in_theme ) ) { 

				// Include tempalte from theme folder
				include( $in_theme ); 

			} else {

				// Include default template from plugin folder
				include( 'spk_gallery.php' );

			} 

			// Reset Post Data
			wp_reset_postdata();

			// Output Buffer
			return ob_get_clean();
		}

	}

	//initialize the plugin
	$spark_gallery = new spark_gallery();
}

