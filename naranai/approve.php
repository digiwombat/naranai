<?php

	require_once('hibbity/dbinfo.php');
	if($_COOKIE['user_id'] || !isset($_GET['user_hash']) || !preg_match('/^[A-Fa-f0-9]{32}$/' , $_GET['user_hash']))
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	else
	{
		$user_hash = mysql_real_escape_string($_GET['user_hash']);
	}
	$page_type = "account";
	
	$page_title = "Verify Your Account - " . SITE_NAME;
		
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
        	Verify Your Account
        </div>
    	<div id="alert" style="display:block;">
    		You might be wondering why you're here. Well... sometimes people lie about being people. This button helps stop some of those people.
	    </div>
        <div class="spacer"></div>
        <form action="<?php echo BASE_URL; ?>/approve/user/" method="post">
			<input type="hidden" name="user_approval_hash" value="<?php echo $user_hash; ?>" />
			<input type="submit" name="submit" value="Verify Your Account" />
		</form>
		
        
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>