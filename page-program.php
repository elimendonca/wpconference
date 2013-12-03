<?php
/**
 * Template Name: Program page
 * Description: Progam page
 *
 * @package WordPress
 * @subpackage wpconference
 * @since wpconference 0.1
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
			
			<?php if(!has_sessions()) :?>
			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Upcoming...', 'twentyten' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but the schedule has not yet been published.', 'twentyten' ); ?></p>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->
			<?php exit(); endif; ?>		
			
			
			 <h1 class='entry-title'><?php the_title(); ?></h1>  
			
			<div id='entry-content'>
				
					
				
		<?php 
			global $conf_sched;

			
			// get conference days
			$days_string = $conf_sched->get_option('days');
			$days =explode(",", $days_string);
			
		
			// get number of locations
			
			$locations = get_terms('locations');
			$nlocation = count($locations);
			$l = 2; // second column first location
			
			$sessions = array();
			$i = 1; 
			
			// For each day list all the sessions.
			foreach ( $days as & $d ) :
				$day =  strtotime($d); // in timestamp 
				
				?>
				<h2><?php _e('Day ','conftheme'); echo $i?></h2>
				<table class="igsv-table">
					<thead>
						<tr class="row-1 odd">
							<th class="col-1 "><div><?php _e('Start Time','conftheme');?></div></th>
							<?php foreach ($locations as $location) :?>
								<th class="col-<?php echo $l?> "><div><?php echo $location->name; $l++;?></div></th>
							<?php endforeach;?>
							
							
						</tr>
					</thead>
					<tbody>
						<?php 
						
						
						
						$sessions = get_sessions_at(date('d',$day)); 
						
						$slots = wpconference_sessions2slots($sessions);
						
						$colid = 2;
						$l = 2; // second column first location
						
						foreach ($slots as $time=>$session_array) : 
							$control = false;
							wpconference_is_odd($colid) ? $trclass="odd" : $trclass="even"; $colid++;
						?>
							
							<tr class="row-2 <?php echo $trclass;?>">
								<td class="col-1 "><?php echo $time;?></td>
							
							
								<?php 
									//if for this slot there is only on session
									// with no location associated it should
									//ocuppie the all row
									if(count($session_array) == 1)
									{
										$unique_sessionid = $session_array[0];
										$session_location = get_session_location( $unique_sessionid); 
										if($session_location == -1){
											$title = get_session_title($unique_sessionid);
											
										?>									
										<td colspan="<?php echo $nlocation;?>" align="center" class="col-<?php echo $l?> ">
										 
										<?php
											echo $title;
											$control = true;
											?>
										
										</td>	
											<?php  
										}
														
									}  									
								?>
							
							
							
							
								<?php foreach ($locations as $location) :?>
								
								<?php if(!$control) {?>		
								<td class="col-<?php echo $l?> ">
									<div> 
								<?php }
											
											foreach ($session_array as $session_id) { ?>
											<?php 
												
												$session_location = get_session_location( $session_id); 
												$title = get_session_title($session_id);
												
												if($location->name == $session_location)
												{
													
													$speaker = get_session_speaker($session_id); 
													
													echo  $speaker.'<br/>'.$title; 
												}
											}	
																			 
										?>
										</div>
									</td>
							<?php endforeach;?>
							
							
								
					 		</tr>
							
					<?php	endforeach;  
						?>
					</tbody>
				</table>
				<?php 
				
			$i++;
			endforeach;
			
			?>
		
			
	
		
		<!-- css cleanup -->
		<div class="clearfix"></div>
					
								<?php 
				global $wp_query;
				wp_reset_query();
			//while ( have_posts() ) : the_post();?>
			<?php 		get_template_part( 'content', 'program' ); ?>
			<?php //endwhile; // end of the loop. ?>	
	
	
		</div><!-- #entry-content -->
			
	

			</div><!-- #content -->
		</div><!-- #primary -->


<?php get_footer(); ?>