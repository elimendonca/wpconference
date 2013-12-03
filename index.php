<?php
/**
 * Template Name: HomePage
 * Description: 
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			
			
			<div id="slider-frame">
			<div id="slider" class="nivoSlider">
			<?php //BEGIN Slider LOOP
			$loop = new WP_Query( array( 'post_type' => 'slide' ) );
			while ( $loop->have_posts() ) : $loop->the_post();
			$buttontext = get_post_meta($post->ID, "text", true);
			$buttonlink = get_post_meta($post->ID, "link", true);
			if(has_post_thumbnail()) {
			$thumb = get_post_thumbnail_id();
			
			//echo "thumbnail id".$thumb;
			
			$image = wpconference_vt_resize( $thumb, '', 960, 339, true );
			
			//the_post_thumbnail();
			
			}
			
			//caption is the image title
			
			?>
			<a href="<?php echo $buttonlink; ?>" title="<?php the_title(); ?>">
				<img alt="<?php the_title(); ?>" title="<h1><?php the_title(); ?></h1><?php echo $buttontext; ?>" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
			</a>
			
			<?php endwhile; //END SLIDER LOOP ?>

			</div><!-- /#slider -->
			<div class="clear"></div>
			</div> <!-- /#slider-frame -->
			
			
			
			 <div class="clearfix"></div>
					
			<!-- Latest Speakers -->
	        <h2 class="">Latest Speakers</h2>

			<?php 
				global $conf_sched; 
				
				$speakers_category = $conf_sched->get_option('speakers-category',-1); 
				if($speakers_category !=-1){ 
					$speaker = get_term($speakers_category, 'participant-roles');
					$conf_sched->shortcode_participants(array('role'=>$speaker->slug));	
				}else
				{
					_e("Please go to Conference settings page on admin menu under Settings and choose a participant role as your category",'wpconference');
				}
										
			?>

			</div><!-- #content -->
		</div><!-- #primary -->


<?php get_footer(); ?>