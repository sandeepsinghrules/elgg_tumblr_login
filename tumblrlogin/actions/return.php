<?php
/**
	 * Elgg tumblrlogin plugin
	 * 
	 * @package ElggTumblrLogin
	 * @author Sandeep Singh(Virasat Solutions)<sandeep.virasat@gmail.com>
	 * @link http://elgg.org/
	 */


		require_once "{$CONFIG->pluginspath}twitterservice/vendors/twitteroauth/OAuth.php";
		require_once(dirname(dirname(__FILE__)) . "/models/tumblroauth.php");
		require_once(dirname(dirname(__FILE__)) . "/models/secret.php");


		$connection = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


		$oauthverifier=get_input('oauth_verifier');
		$token = $connection->getAccessToken($oauthverifier);


		$connection = new TumblrOAuth($consumer_key, $consumer_secret, $token['oauth_token'], $token['oauth_token_secret']);


		$jsonuser = $connection->get("http://api.tumblr.com/v2/user/info");
		$tumbleruser = json_decode($jsonuser);
		
		
		// echo '<pre>';
		// print_r($tumbleruser);
		// die;
		
		
		
		$tumbleruser = $tumbleruser->response; 
		$tumbleruser = $tumbleruser->user;
		$tumbleruser->tumblr_oauth_token = $token['oauth_token'];
		$tumbleruser->tumblr_oauth_token_secret = $token['oauth_token_secret'];
		$tumbleruserblog = $tumbleruser->blogs;
		$tumbleruserblogname = $tumbleruserblog[0]->name;
		
		
		
		$jsonuserpic = $connection->get("http://api.tumblr.com/v2/blog/".$tumbleruserblogname.".tumblr.com/avatar/512");
		$tumbleruserpic = json_decode($jsonuserpic);
		$tumbleruserpic = $tumbleruserpic->response;
		$tumbleruserpic = $tumbleruserpic->avatar_url;
		
		//adding picurl to user obj
		$tumbleruser->avatar_url = $tumbleruserpic;
		$_SESSION['tumblruser'] = $tumbleruser;
		
		//echo '<pre>';
		//print_r($tumbleruser);
		//print_r($connection);
		//die;
		
		
		if($connection->http_code == 200 || $connection->http_code == 301)
		{
		$entities = get_entities_from_metadata('tumblr_username', $tumbleruser->name, 'user', 'tumblr');
		$do_login = false;
		$duplicate_acccount = false;
		if (!$entities || $entities[0]->active == 'no')
		{
		
		if (!$entities) {
		
			$entities = get_entities_from_metadata('tumblr_username', $tumbleruser->name, 'user', 'tumblr');
			if (!$entities) {
			
			
			
					$username = $tumbleruser->name;
				 	$ts = time();
					$token = generate_action_token($ts);
					$action_url = $CONFIG->wwwroot."action/tumblrlogin/registeration/?__elgg_ts=".$ts."&__elgg_token=".$token."&tusername=".$username;
					forward($action_url);
			
			
			}}
		
		
		}
		else
		{
		register_error(elgg_echo("This account is already registered."));
		}
		
		}
		else
		{
			register_error(elgg_echo("We cannot authenticate you."));
		}
		forward();
		
		
