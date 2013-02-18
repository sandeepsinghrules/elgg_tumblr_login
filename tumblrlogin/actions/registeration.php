 <?php 

					global $CONFIG;
		
		
					$ts = time();
					$token = generate_action_token($ts);
					
					$username = $_GET['tusername'];

					$action_url = $CONFIG->wwwroot."action/tumblrlogin/register/?__elgg_ts=".$ts."&__elgg_token=".$token."&tusername=".$username;
		
		
					$area2 = elgg_view_title(elgg_echo('Registration Using Tumbler'));
				  
					
					$area2 .= elgg_view("tumblrlogin/registerview", array('action_url' => $action_url));

					$body = elgg_view_layout("two_column_left_sidebar", '',$area2);

				
					page_draw(elgg_echo('Registration Using Tumbler'),$body);




		

