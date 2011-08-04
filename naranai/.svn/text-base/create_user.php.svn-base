<?php

require_once('hibbity/dbinfo.php');




if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["agree"]))
	{
		$sql = "SELECT COUNT(*) as users FROM `users` WHERE `name` = '" . mysql_real_escape_string($_POST["username"]) . "' OR `email` = '" . mysql_real_escape_string($_POST["email"]) . "'";
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		
		if($run['users'] > 0)
		{
			header("Location: " . BASE_URL . "/register/err/422");
			exit();
		}
		
		if(($_POST["password"] == $_POST["password2"]) && ($_POST["email"] == $_POST["email2"]))
		{
			$username 	= mysql_real_escape_string($_POST["username"]);
			$password 	= md5($username . mysql_real_escape_string($_POST["password"]));
			$email		= mysql_real_escape_string($_POST["email"]);
			$code = md5(rand() . microtime());
			
			$sql = "INSERT INTO `users`(
								   name,
								   pass,
								   joindate,
								   email,
								   approval_code,
								   approved
								  )
						VALUES	  (
								   '" . $username . "',
								   '" . $password . "',
								   '" . date('Y-m-d H:i:s') . "',
								   '" . $email . "',
								   '" . $code . "',
								   0
								   );";
			mysql_query($sql);
			$body = "Welcome to " . SITE_NAME . "\n\n
			
Thanks for signing up an account with us. There's one more step left before you can start using your account, however. You have to follow the link below to verify that you asked for the account and that you are a human and stuff like that.\n\n
			
" . BASE_URL . "/verify/user/" . $code . "\n\n
			
Copy and paste the entire URL into your browser and follow the instructions on the page you land on.\n\n
			
Thanks again,\n
The " . SITE_NAME . " Management";
			$headers = 'From: ' . SITE_NAME . ' <' . CONTACT_EMAIL . ">\r\n" .
			'Reply-To: ' . CONTACT_EMAIL . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			mail($email, "Verify your " . SITE_NAME . " account.", $body, $headers);
			header("Location: " . BASE_URL . "/login/err/100");
			exit();
		}
		else
		{
			header("Location: " . BASE_URL . "/register/err/412");
			exit();
		}
	}
else
{
	header("Location: " . BASE_URL . "/register/err/415");
	exit();
}


?>