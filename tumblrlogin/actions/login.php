<?php
/**
	 * Elgg tumblrlogin plugin
	 * 
	 * @package ElggTumblrLogin
	 * @author Sandeep Singh(Virasat Solutions)<sandeep.virasat@gmail.com>
	 * @link http://elgg.org/
	 */



global $CONFIG;



require_once "{$CONFIG->pluginspath}twitterservice/vendors/twitteroauth/OAuth.php";
require_once(dirname(dirname(__FILE__)) . "/models/secret.php");
require_once(dirname(dirname(__FILE__)) . "/models/tumblroauth.php");



$connection = new TumblrOAuth($consumer_key, $consumer_secret);

if(get_input('sync'))
{
$return_url=elgg_add_action_tokens_to_url($CONFIG->wwwroot . "action/tumblrlogin/tumblr_sync");
}
else
{
$return_url=elgg_add_action_tokens_to_url($CONFIG->wwwroot . "action/tumblrlogin/return");
}

$request_token = $connection->getRequestToken($return_url);


$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
$url = $connection->getAuthorizeURL($token, FALSE);



forward($url);
exit;