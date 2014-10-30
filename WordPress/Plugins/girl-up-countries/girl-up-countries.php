<?php
/*
Plugin Name: GirlUp Countries by Spark Experience
Plugin URL: http://sparkexperience.com
Description: A plugin for countries.
Version: 1.0
Author: Spark Experience
Author URI: http://sparkexperience.com
*/

if(!class_exists('gup_countries')){
	class gup_countries {
		const POST_TYPE 	= 'gup_countries';
		
		public function __construct(){		
			//activation/deactivation hooks
			register_activation_hook(__FILE__,		array(&$this,	'activate'));
			register_deactivation_hook(__FILE__,	array(&$this,	'deactivate'));
			
			//custom actions
			add_action('admin_enqueue_scripts',		array(&$this,	'adminAssets'));
			add_action('init',						array(&$this,	'registerPostType'));
			add_action('init',						array(&$this,	'registerTaxonomy')); 
			add_action('add_meta_boxes',			array(&$this,	'createMetaBoxes'));
			add_action('save_post',					array(&$this,	'save'));
			
			//shortcode to display
			add_shortcode('countries',				array(&$this,	'displaygup_countries'));

			//frontend styles
			add_action('wp_enqueue_scripts',		array(&$this,	'frontendAssets'));
		}
		
		public function activate(){
			if (!current_user_can('activate_plugins')) return;
			
			//register the post type so that the rewrite rules get added properly - thanks wordpress
			$this->registerPostType();
			
			//flush the rewrite rules to add the specials permalinks
			flush_rewrite_rules();
		}
		
		public function deactivate(){
			if (!current_user_can('activate_plugins')) return;
			
			//get the global post types
			global $wp_rewrite;
			
			//check to see if the post type is removed so we can properly remove the slugs - thanks wordpress (again)
			if(isset($wp_rewrite->extra_permastructs[self::POST_TYPE])) unset($wp_rewrite->extra_permastructs[self::POST_TYPE]);
			
			//check to see if the taxonomy is removed so we can properly remove the slugs
			if(isset($wp_rewrite->extra_permastructs[self::TAXONOMY])) unset($wp_rewrite->extra_permastructs[self::TAXONOMY]);
			
			//flush the rewrite rules to remove the specials permalinks
			$wp_rewrite->flush_rules();
		}
		
		public function adminAssets(){			
			if ( get_post_type() == self::POST_TYPE ) {
				wp_enqueue_script( self::POST_TYPE.'_admin_js', plugin_dir_url(__FILE__).'js/doMap.js', array('jquery'));
				wp_register_style( 'doMapCss', plugin_dir_url(__FILE__).'css/styles.css', false, '1.0' );
				wp_enqueue_style( 'doMapCss' );
			}
		}

		public function frontendAssets(){			
			wp_enqueue_script( self::POST_TYPE.'_admin_js', plugins_url('girl-up-countries/js/frontendMap.js'), array('jquery'));
			wp_register_style( 'frontMapCss', plugins_url('girl-up-countries/css/styles.css'), false, '1.0' );
			wp_enqueue_style( 'frontMapCss' );
		}
		
		public function registerPostType(){
			// Countries
			$labels = array(
				'name'               => _x( 'Countries', 'post type general name' ),
				'singular_name'      => _x( 'Country', 'post type singular name' ),
				'add_new'            => _x( 'Add New Country', 'book' ),
				'add_new_item'       => __( 'Add New Country' ),
				'edit_item'          => __( 'Edit Country' ),
				'new_item'           => __( 'New Country' ),
				'all_items'          => __( 'All Countries' ),
				'view_item'          => __( 'View Country Page' ),
				'search_items'       => __( 'Search Countries' ),
				'not_found'          => __( 'No Countries found' ),
				'not_found_in_trash' => __( 'No Countries found in the Trash' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Countries'
			);
			$args = array(
				'labels'        => $labels,
				'description'   => 'Manage Homepage "countries" Map',
				'public'        => true,
				'menu_position' => 20,
				'hierarchical'	=> true,
				'supports'      => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'has_archive'   => true,
				'menu_icon'		=> 'dashicons-location-alt',
				'rewrite'       => array( 'slug' => 'focus-countries' ),
			);
			register_post_type( self::POST_TYPE, $args );
		}
		
		
		public function createMetaBoxes(){
			add_meta_box(self::POST_TYPE.'_coordinates',	'Map Location',		array(&$this,'coordinates'),	self::POST_TYPE, 'normal');
		}
		
		public function coordinates(){
			global $post;
			$coordinates_x = get_post_meta( $post->ID, 'coordinates_x', true );
			$coordinates_y = get_post_meta( $post->ID, 'coordinates_y', true );
			?>
			<input type="hidden" name="coordinates_x" value="<?php echo $coordinates_x; ?>" />
			<input type="hidden" name="coordinates_y" value="<?php echo $coordinates_y; ?>" />
			<div id="gup-map"><div id="gup-map_marker"></div></div>
			<?
		}
		
		public function save(){
			global $post;
			
			//make sure it is not an auto save
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post->ID;
			
			//also make sure that it is the specials post type
			if(get_post_type() != self::POST_TYPE) return $post->ID;
			
			//save the post meta
			update_post_meta($post->ID,	'coordinates_x', $_POST['coordinates_x']);
			update_post_meta($post->ID,	'coordinates_y', $_POST['coordinates_y']);
		}


		public function displaygup_countries($atts) {
			extract(shortcode_atts(array(
			    'cat'		=> '',
			    'tpl'		=> 'default.php',
			    'limit'		=> -1,
			    'orderby'	=> 'menu_order',
			    'order'		=> 'ASC'
			), $atts));


			$args = array(
				'post_type'				=> self::POST_TYPE,
				'post_status'			=> 'publish',
				'posts_per_page'		=> $limit,
				'order'					=> $order,
				'orderby'				=> $order
			);

			ob_start();

			$loop = new WP_Query($args);

			// Allow template override.
			$in_theme = locate_template( '/gup_countries/'.$tpl );

			if ( !empty($in_theme) ) {
				include($in_theme);
			} else {
				include('tpl/'.$tpl);
			}

			wp_reset_query();

			return ob_get_clean();
		}
	}

	//initialize the plugin
	$gup_countries = new gup_countries();
}