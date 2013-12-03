<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'wpconference' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" role="banner">
	
	
	<?php //get site options for branding (tagline-dates; tagline-location; description) 
	global $conf_sched;
	$tagline_days= $conf_sched->get_option('tagline-days','');
	$tagline_location= $conf_sched->get_option('tagline-location','');
	$description= $conf_sched->get_option('description','');
	
	$logo_url = $conf_sched->get_option('upload-logo','');
	
	
	
	?>
		
	
		<hgroup>
			<h1 id="site-title">
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			
			<?php 
			if($logo_url=='')	{
				?><div class="confname"><?php  bloginfo( 'name' );?></div><?php  
			}
			else 
			{
				?><img src="<?php echo $logo_url;?>" alt="" title=""><?php 
			}
			?>
			</a>
			</h1>
	
		<?php if(!empty($tagline_days) || !empty($tagline_location)){?>
				<h2 id="site-description"><?php echo $tagline_days."<br/>".$tagline_location; ?></h2> 
		<?php }
			if(!empty($description))
			{?>
				<span class="description"><?php echo $description; ?></span>		
			<?php 
			}?>
		</hgroup>

		<nav id="access" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #access -->
	</header><!-- #branding -->

	<div id="main">