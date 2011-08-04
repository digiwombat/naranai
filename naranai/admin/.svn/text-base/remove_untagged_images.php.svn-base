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
        	Remove Untagged Images
        </div>
    	<div id="alert" style="display:block;">
			Warning: This will delete ALL traces of any image with no tags.
	    </div>
        <div class="spacer"></div>
        <form action="" method="post">
			<input type="submit" name="submit" value="Remove Untagged Images" />
		</form>
		<?php
			if(isset($_POST['submit']))
			{
				echo "Removing all untagged files.<br />";
	
				$sql = "SELECT hash, id FROM `images` WHERE `id` NOT IN (SELECT image_id FROM image_tags)";
				$get = mysql_query($sql);
				while($run = mysql_fetch_assoc($get))
				{
					$ab = substr($run['hash'], 0, 2);
					$thumb_name = SITE_DIR . "/thumbs/" . $ab . "/" . $run['hash'];
					$image_name = SITE_DIR . "/images/" . $ab . "/" . $run['hash'];
					unlink($thumb_name);
					echo "Removed thumb for " . $run['id'] . "<br />";
					unlink($image_name);
					echo "Removed image for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `images` WHERE `id` = " . $run['id'] . " LIMIT 1";
					mysql_query($delsql);
					echo "Removed db entry for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `image_tags` WHERE `id` =" . $run['id'];
					mysql_query($delsql);
					echo "Removed tags for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `image_groups` WHERE `id` =" . $run['id'];
					mysql_query($delsql);
					echo "Removed groups for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `tag_history` WHERE `id` =" . $run['id'];
					mysql_query($delsql);
					echo "Removed history for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `comments` WHERE `id` =" . $run['id'];
					mysql_query($delsql);
					echo "Removed comments for " . $run['id'] . "<br />";
					$delsql = "DELETE FROM `notes` WHERE `id` =" . $run['id'];
					mysql_query($delsql);
					echo "Removed notes for " . $run['id'] . "<br />";
				}
				
				echo "Completed.";
			}
		?>
        
    </div>    
    
</div>
<?php
	require_once("../footer.php");
?>