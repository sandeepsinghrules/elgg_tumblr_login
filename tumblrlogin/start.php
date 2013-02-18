<?php
/**
	 * Elgg tumblrlogin plugin
	 * 
	 * @package ElggTumblrLogin
	 * @author Sandeep Singh(Virasat Solutions)<sandeep.virasat@gmail.com>
	 * @link http://elgg.org/
	 */
	 register_elgg_event_handler('init', 'system', 'tumblrlogin_init');	 
	 global $CONFIG;
	
	 function tumblrlogin_init() {
			
	        	        
	       
			extend_view('css','tumblrlogin/css');
			//extend_view("account/forms/login", "tumblrlogin/login");  
			
    			
       }
	   
		register_action("tumblrlogin/registeration",true, $CONFIG->pluginspath . "tumblrlogin/actions/registeration.php");
	   register_action("tumblrlogin/register",true, $CONFIG->pluginspath . "tumblrlogin/actions/register.php");	   
	   register_action("tumblrlogin/login",true,$CONFIG->pluginspath . "tumblrlogin/actions/login.php");
	   register_action("tumblrlogin/return",true,$CONFIG->pluginspath . "tumblrlogin/actions/return.php"); 
	    register_action("tumblrlogin/tumblr_sync",true,$CONFIG->pluginspath . "tumblrlogin/actions/tumblr_sync.php");
	   