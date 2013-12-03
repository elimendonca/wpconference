<?php
/**
 * Template Name: Register page
 * Description: Progam page
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
				
				

					<?php get_template_part( 'content', 'page' ); ?>

					<?php //comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. 
				
				
				
				// Event ID
				global $conf_sched;
				// get conference days
				$event_id = $conf_sched->get_option('event-id',-1);
				// 2942981537
				
				if($event_id != -1) {
				
				
				// load the API Client library				
				include 'includes/Eventbrite.php';
				
				// Initialize the API client
				//  Eventbrite API / Application key (REQUIRED)
				//   http://www.eventbrite.com/api/key/
				//  Eventbrite user_key (OPTIONAL, only needed for reading/writing private user data)
				//   http://www.eventbrite.com/userkeyapi
				$authentication_tokens = array('app_key'  => 'TFWEUQQZQEOCZQOTG7',
				                               'user_key' => '12906044638790018181');
				$eb_client = new Eventbrite( $authentication_tokens );
				
				// For more information about the features that are available through the Eventbrite API, see http://developer.eventbrite.com/doc/
				
				// event_get example - http://developer.eventbrite.com/doc/events/event_get/
				$resp = $eb_client->event_get( array('id'=>$event_id) );
				print( Eventbrite::ticketWidget($resp->event) );
				
				}
				
				else 
				{ echo "<p>".__('Comming soon...','wpconference')."</p>"; }
					
				
				 ?>
				
		
								
								
								
				</div><!-- #content -->
		</div><!-- #primary -->


<?php get_footer(); ?>