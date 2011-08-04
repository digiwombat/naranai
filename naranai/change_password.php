<?php

	require_once('hibbity/dbinfo.php');
	if(!isset($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");
	}
	$page_type = "account";
	$head      = array
			(	
				'js_load' => '/lib/formcheck.js',
				'js_out'  => '
	window.addEvent(\'domready\', function(){
		new FormCheck(\'password_form\');
		if(location.hash == "#Password_Updated_Successfully")
		{
			$(\'alert\').setStyle(\'display\', \'block\');
			$(\'alert\').innerHTML = \'Password Updated Successfully.\';
		}
	});',
				'css_load' => '/styles/' . STYLE_DIR . '/formcheck.css'
			);
	$page_title = "Change Password - " . SITE_NAME;
	
	
	
	if(isset($_POST["old_password"]) && isset($_POST["new_password"]) && $_POST["new_password"] == $_POST["new_password_repeat"])
	{
		$username = mysql_real_escape_string($_COOKIE['user_name']);
		$password = md5($username . mysql_real_escape_string($_POST["old_password"]));
		$user_id = mysql_real_escape_string($_COOKIE['user_id']);
		
		$sql = "SELECT id, name, email FROM `users` WHERE name = '" . $username . "' AND pass = '" . $password . "'";
		$get = mysql_query($sql);
		if(mysql_num_rows($get) > 0)
		{
				$new_pass = md5($username . mysql_real_escape_string($_POST["new_password"]));
				$sql_up = "UPDATE `users` SET `pass` = '" . $new_pass . "' WHERE `id` = " . $user_id;
				mysql_query($sql_up);
				header("Location: " . BASE_URL . "/user/change/pass#Password_Updated_Successfully");
				exit();
		}
		else
		{
			header("Location: #Error");
			exit();
		}
	}
	
					
	require_once("header.php");
?>

<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        
    </div>
        
	
    <div id="content">
    	<div id="page_title">
        	Change Password
        </div>
    	<div id="alert">
    		
	    </div>
        <div class="spacer"></div>
        <form class="registration" id="password_form" action="" method="post">
        <fieldset>
        <legend>Update Password</legend>
        
        <label for="username">
        	<span>
	        	Old Password
            </span>
            <input type="password" name="old_password" class="validate['required','length[6,-1]']" />
        <label>
        
        <label for="password">
        	<span>
	        	New Password
            </span>
            <input type="password" name="new_password" class="validate['required','length[6,-1]']" />
        <label>
		
		<label for="password">
        	<span>
	        	Repeat New Password
            </span>
            <input type="password" name="new_password_repeat" class="validate['required','length[6,-1]']" />
        <label>
        
        
        <label for="password">
        	<input type="submit" name="submit" value="Change Password" />
            <span class="small light">
				Be sure to write down your new password.
        	</span>
        </label>
        
        </fieldset>
        </form>
        
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>