<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpconference' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'wpconference' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
