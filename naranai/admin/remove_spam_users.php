<?php

	require_once('../hibbity/dbinfo.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	$page_type = "account";
	
	$page_title = "Remove Spam Users - " . SITE_NAME;
	
	
	
	
	require_once("../header.php");
?>

<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        
    </div>
        
	
    <div id="content">
    	<div id="page_title">
        	Remove Spam Users
        </div>
    	<div id="alert" style="display:block;">
    		This will remove all unapproved users who signed up more than 5 days ago. THIS IS NOT REVERSIBLE!
	    </div>
        <div class="spacer"></div>
        <form action="" method="post">
			<input type="submit" name="submit" value="Remove Spam Users" />
		</form>
		<?php
			if(isset($_POST['submit']))
			{
				$resetsql = "DELETE FROM `users` WHERE `approved` = 0 AND `joindate` < DATE_ADD( NOW( ) , INTERVAL -5
DAY )";
				mysql_query($resetsql);
				echo "Done.";
			}
		?>
        
    </div>    
    
</div>
<?php
	require_once("../footer.php");
?>