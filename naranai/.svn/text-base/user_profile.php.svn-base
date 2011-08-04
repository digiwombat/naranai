<?php

	require_once('hibbity/dbinfo.php');
	if(!isset($_GET['user_id']) || !is_numeric($_GET['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");
	}

	$id = mysql_real_escape_string($_GET['user_id']);
	$sql = "select count(*) from `images` where `owner_id` = " . $id;
	$get = mysql_query($sql);
	$images = mysql_result($get, 0);
	
	$sql = "select count(*) from `notes` where `user_id` = " . $id;
	$get = mysql_query($sql);
	$notes = mysql_result($get, 0);
	
	$sql = "select count(*) from `tag_histories` where `user_id` = " . $id;
	$get = mysql_query($sql);
	$tags = mysql_result($get, 0);
	
	$sql = "select count(*) from `favourites` where `user_id` = " . $id;
	$get = mysql_query($sql);
	$favs = mysql_result($get, 0);
	
	$sql = "select name, email, joindate, user_level from `users` where `id` = " . $id;
	$get = mysql_query($sql);
	$info = mysql_fetch_assoc($get);
	$page_type = "account";
	
	$page_title = "User Profile: " . $info['name'] . " - " . SITE_NAME;
	$head =	array
		(
			'css_load' =>	array
						(
							'/styles/' . STYLE_DIR . '/comments.css',
							'/styles/' . STYLE_DIR . '/formcheck.css'
						)
		);
	require_once("header.php");
?>

<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        
    </div>
        
	
    <div id="content">
    	
    	<div id="alert">
    		
	    </div>
        <div class="spacer"></div>
         <div id="comments">
			<ol class="comment">
				<li>
						<span class="info">
							<span class="poster">
									<?php 
										$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" . md5(strtolower($info['email'])) . "&d=identicon&size=40";
										echo '<img src="' . $grav_url . '" alt="" />';
										echo $info['name'];
										if($info['user_level'] == '11')
										{
											echo '<div class="user_rank">God</div>';
										}
										elseif($info['user_level'] == '10')
										{
											echo '<div class="user_rank">Admin</div>';
										}
										else
										{
											echo '<div class="user_rank">Member</div>';
										}
										
									?>
							</span>
							
						</span>
			
						<div class="content" style="clear:both;">
							<p>
								
							</p>
						</div>
						
				</li>
				<li>
						<span class="info">
							<span class="poster">
									Join Date
							</span>
							
						</span>
			
						<div class="content">
							<p>
								<?php echo $info['joindate']; ?>
							</p>
						</div>
						
				</li>
				<li>
						<span class="info">
							<span class="poster">
									Posts
							</span>
							
						</span>
			
						<div class="content">
							<p>
								<a href="<?php echo BASE_URL . '/post/list/user:' . $id; ?>"><?php echo $images; ?></a>
							</p>
						</div>
						
				</li>
				<li>
						<span class="info">
							<span class="poster">
									Notes Added
							</span>
							
						</span>
			
						<div class="content">
							<p>
								<?php echo $notes; ?>
							</p>
						</div>
						
				</li>
				<li>
						<span class="info">
							<span class="poster">
									Tags Edited
							</span>
							
						</span>
			
						<div class="content">
							<p>
								<?php echo $tags; ?>
							</p>
						</div>
						
				</li>
				<li>
						<span class="info">
							<span class="poster">
									Favourites
							</span>
							
						</span>
			
						<div class="content">
							<p>
								<a href="<?php echo BASE_URL . '/post/list/fav:' . $id; ?>"><?php echo $favs; ?></a>
							</p>
						</div>
						
				</li>
			</ol>
        </div>
		
		<div class="big" style="clear:both">
			Recent Uploads <a href="<?php echo BASE_URL . '/post/list/user:' . $id; ?>">&raquo;</a>
		</div>
		<?php
			$sql = "SELECT id, hash FROM `images` WHERE `owner_id` = " . $id . " ORDER BY `posted` DESC LIMIT 0, 5";
			$get = mysql_query($sql);
			while($run = mysql_fetch_assoc($get))
			{
				echo '
								<div class="list_image">
									<a href="', BASE_URL , '/post/view/' , $run['id'] , '" id="' . $id['id'] . '">
										<img src="',  BASE_URL , '/thumbs/' , $run['hash'] , '.jpg" alt="" title="" />
									</a>
								</div>';
			}
		?>
		<div class="big" style="clear:both">
			Recent Favourites <a href="<?php echo BASE_URL . '/post/list/fav:' . $id; ?>">&raquo;</a>
		</div>
		<?php
			$sql = "SELECT i.id, i.hash FROM `images` i LEFT OUTER JOIN `favourites` f ON f.image_id = i.id WHERE f.`user_id` = " . $id . " ORDER BY f.`id` DESC LIMIT 0, 5";
			$get = mysql_query($sql);
			while($run = mysql_fetch_assoc($get))
			{
				echo '
								<div class="list_image">
									<a href="', BASE_URL , '/post/view/' , $run['id'] , '" id="' . $id['id'] . '">
										<img src="',  BASE_URL , '/thumbs/' , $run['hash'] , '.jpg" alt="" title="" />
									</a>
								</div>';
			}
		?>
		<div style="clear:both;">
		</div>
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>