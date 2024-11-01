<?php
/*
Plugin Name: Stories Post Type
Plugin URI: http://bestseller.franontanaya.com/?p=104
Description: Adds a custom post type called Stories with a last stories widget, three taxonomies: Works, Sections and Licenses, and a shortcode to list all works.
Author: Fran Ontanaya
Version: 1.2.2
Author URI: http://www.franontanaya.com

Copyright (C) 2010 Fran Ontanaya
contacto@franontanaya.com
http://bestseller.franontanaya.com/?p=104

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

load_plugin_textdomain( 'stories-post-type', '/wp-content/plugins/stories-post-type/languages/', 'stories-post-type/languages/' );

/* # Register custom post types and taxonomies
-------------------------------------------------------------- */
// This will register and make available the custom post type 'Stories'
// Note: it's 'stories' instead of 'story' to avoid collisions with hypothetical future official post types. 
// If you stop using this plugin, use a plugin like Post Type Switcher to change their type to posts.

function stories_post_type() {
	register_post_type(
		'stories', 
		array(
			'label' => __( 'Stories', 'stories-post-type' ), 
			'public' => true, 
			'show_ui' => true,
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'page-attributes',
				'custom-fields',
				'post-thumbnails',
				'excerpts',
				'comments',
				'revisions'
			)
		)
	); 

   register_taxonomy( 'works', 'stories', array( 'hierarchical' => true, 'label' => __( 'Works', 'stories-post-type' ) ) );  
   register_taxonomy( 'licenses', 'stories', array( 'hierarchical' => true, 'label' => __( 'Licenses', 'stories-post-type' ) ) );  
   register_taxonomy( 'sections', 'stories', array( 'hierarchical' => true, 'label' => __( 'Sections', 'stories-post-type' ) ) );  
	register_taxonomy_for_object_type( 'post_tag', 'stories' );
}
add_action( 'init', 'stories_post_type' );

/* # Prefill the taxonomies
-------------------------------------------------------------- */
function stories_pt_prefill_taxonomies() {
	if ( !get_option( 'stories_pt_prefill_taxonomies' ) ) {
		wp_insert_term(
			__( 'Public Domain', 'stories-post-type' ), // the term 
			'licenses', // the taxonomy
			array(
				'description' => __( 'Public Domain', 'stories-post-type' ),
				'slug' => 'pd'
			)
		);
		wp_insert_term(
			__( 'All rights reserved', 'stories-post-type' ), // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Copyright, ' . __( 'All rights reserved', 'stories-post-type' ),
				'slug' => 'c-arr'
			)
		);
		wp_insert_term(
			'Creative Commons', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons',
				'slug' => 'cc'
			)
		);
		$parent_term = term_exists( 'Creative Commons', 'licenses' ); // array is returned if taxonomy is given
		$parent_term_id = $parent_term[ 'term_id' ]; // get numeric term id
		wp_insert_term(
			'CC-By', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by',
				'parent'=> $parent_term_id
			)
		);
		wp_insert_term(
			'CC-By-ND', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . '-' . __( 'NoDerivs', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by-nd',
				'parent' => $parent_term_id
			)
		);
		wp_insert_term(
			'CC-By-NC-ND', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . '-' . __( 'NonCommercial', 'stories-post-type' ) . '-' . __( 'NoDerivs', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by-nc-nd',
				'parent' => $parent_term_id
			)
		);
		wp_insert_term(
			'CC-By-NC', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . '-' . __( 'NonCommercial', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by-nc',
				'parent' => $parent_term_id
			)
		);
		wp_insert_term(
			'CC-By-NC-SA', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . '-' . __( 'NonCommercial', 'stories-post-type' ) . '-' . __( 'ShareAlike', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by-nc-sa',
				'parent' => $parent_term_id
			)
		);
		wp_insert_term(
			'CC-By-SA', // the term 
			'licenses', // the taxonomy
			array(
				'description' => 'Creative Commons ' . __( 'Attribution', 'stories-post-type' ) . '-' . __( 'ShareAlike', 'stories-post-type' ) . ' 3.0',
				'slug' => 'cc-by-sa',
				'parent' => $parent_term_id
			)
		);

		wp_insert_term(
			__( 'Introductions', 'stories-post-type' ), // the term 
			'sections', // the taxonomy
			array(
				'description' => __( 'Introductory texts', 'stories-post-type' ),
				'slug' => 'introductions'
			)
		);
		wp_insert_term(
			__( 'Contents', 'stories-post-type' ), // the term 
			'sections', // the taxonomy
			array(
				'description' => __( 'The main body of text', 'stories-post-type' ),
				'slug' => 'contents'
			)
		);
		wp_insert_term(
			__( 'Notes', 'stories-post-type' ), // the term 
			'sections', // the taxonomy
			array(
				'description' => __( 'Notes and references', 'stories-post-type' ),
				'slug' => 'notes'
			)
		);
		wp_insert_term(
			__( 'Extras', 'stories-post-type' ), // the term 
			'sections', // the taxonomy
			array(
				'description' => __( 'Support and accesory content', 'stories-post-type' ),
				'slug' => 'extras'
			)
		);
		wp_insert_term(
			__( 'Discussions', 'stories-post-type' ), // the term 
			'sections', // the taxonomy
			array(
				'description' => __( 'Additional pages for discussion of the content', 'stories-post-type' ),
				'slug' => 'discussions'
			)
		);
	}
	update_option( 'stories_pt_prefill_taxonomies', true);
	return;
}
add_action( 'init', 'stories_pt_prefill_taxonomies' );

/* # Widget to output thumbnails list
-------------------------------------------------------------- */
class widget_stories_pt_recent extends WP_Widget {
	function widget_stories_pt_recent() {
		// widget actual processes
		parent::WP_Widget(false, $name = 'Recent Stories', array('description' => __( 'Displays the latest stories with their thumbnails and taxonomic terms', 'stories-post-type' ) ) );	
	}

	function form($instance) {
		// outputs the options form on admin
		$title = esc_attr( $instance[ 'title' ] );
		$display_thumbs = esc_attr( $instance[ 'display_thumbs' ] );
		$height = esc_attr( $instance[ 'height' ] );
		$width = esc_attr( $instance[ 'width' ] );
		$max_thumbs = esc_attr( $instance[ 'max_thumbs' ] );
		
		echo '<p><label for="', $this->get_field_id( 'title' ), '">', __( 'Title:', 'stories-post-type' ), ' <input class="widefat" id="', $this->get_field_id( 'title' ), '" name="', $this->get_field_name( 'title' ), '" type="text" value="', $title, '" /></label></p>';
		echo '<input type="hidden" name="', $this->get_field_id( 'display_thumbs' ), '" value="0" />';
		echo '<p><label for="', $this->get_field_id( 'max_thumbs' ), '">', __( 'Number of stories:', 'stories-post-type' ), ' <input class="widefat" id="', $this->get_field_id( 'max_thumbs' ), '" name="', $this->get_field_name( 'max_thumbs' ), '" type="text" value="', $max_thumbs, '" /></label></p>';
		echo '<p><label for="', $this->get_field_id( 'display_thumbs' ), '"">', __( 'Display thumbnails?', 'stories-post-type' ), ' <input class="widefat" id="', $this->get_field_id( 'display_thumbs' ), '" name="', $this->get_field_name( 'display_thumbs' ), '" type="checkbox" value="1" '; if( $display_thumbs == '1' ) { echo 'checked="checked"'; } echo '" /></label></p>';
		echo '<p><label for="', $this->get_field_id( 'height' ), '">', __( 'Thumbnail height:', 'stories-post-type' ), ' <input class="widefat" id="', $this->get_field_id( 'height' ), '" name="', $this->get_field_name( 'height' ), '" type="text" value="', $height, '" /></label></p>';
		echo '<p><label for="', $this->get_field_id( 'width' ), '">', __( 'Thumbnail width:', 'stories-post-type' ), ' <input class="widefat" id="', $this->get_field_id( 'width' ), '" name="', $this->get_field_name( 'width' ), '" type="text" value="', $width, '" /></label></p>';
	}

	function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'display_thumbs' ] = strip_tags( $new_instance[ 'display_thumbs' ] );
		$instance[ 'height' ] = strip_tags( $new_instance[ 'height' ] );
		$instance[ 'width' ] = strip_tags( $new_instance[ 'width' ] );
		$instance[ 'max_thumbs' ] = strip_tags( $new_instance[ 'max_thumbs' ] );
		return $instance;
	}

	function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( !$title ) $title = __( 'Recent stories', 'stories-post-type' );
		$title = esc_attr( strip_tags( $title ) );
		if ( !$instance[ 'height' ] ) { $height = 32; } else { $height = intval( $instance[ 'height' ] ); }
		if ( !$instance[ 'width' ] ) { $width = 32; } else { $width = intval( $instance[ 'width' ] ); }
		if ( !$instance[ 'max_thumbs' ] ) { $max_thumbs = 8; } else { $max_thumbs = intval( $instance[ 'max_thumbs' ] ); }
		
		echo '<li class="widget recent-stories-widget">',
			'<style type="text/css">',
				'.recent-stories { list-style: none; float:left; clear: both;}',
				'.recent-stories { display: block; clear:both; }',
				'.recent-stories h5 { color: #000; }',
				'.recent-stories img { float: left; margin-right: 5px; }',
			'</style>',
			'<h2 class="widgettitle recent-stories-title">', $title, '</h2>',
			'<ul class="recent-stories">';
				$recent_stories = new WP_Query();
				$recent_stories->query( 'showposts=' . $max_thumbs . '&post_type=stories&post_status=publish' );
				for($i=1; $i<=$recent_stories; $i++) {
					while ( $recent_stories->have_posts() ) {
						$recent_stories->the_post(); // loop for stories
						echo '<li class="recent-stories" id="recent-stories-', $i, '">',
							'<a href="'; the_permalink(); echo '" title="', esc_attr( strip_tags( get_the_title() ) ), '">';
							if ( $instance[ 'display_thumbs' ] ) {
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( array( $width, $height ), array( 'alt'=> esc_attr( strip_tags( get_the_title() ) ), 'title'=> esc_attr( strip_tags( get_the_title() ) ) ) );
								} else {
									echo '<img height="', $height, '" width="', $width, '" src="', bloginfo( 'wpurl' ), '/wp-content/plugins/stories-post-type/img/no-cover.png" />';
								}
							}
							echo '<h5>', get_the_title(), '</h5>',
						'</a>';
						the_taxonomies();
						echo '</li>';
					} 
				}
			echo '</ul>',
		'</li>';
	}
} // end class

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "widget_stories_pt_recent" );' ) );

/* # Shortcode to generate an index of works
-------------------------------------------------------------- */
function stories_pt_index( $atts = null, $content = null ) {
	return 
		'<div class="index-of-stories"><ul>' .
		wp_list_categories( 
				'title_li=' . 
				'&order=ASC' .
				'&orderby=name' .
				'&show_count=1' .
				'&hide_empty=1' .
				'&taxonomy=works' .
				'&echo=0'
			) .
		'</ul></div>'; 
}
add_shortcode( 'indexofstories', 'stories_pt_index' );

/* # Add support to Anthologize plugin
-------------------------------------------------------------- */
// This code should be deprecated by future Anthologize developments

function add_stories_pt_to_anthologize( $types ) {
	$types['stories'] = 'Stories';
	return $types;
}
add_filter( 'anth_available_post_types', 'add_stories_pt_to_anthologize' ); 

/* # Drag and drop Works order
-------------------------------------------------------------- */
//This is a customized copy of Category Order plugin, tailored to our custom Works taxonomy.

//Plugin URI: http://wpguy.com/plugins/category-order
//Description: The Category Order plugin allows you to easily reorder your categories the way you want via drag and drop.
//Author: Wessley Roche
//Version: 1.0.3
//Author URI: http://wpguy.com/
//License: GPL
	
function stories_pt_category_order_menu() {
	if ( function_exists( 'add_submenu_page' ) ) {
		add_submenu_page( 'edit.php?post_type=stories', __( 'Order Works', 'stories-post-type' ), __( 'Order Works', 'stories-post-type' ), 4, 'stories_pt_category_order_options', 'stories_pt_category_order_options' );
	}
}

function stories_pt_category_order_scriptaculous() {
	if( $_GET[ 'page' ] == 'stories_pt_category_order_options' ) {
		wp_enqueue_script( 'scriptaculous' );
	} 
}

add_action( 'admin_head', 'stories_pt_category_order_options_head' ); 
add_action( 'admin_menu', 'stories_pt_category_order_menu' );
add_action( 'admin_menu', 'stories_pt_category_order_scriptaculous' );

add_filter( 'get_terms', 'stories_pt_category_order_reorder', 10, 3 );

// This is the main function. It's called every time the get_terms function is called.
function stories_pt_category_order_reorder( $terms, $taxonomies, $args ) {
	
	// No need for this if we're in the ordering page.
	if ( isset( $_GET[ 'page' ]) && $_GET[ 'page' ] == 'stories_pt_category_order_options' ) { 
		return $terms;
	}
	
	// Apply to categories only and only if they're ordered by name.
	if($taxonomies[0] == "works" && $args['orderby'] == 'name' ){ // You may change this line for: `if($taxonomies[0] == "category" && $args['orderby'] == 'custom' ){` if you wish to still be able to order by name.
		$options = get_option("stories_pt_category_order");
		if(!empty($options)){
			// Put all the order strings together
			$master = "";
			foreach($options as $id => $option){
				$master .= $option.",";
			}
			$ids = explode(",", $master);
			// Add an 'order' item to every category
			$i=0;
			foreach($ids as $id){
				if($id != ""){
					foreach($terms as $n => $category){
						if(is_object($category) && $category->term_id == $id){
							$terms[$n]->order = $i;
							$i++;
						}
					}
				}
				
				// Add order 99999 to every category that wasn't manually ordered (so they appear at the end). This just usually happens when you've added a new category but didn't order it.
				foreach($terms as $n => $category){
					if(is_object($category) && !isset($category->order)){
						$terms[$n]->order = 99999;
					}
				}
			}
			// Sort the array of categories using a callback function
			usort($terms, "stories_pt_category_order_compare");
		}
	}
	return $terms;
}

// Compare function. Used to order the categories array.
function stories_pt_category_order_compare($a, $b) {
	if ($a->order == $b->order) {
		if($a->name == $b->name){
			return 0;
		}else{
			return ($a->name < $b->name) ? -1 : 1;
		}
	}
    return ($a->order < $b->order) ? -1 : 1;
}

function stories_pt_category_order_options(){
	if(isset($_GET['childrenOf'])){
		$childrenOf = $_GET['childrenOf'];
	}else{
		$childrenOf = 0;
	}
	
	$options = get_option("stories_pt_category_order");
	$order = $options[$childrenOf];
	
	if(isset($_GET['submit'])){
		$options[$childrenOf] = $order = $_GET['category_order'];
		update_option("stories_pt_category_order", $options);
		$updated = true;
	}
	
	// Get the parent ID of the current category and the name of the current category.
	$allthecategories = get_categories("taxonomy=works&hide_empty=0");
	if($childrenOf != 0){
		foreach($allthecategories as $category){
			if($category->cat_ID == $childrenOf){
				$father = $category->parent;
				$current_name = $category->name;
			}
		}
	}
	
	// Get only the categories belonging to the current category
	$categories = get_categories("taxonomy=works&hide_empty=0&child_of=$childrenOf");
	
	// Order the categories.
	if($order){
		$order_array = explode(",", $order);
		$i=0;
		foreach($order_array as $id){
			foreach($categories as $n => $category){
				if(is_object($category) && $category->term_id == $id){
					$categories[$n]->order = $i;
					$i++;
				}
			}
			
			foreach($categories as $n => $category){
				if(is_object($category) && !isset($category->order)){
					$categories[$n]->order = 99999;
				}
			}
		}		
		usort($categories, "stories_pt_category_order_compare");		
	}

	echo '<div class="wrap">';
		if(isset($updated) && $updated == true) {
			echo '<div id="message" class="fade updated"><p>', __( 'settings saved.', 'stories-post-type' ), '</p></div>';
		}
		
		echo '<form action="'; bloginfo("wpurl"); echo '/wp-admin/edit.php" class="GET">',
			'<input type="hidden" name="post_type" value="stories" />',
			'<input type="hidden" name="page" value="stories_pt_category_order_options" />',
			'<input type="hidden" id="category_order" name="category_order" size="500" value="', $order, '">',
			'<input type="hidden" name="childrenOf" value="', $childrenOf, '" />',
		'<h2>', __( 'Works Order', 'stories-post-type' ), '</h2>';

		if($childrenOf != 0) {
			echo '<p><a href="'; bloginfo("wpurl"); echo '/wp-admin/edit.php?post_type=stories&page=stories_pt_category_order_options&amp;childrenOf=', $father, '">', __( '&laquo; Back', 'stories-post-type' ), '</a></p>',
				'<h3>', $current_name, '</h3>';
		} else {
			echo '<h3>', __( 'Top level works','stories-post-type' ), '</h3>';
		}
		
		echo '<div id="container">
			<div id="order">';
				foreach($categories as $category) {
					if($category->parent == $childrenOf){
						echo "<div id='item_$category->cat_ID' class='lineitem'>";
						if(get_categories("taxonomy=works&hide_empty=0&child_of=$category->cat_ID")){
							echo "<span class=\"childrenlink\"><a href=\"".get_bloginfo("wpurl")."/wp-admin/edit.php?post_type=stories&page=stories_pt_category_order_options&childrenOf=$category->cat_ID\">", __( 'More &raquo;','stories-post-type' ),"</a></span>";
						}
						echo "<h4>$category->name</h4>";
						echo "</div>\n";
					}
				}

			echo '</div>
			<p class="submit"><input type="submit" name="submit" Value="', __( 'Order Works','stories-post-type' ), '"></p>
		</div>
		</form>
	</div>';
}

// CSS and Javascript for Category Order
function stories_pt_category_order_options_head(){
	if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == "stories_pt_category_order_options" ) {
		echo '<style>
		#container {
			list-style: none;
			width: 225px;
		}
		.childrenlink {
			float: right;
			font-size: 12px;
		}
		.lineitem {
			background-color: #ddd;
			color: #000;
			margin-bottom: 5px;
			padding: .5em 1em;
			width: 200px;
			font-size: 13px;
			-moz-border-radius: 3px;
			-khtml-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			cursor: move;
		}
		.lineitem h4{
			font-weight: bold;
			margin: 0;
		}
	</style>

	<script language="JavaScript">
		window.onload = function(){
			Sortable.create( "order",{tag:"div", onChange: function(){ refreshOrder(); }});
		
			function refreshOrder(){
				$("category_order").value = Sortable.sequence( "order" );
			}
		}
	</script>';
	}
} // end stories_pt_category_order_options_head()

/* # Add our stories to Google XML Sitemap plugin's output 
-------------------------------------------------------------- */
// This code may be deprecated by future versions of Google XML Sitemap.
// Forum is here: http://wordpress.org/tags/google-sitemap-generator

function sitemap_stories() {
	$generatorObject = &GoogleSitemapGenerator::GetInstance(); //Please note the "&" sign for PHP4!
	if ( $generatorObject != null ) {

		$priority = esc_attr( get_option( 'stories_pt_sitemap_priority' ) );
		if ( !$priority ) { $priority = 0.5; }
		$frequency= esc_attr( get_option( 'stories_pt_sitemap_frequency' ) );
		if ( !$frequency ) { $frequency = 'weekly'; }

		// Query for stories
		$my_stories = new WP_Query();
		$my_stories->query( 'showposts=' . $max_thumbs . '&post_type=stories&post_status=publish' );
		for ( $i=1; $i<=$my_stories; $i++ ) {
			while ( $my_stories->have_posts() ) {
				$my_stories->the_post(); // loop for stories
				$generatorObject->AddUrl( get_the_permalink(), time(), $frequency, $priority );
			}
		}
	}
	add_action("sm_buildmap","sitemap_stories");
}
?>