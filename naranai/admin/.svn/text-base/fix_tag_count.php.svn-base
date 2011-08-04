<?php

	require_once('../hibbity/dbinfo.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	$page_type = "account";
	
	$page_title = "Fix Tag Counts - " . SITE_NAME;
	
	
	
	
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
        	Fix Tag Counts (Sometimes They Fuck Up)
        </div>
    	<div id="alert">
    		
	    </div>
        <div class="spacer"></div>
        <form action="" method="post">
			<input type="submit" name="submit" value="Fix Tag Count" />
		</form>
		<?php
			if(isset($_POST['submit']))
			{
				$sql = "SELECT id, tag, count FROM `tags`";
				$get = mysql_query($sql);
				while($run = mysql_fetch_assoc($get))
				{	
					
					$countsql = "SELECT image_id FROM `image_tags` WHERE tag_id = " . $run['id'];
					$countget = mysql_query($countsql);
					$count 	  = mysql_num_rows($countget);

					if($count != $run['count'])
					{
						$resetsql = "UPDATE `tags` SET `count` = " . $count . " WHERE id = " . $run['id'];
						mysql_query($resetsql);
						echo "Changed tag count for " . $run['tag'] . "<br />";
					}
				}
				echo "Done.";
			}
		?>
        
    </div>    
    
</div>
<?php
	require_once("../footer.php");
?>