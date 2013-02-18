<?php

$body = '';

$login_key = get_plugin_setting('login_key', 'tumblrlogin');
$login_secret = get_plugin_setting('login_secret', 'tumblrlogin');

$body .= "<p><b>" . elgg_echo('tumblrlogin:title') . "</b></p>";
$body .= '<br />';
$body .= elgg_echo('tumblrlogin:details'); 
$body .= '<br />';
$body .= elgg_echo('tumblrlogin:key') . "<br />";
$body .= elgg_view('input/text',array('internalname'=>'params[login_key]','value'=>$login_key));
$body .= elgg_echo('tumblrlogin:secret') . "<br />";
$body .= elgg_view('input/text',array('internalname'=>'params[login_secret]','value'=>$login_secret));

echo $body;