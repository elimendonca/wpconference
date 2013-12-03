<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wpconference_content_nav( 'nav-above' ); ?>

				<?php  $post_type  = get_post_type($post);  if($post_type=='participant') $post_type='single' ;?>

				<?php get_template_part( 'content', $post_type ); ?>

				<?php //wpconference_content_nav( 'nav-below',__('Speakers Navigation','wpconference') ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>