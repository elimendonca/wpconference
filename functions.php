<?php
/**
 * wpconference functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage wpconference
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'wpconference_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override wpconference_setup() in a child theme, add your own wpconference_setup to your child theme's
 * functions.php file.
 */
function wpconference_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on toolbox, use a find and replace
	 * to change 'wpconference' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wpconference', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpconference' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
}
endif; // wpconference_setup

/**
 * Tell WordPress to run wpconference_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'wpconference_setup' );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function wpconference_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'wpconference_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function wpconference_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'wpconference' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'wpconference' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second sidebar area', 'wpconference' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'wpconference_widgets_init' );

if ( ! function_exists( 'wpconference_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function wpconference_content_nav( $nav_id , $title= 'Post navigation') {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( $title, 'wpconference' ) ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wpconference' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wpconference' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wpconference' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wpconference' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // wpconference_content_nav


if ( ! function_exists( 'wpconference_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own wpconference_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function wpconference_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'wpconference' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'wpconference' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'wpconference' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'wpconference' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'wpconference' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'wpconference' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for wpconference_comment()

if ( ! function_exists( 'wpconference_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own wpconference_posted_on to override in a child theme
 *
 */
function wpconference_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'wpconference' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'wpconference' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 */
function wpconference_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'wpconference_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 */
function wpconference_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so wpconference_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so wpconference_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in wpconference_categorized_blog
 *
 */
function wpconference_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'wpconference_category_transient_flusher' );
add_action( 'save_post', 'wpconference_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function wpconference_enhanced_image_navigation( $url ) {
	global $post;

	if ( wp_attachment_is_image( $post->ID ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'wpconference_enhanced_image_navigation' );


/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */

// Add Thumbnail Support for Theme (introduced in 2.9)
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    }
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');




//Remove WordPress [gallery] shortcode embedded CSS
//http://zeo.unic.net.my/remove-wordpress-gallery-shortcode-embedded-css/
add_filter('gallery_style',
    create_function(
        '$css',
        'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
        )
    );




/*--------------------------------------------------Scripts Header Section and Slider ----------------------------------------------*/
// Load up our awesome theme options
//require_once ( get_stylesheet_directory() . '/theme-options.php' );




//add scripts to the header
function wpconference_scripts() { 
?>

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />

	
	<!-- Slider Script -->
		<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('#slider').nivoSlider({
				effect:'sliceDown', //Specify sets like: 'fold,fade,sliceDown,sliceUpDown'
				animSpeed:500,
				pauseTime:6000,
				startSlide:0, //Set starting Slide (0 index)
				directionNav:false, //Next & Prev
				directionNavHide:false, //Only show on hover
				controlNav:false, //1,2,3...
				controlNavThumbs:false, //Use thumbnails for Control Nav
		      	controlNavThumbsFromRel:false, //Use image rel for thumbs
				controlNavThumbsSearch: 'check.jpg', //Replace this with...
				controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
				keyboardNav:false, //Use left & right arrows
				pauseOnHover:false, //Stop animation while hovering
				manualAdvance:false, //Force manual transitions
				captionOpacity:0.8, //Universal caption opacity
				beforeChange: function(){},
				afterChange: function(){},
				slideshowEnd: function(){} //Triggers after all slides have been shown
			});
		});
		</script>
	<!-- #Sliser Script -->	
    
    
 	<?php   
 		global $conf_sched; 		
		$footer_color = $conf_sched->get_option('footer-color','#111'); 
		
		$ha_color = $conf_sched->get_option('ha-color','#3399FF'); 
		$ha_rgb = hex2dec($ha_color);  

		$trodd_color = $conf_sched->get_option('trodd-color','#ffffff'); 
		$trodd_rgb = hex2dec($trodd_color); 
		
		$treven_color = $conf_sched->get_option('treven-color','#A3D6F5'); 
		$treven_rgb = hex2dec($treven_color); 
		
		?>
    
    <!-- Add here any style depending on options -->
	<STYLE type="text/css">
 	
		#colophon, .copyright{ background-color:<?php echo $footer_color;?>;}
	
		a:link, a:visited, a:hover, a:active, textarea:focus, input:focus,
		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {	color:rgb(<?php echo $ha_rgb['r'];?>,<?php echo $ha_rgb['g'];?>,<?php echo $ha_rgb['b']?>); }
		textarea:focus, input:focus{	border: solid rgb(<?php echo $ha_rgb['r'];?>,<?php echo $ha_rgb['g'];?>,<?php echo $ha_rgb['b']?>); }
		
		tr.odd{ background-color:rgba(<?php echo $trodd_rgb['r'];?>,<?php echo $trodd_rgb['g'];?>,<?php echo $trodd_rgb['b'];?>,0.6);}
		tr.even{ background-color:rgba(<?php echo $treven_rgb['r'];?>,<?php echo $treven_rgb['g'];?>,<?php echo $treven_rgb['b'];?>,0.6);}
		
	</STYLE>
	

<?php }
add_action('wp_head','wpconference_scripts');

function hex2dec($hex) {
 	 $color = STR_REPLACE('#', '', $hex);
 	 $ret = ARRAY(
 	 'r' => HEXDEC(SUBSTR($color, 0, 2)),
   	 'g' => HEXDEC(SUBSTR($color, 2, 2)),
   	 'b' => HEXDEC(SUBSTR($color, 4, 2))
  );
  RETURN $ret;
}

function wpconference_enqueue_scripts() {
    // only on the front end; don't mess with Admin scripts
    if ( ! is_admin() ) {
        // Only enqueue the core-bundled jQuery script
        wp_deregister_script('jquery');//deregister current jquery
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1', false);//load jquery from google api, and place in footer
		wp_enqueue_script('jquery');
        // Register our nivo slider script, dependent upon jquery
        wp_register_script( 'nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', 'jquery' );
        // Enqueue nivo slicer script
        wp_enqueue_script( 'nivo' );
     
    }
}
// Enqueue at proper hook
add_action( 'wp_enqueue_scripts', 'wpconference_enqueue_scripts' );


function wpconference_admin_enqueue_scripts()
{
	
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	
	// Register file for conference amdin utils
	wp_register_script( 'conference', get_template_directory_uri() . '/js/conference.js', 'jquery' );
    // Enqueue superfish script
    wp_enqueue_script( 'conference' );
	
}

function wpconference_admin_styles(){
	wp_enqueue_style('thickbox'); // needed for pretty upload media box
}

add_action('admin_enqueue_scripts','wpconference_admin_enqueue_scripts');
add_action('admin_print_styles', 'wpconference_admin_styles');

/*--------------------------------------------------Scripts Header Section ------------------------------------------*/




/*-------------------------------------------------- Slider ----------------------------------------------*/
/*
===============================================================
Custom Post Type For Slider
===============================================================
*/

		add_action('init', 'wpconference_slider_post_type');
	
		function wpconference_slider_post_type() {
	    	$args = array(
	        	'label' => __('Slider'),
	        	'singular_label' => __('Slide'),
	        	'public' => true,
	        	'show_ui' => true,
	        	'capability_type' => 'post',
	        	'hierarchical' => false,
	        	'rewrite' => true,
        		'labels' => array(
					'name' => __( 'Slides' ),
					'singular_name' => __( 'Slide' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Slide' ),
					'edit' => __( 'Edit' ),
					'edit_item' => __( 'Edit Slide' ),
					'new_item' => __( 'New Slide' ),
					'view' => __( 'View Slide' ),
					'view_item' => __( 'View Slide' ),
					'search_items' => __( 'Search Slides' ),
					'not_found' => __( 'No slides found' ),
					'not_found_in_trash' => __( 'No slides found in Trash' ),
					'parent' => __( 'Parent Slide' ),
				),
	        	'supports' => array('title', 'thumbnail')
	        );
	
	    	register_post_type( 'slide' , $args );
		
		
		
/*
===============================================================
Options For Slider
===============================================================
*/
	
		add_action("admin_init", "wpconference_admin_init");
		add_action('save_post', 'wpconference_save_slide_meta');
	
		function wpconference_admin_init(){
			add_meta_box("slider-meta", "Slider Options", "wpconference_meta_options", "slide", "normal", "low");
		}
	
		function wpconference_meta_options(){
			global $post;
			$custom = get_post_custom($post->ID);
			$text = $custom["text"][0];
			$link = $custom["link"][0];
	?>
	<p>Set a featured image for this slide using the built-in WordPress featured image feature which is normally located on the right hand side of this page.  </p><p>Then, enter a url (beginning with "http://") of a page, post, product, category or even an off-site link using the field below.</p><p>You can also add a caption or message that will slide up from the bottom of each slide.</p><br />
		<label style="width:80px;float:left;display:block;font-weight:bold;padding:5px;">Link URL:</label><input style="width:400px;border:1px solid #ccc;" name="link" value="<?php echo $link; ?>" /><br />
		<label style="width:80px;float:left;display:block;font-weight:bold;padding:5px;">Caption:</label><input style="width:400px;border:1px solid #ccc;" name="text" value="<?php echo $text; ?>" />
	<?php
		}
	
	function wpconference_save_slide_meta(){
		global $post;
		update_post_meta($post->ID, "text", $_POST["text"]);
		update_post_meta($post->ID, "link", $_POST["link"]);
	}
} //END OF CHECK FOR CUSTOM POST TYPE

	
		
/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = wpconference_vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
function wpconference_vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

	// this is an attachment, so we have the ID
	if ( $attach_id ) { 
	
		$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
		
		
		$image_src[0] = str_replace("\\","/",$image_src[0]);
		$file_path = get_attached_file( $attach_id );
		$file_path = str_replace("\\","/",$file_path);
		$document_root = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
	
	// this is not an attachment, let's use the image url
	} else if ( $img_url ) {
	
		 if ( is_multisite() ) /* CHECK IF MULTISITE IS ENABLED */ {
	
	
			
			$file_path = parse_url( $img_url );
			global $blog_id;
			$file_path = $document_root .'/wp-content/blogs.dir/' . $blog_id . $file_path['path'];
			
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			
			$orig_size = @getimagesize( $file_path );
			
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		} /* IF MULTISITE IS NOT ENABLED */
		
		else {
		$file_path = parse_url( $img_url );
			$file_path = $document_root . $file_path['path'];
			
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			
			$orig_size = @getimagesize( $file_path );
			
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		} //END OF MULITSITE CHECK
	}
	
	$file_info = pathinfo( $file_path );
	$file_info = str_replace("\\","/",$file_info);
	$extension = '.'. $file_info['extension'];

	// the image path without the extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// checking if the file size is larger than the target size
	// if it is smaller or the same size, stop right here and return
	if ( $image_src[1] > $width || $image_src[2] > $height ) {

		// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
		if ( file_exists( $cropped_img_path ) ) {

			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			
			$vt_image = array (
				'url' => $cropped_img_url,
				'width' => $width,
				'height' => $height
			);
			
			return $vt_image;
		}

		// $crop = false
		if ( $crop == false ) {
		
			// calculate the size proportionaly
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// checking if the file already exists
			if ( file_exists( $resized_img_path ) ) {
			
				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

				$vt_image = array (
					'url' => $resized_img_url,
					'width' => $proportional_size[0],
					'height' => $proportional_size[1]
				);
				
				return $vt_image;
			}
		}

		// no cache files - let's finally resize it
		
		$new_img_path = image_resize( $file_path, $width, $height, $crop );
		$new_img_size = @getimagesize( $new_img_path );
		
		
	
		
		$new_img = str_replace( basename( (string) $image_src[0] ), basename((string) $new_img_path ), $image_src[0] );

		
		
		// resized output
		$vt_image = array (
			'url' => $new_img,
			'width' => $new_img_size[0],
			'height' => $new_img_size[1]
		);
		
		return $vt_image;
	}

	// default output - without resizing
	$vt_image = array (
		'url' => $image_src[0],
		'width' => $image_src[1],
		'height' => $image_src[2]
	);
	
	return $vt_image;
}

/*--------------------------------------------------# Slider ----------------------------------------------*/


/*--------------------------------------------------Plugin conf schedule ------------------------------------------*/
/*  Copyright 2010 Simon Wheatley

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

/**
 * Hooks the Conference Scheduler custom action cs_pre_speakers_shortcode to:
 * * Remove the excerpt hook that TwentyTen put in
 *
 * @param  
 * @return void
 * @author Simon Wheatley
 **/
function wpconference_pre_participants_shortcode() {
	remove_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );
}
add_action( 'cs_pre_participants_shortcode', 'wpconference_pre_participants_shortcode' );

/**
 * Hooks the Conference Scheduler custom action cs_pre_speakers_shortcode to:
 * * Remove the excerpt hook that TwentyTen put in
 *
 * @param  
 * @return void
 * @author Simon Wheatley
 **/
function wpconference_post_participants_shortcode() {
	add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );
}
add_action( 'cs_post_participants_shortcode', 'wpconference_post_participants_shortcode' );



/* populate with sample data */
function wpconference_autoinstall_admin_header()
{
	global $wpdb;
	if(strstr($_SERVER['REQUEST_URI'],'themes.php') && $_REQUEST['template']=='' && $_GET['page']=='') 
	{
		
		if($_REQUEST['dummy']=='del')
		{
			delete_dummy_data();	
			$dummy_deleted = '<p><b>All Dummy data has been removed from your database successfully!</b></p>';
		}
		if($_REQUEST['dummy_insert'])
		{
			require_once (TEMPLATEPATH . '/includes/auto_install.php');
		}
		if($_REQUEST['activated']=='true')
		{
			$theme_actived_success = '<p class="message">Theme activated successfully.</p>';	
		}
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
		if($post_counts>0)
		{
			$dummy_data_msg = '<p> <b>Sample data has been populated on your site. Wish to delete sample data?</b> <br />  <a class="button_delete" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p>';
		}else
		{
			$dummy_data_msg = '<p> <b>Would you like to auto install this theme and populate sample data on your site? <br/>Please be aware this will erase any previous settings you must have added.</b> <br />  <a class="button_insert" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy_insert=1">Yes, insert sample data please</a></p>';
		}


		define('THEME_ACTIVE_MESSAGE','
	<style>
	.highlight { width:60% !important; background:#FFFFE0 !important; overflow:hidden; display:table; border:2px solid #558e23 !important; padding:15px 20px 0px 20px !important; -moz-border-radius:11px  !important;  -webkit-border-radius:11px  !important; } 
	.highlight p { color:#444 !important; font:15px Arial, Helvetica, sans-serif !important; text-align:center;  } 
	.highlight p.message { font-size:13px !important; }
	.highlight p a { color:#ff7e00; text-decoration:none !important; } 
	.highlight p a:hover { color:#000; }
	.highlight p a.button_insert 
		{ display:block; width:230px; margin:10px auto 0 auto;  background:#5aa145; padding:10px 15px; color:#fff; border:1px solid #4c9a35; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
	.highlight p a:hover.button_insert { background:#347c1e; color:#fff; border:1px solid #4c9a35;   } 
	.highlight p a.button_delete 
		{ display:block; width:140px; margin:10px auto 0 auto; background:#dd4401; padding:10px 15px; color:#fff; border:1px solid #9e3000; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
	.highlight p a:hover.button_delete { background:#c43e03; color:#fff; border:1px solid #9e3000;   } 
	#message0 { display:none !important;  }
	</style>
	
	<div class="updated highlight fade"> '.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>');
		echo THEME_ACTIVE_MESSAGE;
		
	}
}
	
add_action("admin_head", "wpconference_autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.

/*--------------------------------------------------End of Plugin conf schedule ------------------------------------------*/

/*------------------------------------------------- Add Suport for Posts Thumbnails --------------------------------------*/
add_theme_support( 'post-thumbnails' );





/*------------------------------------------------- Progam Utils --------------------------------------*/

    function wpconference_is_odd($number) 
    {
   		return $number & 1; // 0 = even, 1 = odd
	}
	
	function wpconference_sessions2slots($sessions)
	{
		// key -> session id - value -> slot 
		$slots = array();
		$slot = array();
		$previous_slot_time = '';
		
		$dayschedule = array();
		
		foreach ($sessions as $session) :
			$time = get_session_slot($session->ID);
			if($time == null) continue;
			$session->slot = $time;
			
			if(empty($dayschedule[$time])) 
			{
				$dayschedule[$time] = array($session->ID);
			}
			else
			{
				array_push($dayschedule[$time], $session->ID);
			}
			
		endforeach;
		
		
		return $dayschedule;
	}


/*------------------------------------------------- #Program Utils --------------------------------------*/


/*-------------------------------------------------- Sponsors ----------------------------------------------*/
/*
===============================================================
Custom Post Type For Sponsors
===============================================================
*/

		add_action('init', 'wpconference_sponsors_post_type');
	
		function wpconference_sponsors_post_type() {
	    	$args = array(
	        	'label' => __('Sponsors'),
	        	'singular_label' => __('Sponsor'),
	        	'public' => true,
	        	'show_ui' => true,
	        	'capability_type' => 'post',
	        	'hierarchical' => false,
	        	'rewrite' => true,
        		'labels' => array(
					'name' => __( 'Sponsors' ),
					'singular_name' => __( 'Sponsor' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Sponsor' ),
					'edit' => __( 'Edit' ),
					'edit_item' => __( 'Edit Sponsor' ),
					'new_item' => __( 'New Sponsor' ),
					'view' => __( 'View Sponsor' ),
					'view_item' => __( 'View Sponsor' ),
					'search_items' => __( 'Search Sponsor' ),
					'not_found' => __( 'No sponsors found' ),
					'not_found_in_trash' => __( 'No sponsors found in Trash' ),
					'parent' => __( 'Parent Sponsor' ),
				),
	        	'supports' => array('title', 'thumbnail')
	        );
	
	    	register_post_type( 'sponsor' , $args );
		
		
		
/*
===============================================================
Options For Sponsor
===============================================================
*/
	
		add_action("admin_init", "wpconference_admin_init_sponsors");
		add_action('save_post', 'wpconference_save_sponsor_meta');
	
		function wpconference_admin_init_sponsors(){
			add_meta_box("slider-meta", "Sponsor Options", "wpconference_meta_options_sponsor", "sponsor", "normal", "low");
		}
	
		function wpconference_meta_options_sponsor(){
			global $post;
			$custom = get_post_custom($post->ID);
			$link = $custom["link"][0];
	?>
		<p><?php _e('Set a featured image for this sponsor using the built-in WordPress featured image feature which is normally located on the right hand side of this page.','wpconference')?></p><p><?php _e('Then, enter a url (beginning with "http://") of the sponsor site link using the field below.','wpconference'); ?></p><br />
		<label style="width:80px;float:left;display:block;font-weight:bold;padding:5px;">Link URL:</label><input style="width:400px;border:1px solid #ccc;" name="link" value="<?php echo $link; ?>" /><br />
	<?php
		}
	
	function wpconference_save_sponsor_meta(){
		global $post;
		update_post_meta($post->ID, "text", $_POST["text"]);
		update_post_meta($post->ID, "link", $_POST["link"]);
	}
} //END OF CHECK FOR CUSTOM POST TYPE
	
	











	
?>