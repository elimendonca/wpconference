<?php
/**
 * Template Name: Speakers page
 * Description: Speakers page
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">
		
		<h1 class='entry-title'><?php the_title(); ?></h1>

			<?php 
				global $conf_sched; 
				
				$speakers_category = $conf_sched->get_option('speakers-category',-1); 
				if($speakers_category !=-1){ 
					$speaker = get_term($speakers_category, 'participant-roles');
					$conf_sched->shortcode_participants(array('role'=>$speaker->slug));	
				}else
				{
					_e("To be annouced...",'wpconference');
				}
										
			?>
	</div> <!-- #content -->
	</div> <!--  #primary -->
	
	<?php get_footer(); ?>