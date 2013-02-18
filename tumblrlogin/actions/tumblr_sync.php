<?php


		require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
		gatekeeper();
		$user = get_loggedin_user();
		global $CONFIG;
		require_once "{$CONFIG->pluginspath}twitterservice/vendors/twitteroauth/OAuth.php";
		require_once(dirname(dirname(__FILE__)) . "/models/tumblroauth.php");
		require_once(dirname(dirname(__FILE__)) . "/models/secret.php");
		$connection = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$oauthverifier=get_input('oauth_verifier');
		$token = $connection->getAccessToken($oauthverifier);
		$connection = new TumblrOAuth($consumer_key, $consumer_secret, $token['oauth_token'], $token['oauth_token_secret']);
		$jsonuser = $connection->get("http://api.tumblr.com/v2/user/info");
		$tumbleruser = json_decode($jsonuser);
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
		$tumbleruser->avatar_url = $tumbleruserpic;
		$tumbleruserblog = $tumbleruser->blogs;
		$tumbleruserblogname = $tumbleruserblog[0]->name;
		$tumbleruserblogurl = $tumbleruserblog[0]->url;
		$user->tumblr_username = $tumbleruser->name;
		$user->tumblr_permission = 'yes';
		$user->tumblr_blog_url = $tumbleruserblogurl;
		$user->tumblr_blog_name = $tumbleruserblogname;
		$user->tumblr_oauth_token = $tumbleruser->tumblr_oauth_token;
		$user->tumblr_oauth_token_secret = $tumbleruser->tumblr_oauth_token_secret;
		forward($CONFIG->wwwroot.'mod/fbconnect/pages/settings.php');
