<?php
	require_once('hibbity/dbinfo.php');

	if( USER_LEVEL < FORUM_POST) {
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}

	$page_type = "forum";

	$head =	array
		(
			'js_load' =>	array
						(
							'/lib/formcheck.js'
						),
			'css_load' =>	array
						(
							'/styles/' . STYLE_DIR . '/formcheck.css'
						)
		);

	$thing = "New Topic";
	$page_title = "New Topic - " . SITE_NAME;
	if( isset($_GET["post_id"]) )
	{
		$post_id = abs($_GET["post_id"]);
		$sql = "SELECT id, topic, title, user_id, post FROM `forum_posts` WHERE `id` = " . $post_id;
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		$thing = "Edit Post #" . $run["id"];
		$page_title = "Edit Post #" . $run["id"] . " - " . SITE_NAME;
		if($run['user_id'] != $_COOKIE['user_id'] && !isadmin($_COOKIE['user_id']))
		{
			header("Location: " . BASE_URL . "/forum/list");
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
        	<?php echo $thing ?>
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <div id="edit">
	    <form class="registration" id="edit_form" action="<?php echo BASE_URL; ?>/forum/add" method="post">
	                
            <?php
				if(!isset($_GET['post_id']) || (isset($run['topic']) && $run['topic'] == -1))
				{
			?>			
            <div>
                <span class="edit_title">
                    Title
                </span>
                <span class="edit_form">
                    <input type="text" name="title" id="title" style="width:250px;" value="<?php echo stripslashes($run['title']) ?>" class="validate['required']" />
                </span>
            </div>
			<?php
				}
			?>
            <div>
                <span class="edit_title">
					Post
                </span>
                <span class="edit_form">
                   	<textarea name="post" style="width:450px;height:300px;"><?php echo stripslashes($run["post"]); ?></textarea>
                </span>
            </div>
            <div>
                <span class="edit_title">
                    &nbsp;
                </span>
                <span class="edit_form">
                	<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
					<input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>" />
                    <input type="submit" name="submit" value="<?php echo $thing ?>" style="display:inline;" /> <a href="<?php echo BASE_URL ?>/forum/list">Cancel</a><br />
					<?php
						if(isadmin($_COOKIE['user_id']) && isset($run['id']))
						{
							echo '<span class="small"><a href="' . BASE_URL . '/admin/delete/forum/' . $run['id'] . '">Delete Post</a></span>';
						}
					?>
                </span>
            </div>

    
        </form>
        </div>
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>