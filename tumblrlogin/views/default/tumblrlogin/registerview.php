		<script type = "text/javascript">			
		function signupcheck()	
		{

			function validateEmail(elementValue)
			{  
			var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
			return emailPattern.test(elementValue);  
			} 
			
		
		var username1 = document.getElementById("username").value;	
		var password  = document.getElementById("password").value;	
		var username1length = username1.length;		
		var passwordlength  = password.length;	
		
		var validemail = validateEmail(document.getElementById("email").value);
		
		if(!(validemail))
		{
		alert("Please eneter a valid email");
		return false;
		}
		
		
		if(username1length>4 && passwordlength>6)
		{	
		return true;		
		}				
		
		if(username1length<4)	
		{		
		alert("Username must have atleast 4 characters");	
		return false;		
		}
		
		if(passwordlength<6)	
		{		alert("Password must have atleast 6 characters");	
		return false;		
		}						
		}						
		</script>	
		<form  action = "<?php echo $vars['action_url']; ?>" method = "post">	
		<div  style = "margin-left: 216px;   margin-top: 75px;">	
		<label style = "color:white;">Username</label><br>	
		<input type="text" name="username" id="username"><br>
		<label style = "color:white;">Password</label><br>	
		<input type="password" name="password" id="password"><br>


			<label style = "color:white;">Email</label><br>
			<input type="text" name="email" id="email"><br>


		<input type="submit" value="Login" class="submit_button" onclick = "return signupcheck();"> 						 </div>	
		</form>						
		<div class="clearfloat"></div>		  