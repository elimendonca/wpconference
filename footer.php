<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		
		<div id="footer-content"> 
		
		<!-- sponsors -->
		<div id="sponsors">
		
			<?php 
			$loop = new WP_Query( array( 'post_type' => 'sponsor' ) );

			if($loop->have_posts())		
				_e('SPONSORS','wpconference');
			
		
			while ( $loop->have_posts() ) : $loop->the_post();
			
			$sponsorurl = get_post_meta($post->ID, "link", true);
			?>
				<div class="sponsor">
				
				<a href="<?php echo $sponsorurl?>">
					<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( large,'participant-lineup' ); ?>
					<?php endif; ?>
				</a>
				
				
				</div>
				
			
			<?php 
			endwhile;
			?>
		</div>
		<!-- /sponsors -->
		
		<!-- copyright -->
		<div class="copyright">
			<?php 
				global $conf_sched; 
				$copy_name = $conf_sched->get_option('copyright-name',''); 
				$copy_year = $conf_sched->get_option('copyright-year','2012'); 
	
				if(isset($copy_name) && $copy_name!='')
				{
			?>
				
				<p class="copy">© Copyright <?php echo $copy_name.' '.$copy_year; ?> </p>
				<?php }?>
				<p class="copy">Powered by <a href="http://www.wpconferencetheme.com/" target="_blank">WP Conference Theme</a> </p>
				
			</div>
			
		<!-- /copyright -->
			
		</div>
		<!-- /footer-content -->
			
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>