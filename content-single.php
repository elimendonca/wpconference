<?php
/**
 * @package WordPress
 * @subpackage wpconference
 */
?>

<article id="post-<?php the_ID(); ?>">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php //wpconference_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
	
		<div class="sprogram">
        <?php 
    	    the_post_thumbnail('thumbnail');
        ?>
        </div>
	
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpconference' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	
</article><!-- #post-<?php the_ID(); ?> -->
