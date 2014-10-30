<?php

// [get_posts] shortcode
add_shortcode( 'get_posts', 'spk_get_posts' );
function spk_get_posts( $atts ) {

	$args = shortcode_atts( array(
		'tpl'		             => 'default.php',
		'category_name'          => '',      
		'category__and'          => '',        
		'category__in'           => '',         
		'category__not_in'       => '',      
		'tag'                    => '',                       
		'tag_id'                 => '',                          
		'tag__and'               => '',              
		'tag__in'                => '',                
		'tag__not_in'            => '',           
		'tag_slug__and'          => '',
		'tag_slug__in'           => '',  
		'post__in'               => '',            
		'post__not_in'           => '',
		'cat'                    => '',  
		'p'                      => '',                              
		'name'                   => '',           
		'post_parent'            => '',                   
		'post_type'              => 'any',
		'post_status'            => 'published',
		'posts_per_page'         => 10,       
		'posts_per_archive_page' => 10,         
		'nopaging'               => false,                   
		'paged'                  => get_query_var('page'),       
		'offset'                 => 0,                   
		'order'                  => 'DESC',                      
		'orderby'                => 'menu_order',                   
		'ignore_sticky_posts'    => false,      
		'meta_key'               => '',                    
		'meta_value'             => '',               
		'meta_value_num'         => '',              
		'meta_compare'           => '',                 
		's'                      => '',                              
		'exact'                  => false,                        
		'sentance'               => false                     
	), $atts );

	// Output Buffer
	ob_start();

	// Initialize Loop
	$loop = new WP_Query( $args );

	// Find template provided in $atts['tpl']
	$in_theme = locate_template( 'tpl/' . $args['tpl'] );

	// If can find tempalte, include it
	if ( !empty( $in_theme ) ) { include( $in_theme ); } else { echo 'Error: "tpl" invalid!'; }

	// Save the world
	wp_reset_query();

	// Output Buffer
	return ob_get_clean();
}