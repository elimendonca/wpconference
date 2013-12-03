<?php
set_time_limit(0);
global $wpdb;




/* add users */
$user_meta = array(
				"user_add1"			=>	'',
				"user_add2"			=>	'',
				"user_city"			=>	'NY',
				"user_state"		=>	'NY',
				"user_country"		=>	'USA',
				"user_postalcode"	=>	'99345',
				"user_phone" 		=>	'6545222778',
				"user_twitter"		=>	'http://www.twitter.com/andrew',
				"user_photo"		=>	"",				
				"description"		=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam',
				"tl_dummy_content"	=>	'1',
				);
$user_data = array(
				"user_login"		=>	'contact@wpconferencetheme.com',
				"user_email"		=>	'contact@wpconferencetheme.com',
				"user_nicename"		=>	'Nuno Morgadinho',
				"user_url"			=>	'http://www.californiamoves.com',
				"display_name"		=>	'Andrew',
				"first_name"		=>	'Jacks',
				"last_name"			=>	'',
				);				
$user_info[] = array(
				'data'	=>	$user_data,
				'meta'	=>	$user_meta,
				);
require_once(ABSPATH.'wp-includes/registration.php');

$participants_ids_array = insert_users($user_info);

function insert_users($user_info)
{
	global $wpdb;
	$user_ids_array = array();
	for($u=0;$u<count($user_info);$u++)
	{
		if(!username_exists($user_info[$u]['data']['user_login']))
		{
			$last_user_id = wp_insert_user($user_info[$u]['data']);
			$user_ids_array[] = $last_user_id;
			$user_meta = $user_info[$u]['meta'];
			$user_role['agent'] = 1;
			update_usermeta($last_user_id, 'wp_capabilities', $user_role);
			foreach($user_meta as $key=>$val)
			{
				update_usermeta($last_user_id, $key, $val); // User mata Information Here
			}
		}
	}
	$user_ids = $wpdb->get_var("SELECT group_concat(user_id) FROM $wpdb->usermeta where meta_key like \"wp_capabilities\" and meta_value like \"%agent%\"");
	return explode(',',$user_ids);
}

/* add a few participants, both as Speakers and sponsors */

$tspeakers = wp_insert_term("Speaker", "participant-roles");

if(is_wp_error($tspeakers))
{
	$errordata = $tspeakers->error_data;
	$speaker_cat= $errordata['term_exists'];
}
else{
	$speaker_cat= $tspeakers['term_id'];
}


/*Add 2 locations for sessions*/
$room_location1 = wp_insert_term('Room 1','locations');
if(is_wp_error($room_location1))
{
	$errordata = $room_location1->error_data;
	
	$room_location1_cat = $errordata['term_exists'];
	
}
else{
	$room_location1_cat= $room_location1['term_id'];
}

$room_location2 = wp_insert_term('Room 2','locations');
if(is_wp_error($room_location2))
{
	$errordata = $room_location2->error_data;
	$room_location2_cat= $errordata['term_exists'];
}
else{
	$room_location2_cat= $room_location2['term_id'];
}




/*wp_insert_term("Organizers", "participant-roles");*/



/*dummy meta data for sessions*/


		$day1 = 935280000;
		$day2 = 935366400;				


	//session 1						
		$start_day = $day1;
		$start_hour = 8;
		$start_minute = 00;
		$end_day = $day1;
		$end_hour =8;
		$end_minute = 40;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session1_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session1_schedule_end =  mysql2date( 'U', $end_datetime );

	//session 2
						
		$start_day = $day1;
		$start_hour = 9;
		$start_minute = 00;
		$end_day = $day1;
		$end_hour = 9;
		$end_minute = 30;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session2_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session2_schedule_end =  mysql2date( 'U', $end_datetime );
		
	//session 3
						
		$start_day = $day1;
		$start_hour = 9;
		$start_minute = 00;
		$end_day = $day1;
		$end_hour = 9;
		$end_minute = 30;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session3_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session3_schedule_end =  mysql2date( 'U', $end_datetime );
		
		
		
	//session 4			
						
		$start_day = $day1;
		$start_hour = 10;
		$start_minute = 00;
		$end_day = $day1;
		$end_hour = 10;
		$end_minute = 30;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session4_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session4_schedule_end =  mysql2date( 'U', $end_datetime );
		
		
	//session 5			
						
		$start_day = $day2;
		$start_hour = 10;
		$start_minute = 00;
		$end_day = $day2;
		$end_hour = 10;
		$end_minute = 30;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session5_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session5_schedule_end =  mysql2date( 'U', $end_datetime );
		
	//session 6			
						
		$start_day = $day2;
		$start_hour = 10;
		$start_minute = 30;
		$end_day = $day2;
		$end_hour = 10;
		$end_minute = 30;
		
		$start_datetime = date( 'Y-m-d ', $start_day ) . "$start_hour:$start_minute:00";
		$session6_schedule_start =  mysql2date( 'U', $start_datetime );

		$end_datetime = date( 'Y-m-d ', $end_day ) . "$end_hour:$end_minute:00";
		$session6_schedule_end =  mysql2date( 'U', $end_datetime );
	

/*dummy imagens for speakers*/
$dummy_image_url_marie = 'dummy/marie.png';
$dummy_image_url_lincoln = 'dummy/lincoln.png';
$dummy_image_url_gandhi = 'dummy/gandhi.png';
$dummy_image_url_amelia = 'dummy/amelia.png';
$dummy_image_url_ada = 'dummy/ada.png';


/* create dummy speakers */
$post_meta = array();
$post_info[] = array(

		//Speakers
					array(
						"post_title"	=>	'Marie',
						"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
						"post_meta"		=>	$post_meta,
						"post_author"	=>	$participants_ids_array[array_rand($participants_ids_array)],
						"post_image"	=>	array($dummy_image_url_marie),
						"post_category"	=>	array(),
						"post_type"		=>  'participant',
						"post_tags"		=>	array()
						),
						
						array(
						"post_title"	=>	'Lincoln',
						"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
						"post_meta"		=>	$post_meta,
						"post_author"	=>	$participants_ids_array[array_rand($participants_ids_array)],
						"post_image"	=>	array($dummy_image_url_lincoln),
						"post_category"	=>	array(),
						"post_type"		=>  'participant',
						"post_tags"		=>	array()
						),
						
						array(
						"post_title"	=>	'Gandhi',
						"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
						"post_meta"		=>	$post_meta,
						"post_author"	=>	$participants_ids_array[array_rand($participants_ids_array)],
						"post_image"	=>	array($dummy_image_url_gandhi),
						"post_category"	=>	array(),
						"post_type"		=>  'participant',
						"post_tags"		=>	array()
						),
						
						array(
						"post_title"	=>	'Amelia',
						"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
						"post_meta"		=>	$post_meta,
						"post_author"	=>	$participants_ids_array[array_rand($participants_ids_array)],
						"post_image"	=>	array($dummy_image_url_amelia),
						"post_category"	=>	array(),
						"post_type"		=>  'participant',
						"post_tags"		=>	array()
						),
						
					array(
						"post_title"	=>	'Ada',
						"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
						"post_meta"		=>	$post_meta,
						"post_author"	=>	$participants_ids_array[array_rand($participants_ids_array)],
						"post_image"	=>	array($dummy_image_url_ada),
						"post_category"	=>	array(),
						"post_type"		=>  'participant',
						"post_tags"		=>	array()
						),
						
						
					//Slides
					array(
						"post_title"	=>	'Day 3',
						"post_content"	=>	'',
						"post_meta"		=>	array('text'=>'Day 3'),
						"post_image"	=>	array('dummy/day3.png'),
						"post_category"	=>	array(),
						"post_type"		=>  'slide',
						"post_tags"		=>	array()
						),
						array(
						"post_title"	=>	'Day 2',
						"post_content"	=>	'',
						"post_meta"		=>	array('text'=>'Day 2'),
						"post_image"	=>	array('dummy/day2.png'),
						"post_category"	=>	array(),
						"post_type"		=>  'slide',
						"post_tags"		=>	array()
						),
						array(
						"post_title"	=>	'Day 1',
						"post_content"	=>	'',
						"post_meta"		=>	array('text'=>'Day 1'),
						"post_image"	=>	array('dummy/day1.png'),
						"post_category"	=>	array(),
						"post_type"		=>  'slide',
						"post_tags"		=>	array()
						),
				
	//Sessions					
						array(
						"post_title"	=>	'Registration',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session1_schedule_start,'_cs_schedule_end'=>$session1_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						
						),
						
						array(
						"post_title"	=>	'Cursus ridilus tincidunt massa',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session2_schedule_start,'_cs_schedule_end'=>$session2_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						"taxonomies"    => array("locations"=>"Room 1"),
						"speaker"		=> 'Amelia'
						),
	
							array(
						"post_title"	=>	'A cum, non tempor cum',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session3_schedule_start,'_cs_schedule_end'=>$session3_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						"taxonomies"    => array("locations"=>"Room 2"),
						"speaker"		=> 'Gandhi'
						),
						
							array(
						"post_title"	=>	'Porta vut',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session4_schedule_start,'_cs_schedule_end'=>$session4_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						"taxonomies"    => array("locations"=>"Room 1"),
						"speaker"		=> 'Marie'
						),
						
							array(
						"post_title"	=>	'Sagittis parturient placerat',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session5_schedule_start,'_cs_schedule_end'=>$session5_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						"taxonomies"    => array("locations"=>"Room 2"),
						"speaker"		=> 'Gandhi'
						),
						
							array(
						"post_title"	=>	'Turpis, quis',
						"post_content"	=>	'',
						"post_meta"		=>	array('_cs_has_schedule'=>true,'_cs_schedule_start'=>$session6_schedule_start,'_cs_schedule_end'=>$session6_schedule_end),
						"post_category"	=>	array(),
						"post_type"		=>  'session',
						"post_tags"		=>	array(),
						"taxonomies"    => array("locations"=>"Room 2"),
						"speaker"		=> 'Lincoln'
						)
						
					);
					
foreach ($post_info as $new_post) {
	insert_posts($new_post);
}					





/* set conference days */

$wpconferencelogo = get_bloginfo('stylesheet_directory').'/images/logo-wpconference.png';


$options = array(
	"days" => "1999-08-22,1999-08-23",
	"time_format" => "g.ia",
	"short_time_format" => "ga",
	"rewrite_version" => "dbversion",
	"tagline-days" => "August 23-23 1999",
	"tagline-location" => "Lisbon Porgual",
	"description" =>"In est adipiscing rhoncus lectus ut porta odio nisi mauris mus pid purus sit porta! Auctor, massa cras, urna cursus. Ut in tincidunt dis rhoncus lorem. Hac! Hac cursus scelerisque placerat hac in cum tempor.",
	"upload-logo" =>$wpconferencelogo,
	"speakers-category" => $speaker_cat
);

$option_name = "conf_sched";
$newvalue = $options;

if ( get_option( $option_name ) != $newvalue ) {
    update_option( $option_name, $newvalue );
} else {
    $deprecated = ' ';
    $autoload = 'no';
    add_option( $option_name, $newvalue, $deprecated, $autoload );
}



/* set speakers category on settings page */

//	$option = get_option('conf_sched');

	
	// setting speakers category
//	$option[ 'speakers-category' ] = $speaker_cat;

	//setting conference days
	
	
	
	
	//update_option( 'conf_sched', $option );





function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = $post_info_arr['post_type'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			
			$taxonomy = "participant-roles";
			$tags = array("Speaker");

			wp_set_object_terms( $last_postid, $tags, $taxonomy);
			
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/png';
					$post_img['menu_order'] = $menu_order;
					$post_img['guid'] = $post_image[$m];
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
					//update_post_meta($last_postid, '_thumbnail_id', $last_postimage_id);
					
					add_post_meta($last_postid, '_thumbnail_id',$last_postimage_id);
				}
			}
			
			
			//use for sessions
		
			//"taxonomies" =>array("locations"=>$room_location2_cat),
			
			$post_taxonomies = $post_info_arr['taxonomies'];
			
			if($post_taxonomies)
			{
				wp_set_object_terms( $last_postid, $post_taxonomies, 'locations');
			}

			//"speaker"		=> 'Lincoln'
			$speaker_name = $post_info_arr['speaker'];
			if($speaker_name)
			{
				wp_set_object_terms( $last_postid, array($speaker_name), 'participants');
			}
			
		}
	}

	//returns last post inserted, useful for pricetable which only insertes one post
	if(isset($last_postid));
	return $last_postid;
}




/* create dummy schedule */

/* create dummy pages */

/* create dummy theme options */


global $upload_folder_path;
$folderpath = $upload_folder_path . "wp-content/uploads/dummy";
full_copy( TEMPLATEPATH."/images/dummy/", ABSPATH . $folderpath );
//full_copy( TEMPLATEPATH."/images/dummy/", ABSPATH . "wp-content/uploads/dummy/" );
function full_copy( $source, $target ) 
{
	
	
	
	
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");

	$year_path = ABSPATH;
	
	for($i=0;$i<count($imagepatharr);$i++)
	{	
	  if($imagepatharr[$i])
	  {
		  $year_path .= "wp-content/uploads/".$imagepatharr[$i]."/";
		  //echo "<br>";
		  if (!file_exists($year_path)){
		  	
		  	
		  	  mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		copy( $source, $target );
	}
}



// Insert Price Table
$table_prices = array(
		array(
				"title" => "Silver",
				"detail" => "conference day only",
				"features"=> array(
					array(
					"title" => " Super Early Bird",
					"sub" => "-"
					),
					array(
					"title" => " Early Bird",
					"sub" => "424$"
					),
					array(
					"title" => " Standard",
					"sub" => "295$"
					),
					array(
					"title" => "Walk in",
					"sub" => "395$"
					),
				) //#features
		),
		array(
				"title" => "Gold",
				"detail" => "1 day of workshops and conference",
				"features"=> array(
					array(
					"title" => " Super Early Bird",
					"sub" => "400"
					),
					array(
					"title" => " Early Bird",
					"sub" => "495$"
					),
					array(
					"title" => " Standard",
					"sub" => "695$"
					),
					array(
					"title" => "Walk in",
					"sub" => "965$"
					),
				) //#features
		),
		array(
				"title" => "Platinum",
				"detail" => "2 days of workshops and conference ",
				"features"=> array(
					array(
					"title" => " Super Early Bird",
					"sub" => "500"
					),
					array(
					"title" => " Early Bird",
					"sub" => "695$"
					),
					array(
					"title" => " Standard",
					"sub" => "895$"
					),
					array(
					"title" => "Walk in",
					"sub" => "995$"
					),
				) //#features
		)   
	
	);
	
	$price_table_info = $post_info[] =
	 	array(
			array(
				"post_title"	=>	'Dummy Price Table',
				"post_type"		=>  'pricetable',
				));
	
	
	$price_table_post = insert_posts($price_table_info);

	update_post_meta($price_table_post,'price_table', $table_prices);

	$pricetable_for_content = "[price_table id=".$price_table_post."]";

	
	
	// Setting up new pages
	 global $user_ID;

	 
	 // Page Speakers
	 
		 $new_page_speakers = array(
	        'post_title' => 'Speakers',
	        'post_status' => 'publish',
	        'post_author' => $user_ID,
	        'post_type' => 'page',
	    );
	    $post_id_speakers = wp_insert_post($new_page_speakers);
	    if ($post_id_speakers)
	        update_post_meta($post_id_speakers, '_wp_page_template', 'page-speakers.php');

	
     // Page Register
	 
		 $new_page_register = array(
	        'post_title' => 'Register',
	        'post_status' => 'publish',
	        'post_author' => $user_ID,
	        'post_type' => 'page',
			'post_content' => 'Register here!',
	    );
	    $post_id_register = wp_insert_post($new_page_register);
	    if ($post_id_register) 
	        update_post_meta($post_id_register, '_wp_page_template', 'page-register.php');
	       
	// Page Program
	     $new_page_program = array(
	        'post_title' => 'Program',
	        'post_status' => 'publish',
	        'post_author' => $user_ID,
	        'post_type' => 'page'
	    );
	    $post_id_program = wp_insert_post($new_page_program);
	    if ($post_id_program) 
	        update_post_meta($post_id_program, '_wp_page_template', 'page-program.php');
	        
     // Page PriceTable   
     
        $price_page_content = "We tried to make XYZ Conference as affordable as possible so that anyone could attend. In order to do so we’ve created a range of tickets from a full three-day Platinum ticket to a one-day only Silver Ticket.

							".$pricetable_for_content."
							
							WHAT’S INCLUDED IN THE TICKET?
							<ul>
								<li>Lunch for every day you attend, with all you can eat yummy dishes.</li>
								<li>Coffee breaks with delicious cakes and pastries.</li>
								<li>Free access to the Pre-Conference gathering, with great wines to taste and munchies.</li>
								<li>Free access to our epic After-Party, with drinks included!</li>
								<li>A swag bag like you’ve never seen.</li>
								<li>Free, unlocked Wi-Fi at the venue.</li>
							</ul>
							<blockquote>*Discounts
							
							<small>We have several discounts available to associations and groups. Discounts are not cumulative, not applicable to Super Early Bird prices and cannot be applied retroactively on closed sales.</small>
							
							*Groups
							
							<small>When you buy 5 tickets, you get 1 free, so if you’re booking at least 6 people from your company or organization, just email us first at contact@myconference.com and we’ll give you the 6th ticket free.</small></blockquote>";
	
		  $new_page_pricetable = array(
	        'post_title' => 'Prices',
	        'post_status' => 'publish',
	        'post_author' => $user_ID,
	        'post_type' => 'page',
	 		'post_content' => $price_page_content       
	    );
	    $post_id_prices = wp_insert_post($new_page_pricetable);
	    
	    
	   
	
	 
	 

 //   Create Nav Menu

	 $menu_id =   wp_create_nav_menu("theme default menu");
	 
	 if($menu_id){
	 
	 
	 	
	 // Add Home
	 wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ),
		'menu-item-position'  => 0, 
        'menu-item-status' => 'publish'));

	 	//then you set the wanted theme  location
 	 	$locations = get_theme_mod('nav_menu_locations');
 	   	$locations['primary'] = $menu_id;
 	   	
 	  
 	   	
   		set_theme_mod( 'nav_menu_locations', $locations );
	 
	 
	 // Add Program 
	 $myPage = get_page_by_title('Program');
	 	 
	 
		$itemData =  array(
			'menu-item-title' =>  __('Program'),
		    'menu-item-object-id' =>  $myPage->ID,
		    'menu-item-object' => 'page',
			'menu-item-position'  => 1, 
		    'menu-item-type'      => 'post_type',
		    'menu-item-status'    => 'publish'
	 	 );
		 
		wp_update_nav_menu_item($menu_id, 0, $itemData);
	
	// Add Speakers 
	 $myPage = get_page_by_title('Speakers');
	 
		$itemData =  array(
		    'menu-item-object-id' =>  $myPage->ID,
		    'menu-item-parent-id' => 0,
		    'menu-item-object' => 'page',
			'menu-item-position'  => 2,
		    'menu-item-type'      => 'post_type',
		    'menu-item-status'    => 'publish'
	 	 );
		 
		wp_update_nav_menu_item($menu_id, 0, $itemData);	
		

	// Add Prices 
	 $myPage = get_page_by_title('Prices');
	 
		$itemData =  array(
		    'menu-item-object-id' =>  $myPage->ID,
		    'menu-item-parent-id' => 0,
		    'menu-item-object' => 'page',
			'menu-item-position'  => 3,
		    'menu-item-type'      => 'post_type',
		    'menu-item-status'    => 'publish'
	 	 );
		 
		wp_update_nav_menu_item($menu_id, 0, $itemData);	
	 
		
	 // Add Register 
	 $myPage = get_page_by_title('Register');
	 
		$itemData =  array(
		    'menu-item-object-id' => $myPage->ID,
		 	'menu-item-classes' => 'register',
		    'menu-item-parent-id' => 0,
		    'menu-item-object' => 'page',
			'menu-item-position'  => 4,
		    'menu-item-type'      => 'post_type',
		    'menu-item-status'    => 'publish'
	 	 );
		 
		wp_update_nav_menu_item($menu_id, 0, $itemData);
		
	 
   	
	 }
   
    
	    
	 					
?>