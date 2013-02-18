<?php


									
								
				function get_image_from_tw($link, $user, $add_to_river=TRUE)
				{
				global $CONFIG;

					
					$dir = $CONFIG->dataroot.'fbconnect/';

					

					$file_dir = $dir.time().'temp.jpg';
					
					$file_w = fopen($file_dir, 'w');
					
					file_put_contents($file_dir, file_get_contents($link));

					$topbar = get_resized_image_from_existing_file($file_dir,16,16, true);
					$tiny = get_resized_image_from_existing_file($file_dir,25,25, true);
					$small = get_resized_image_from_existing_file($file_dir,40,40, true);
					$medium = get_resized_image_from_existing_file($file_dir,100,100, true);
					$large = get_resized_image_from_existing_file($file_dir,200,200);
					$master = get_resized_image_from_existing_file($file_dir,550,550);

					if ($small !== false && $medium !== false && $large !== false && $tiny !== false)
					{
					  
						
									$filehandler = new ElggFile();
									$filehandler->owner_guid = $user->getGUID();
									$filehandler->setFilename("profile/" . $user->guid . "large.jpg");
									$filehandler->open("write");
									$filehandler->write($large);
									$filehandler->close();
									$filehandler->setFilename("profile/" . $user->guid . "medium.jpg");
									$filehandler->open("write");
									$filehandler->write($medium);
									$filehandler->close();
									$filehandler->setFilename("profile/" . $user->guid . "small.jpg");
									$filehandler->open("write");
									$filehandler->write($small);
									$filehandler->close();
									$filehandler->setFilename("profile/" . $user->guid . "tiny.jpg");
									$filehandler->open("write");
									$filehandler->write($tiny);
									$filehandler->close();
									$filehandler->setFilename("profile/" . $user->guid . "topbar.jpg");
									$filehandler->open("write");
									$filehandler->write($topbar);
									$filehandler->close();
									$filehandler->setFilename("profile/" . $user->guid . "master.jpg");
									$filehandler->open("write");
									$filehandler->write($master);
									$filehandler->close();
									
									$user->icontime = time();
									
									system_message(elgg_echo("profile:icon:uploaded"));
									
									trigger_elgg_event('profileiconupdate',$user->type,$user);
									
									
									add_to_river('river/user/default/profileiconupdate','update',$user->guid,$user->guid);
								   
									return true;
					}
					else
					{
					  
						system_message(elgg_echo("profile:icon:notfound"));
						return false;
					}
				}

				

				
				
									
				$email =	$_POST['email'];
				$name = $_SESSION['tumblruser']->name;
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				$tumbleruser = $_SESSION['tumblruser'];
				$tumbleruserblog = $tumbleruser->blogs;
				$tumbleruserblogname = $tumbleruserblog[0]->name;
				$tumbleruserblogurl = $tumbleruserblog[0]->url;
				
				//echo $_SESSION['tumblruser']->tumblr_oauth_token.'<br>';
				//echo $tumbleruserblogurl->tumblr_oauth_token_secret;
				
				//echo '<pre>';
				//print_r($_SESSION['tumblruser']);
				//die;
				
				
				
				if(get_user_by_username($username)) 
					{
										 $duplicate_account = true;
										 register_error(sprintf(elgg_echo("fbconnect:account_duplicate"),$username));
										 forward(REFERER);

					}
					
					
					
					if (get_user_by_email($email)) 
					{
										$duplicate_account = true;
										 register_error(sprintf(elgg_echo("This email is already registered.Please try again with another email."),$username));
										 forward(REFERER);
					}
					
					
					
					$user = new ElggUser();
					$user->username = $username;
					$user->name = $name;
					$user->subtype = 'tumblr';
					$user->tumblr_username = $name;
					$user->tumblr_permission = 'yes';
					$user->tumblr_blog_url = $tumbleruserblogurl;
					$user->tumblr_blog_name = $tumbleruserblogname;
					$user->tumblr_oauth_token = $_SESSION['tumblruser']->tumblr_oauth_token;
					$user->tumblr_oauth_token_secret = $_SESSION['tumblruser']->tumblr_oauth_token_secret;
					$user->access_id = 2;
					$user->salt = generate_random_cleartext_password();
					$user->password = generate_user_password($user, $password);
					$user->owner_guid = 0;
					$user->container_guid = 0;
					if (!$user->save()) {
					register_error(elgg_echo('registerbad'));
					forward();
					}
					$user->save();
					set_user_validation_status($user->guid, TRUE, 'email');		
					$user->enable();	
				   	$user->save();	
				get_image_from_tw($_SESSION['tumblruser']->avatar_url, $user );
				login($user);
				unset($_SESSION['tumblruser']);
				
				
				
				forward();
	
				exit;
			
					
					?>