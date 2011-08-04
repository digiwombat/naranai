<?php
	require_once('hibbity/dbinfo.php');
	if(!is_numeric($_GET['topic_id']) ||  USER_LEVEL < FORUM_VIEW ) {
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	
	$id = abs($_GET['topic_id']);
	$page_type = 'forum';	
	$pagenum   = isset($_GET['pagenum']) ? abs($_GET['pagenum'] - 1) : 0;
	$pics      = 25;
	$limit     = $pics * $pagenum;
	$locked    = 0;
	$head      = array(
						'js_load' => array
										(
											'/lib/formcheck.js'
										),
						'js_out'  => '
									window.addEvent(\'domready\', function(){
										new FormCheck(\'reply_form\');
										$$(\'.quote\').each(function(e) { 
											e.addEvent(\'click\', function(j) {
												id = this.getProperty(\'id\').replace(\'quote-\', \'\');
												$(\'reply_box\').value = \'\';
												$(\'reply_box\').value = $(\'reply-\' + id).innerHTML.trim();
											});
										});
									});',
						'css_load' => array
										(
											'/styles/' . STYLE_DIR . '/comments.css',
											'/styles/' . STYLE_DIR . '/formcheck.css'
										),
						);
	$sql = "SELECT title FROM `forum_posts` WHERE id = " . $id;
	$get = mysql_query($sql);
	$topic = mysql_result($get, 0);
	$sql = "SELECT SQL_CALC_FOUND_ROWS f.id, f.post, f.posted_at, f.user_id, f.locked, u.name, u.email FROM `forum_posts` f LEFT OUTER JOIN `users` u ON f.user_id = u.id WHERE f.`topic` = " . $id . " OR f.`id` = " . $id . " ORDER BY f.`id` LIMIT " . $limit . ", " . $pics;
	
	$get = mysql_query($sql);
	$sql = "";
	$pages = ceil(mysql_found_rows() / $pics);

	$page_title = "Viewing " . $topic . " - " . SITE_NAME;
	require_once("header.php");
?>

<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        <div id="tag_list">
        	<div class="block_title">
            	Popular Tags
            </div>
            <div class="block_content">
            	<?php
					$sql_side = "SELECT tag, count, type FROM tags WHERE count > 0 ORDER BY count DESC LIMIT 15";
					$get_side = mysql_query($sql_side);
					while($run_side = mysql_fetch_assoc($get_side))
					{
						echo '<a href="', BASE_URL, '/post/list/' , $run_side['tag'] , '" class="' . $run_side['type'] . '">' , str_replace('_', ' ', $run_side['tag']) , '</a> ' , $run_side['count'] , '<br />';
					}
				?>
            </div>
        </div>
        
    </div>
	
    <div id="content">
    	<div id="page_title">
        	<h3><?php echo $topic; ?></h3>
        </div>
        <div id="alert">
	    </div>
        <div class="spacer"></div>
		   <div id="comments">
			<ol class="comment">
    		<?php
				while($run = mysql_fetch_assoc($get))
				{
					$locked += $run['locked'];
					$size = 40;
					$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" . md5(strtolower($run['email'])) . "&d=identicon&size=" . $size; 
					$post = stripslashes(nl2br($run['post']));
					?>
				<li id="post-<?php echo $run['id'] ?>">
					<span class="info">
						<span class="poster">
							<img src="<?php echo $grav_url ?>" alt="<?php echo $run['name'] ?>" />
							<a href="<?php echo BASE_URL . '/user/profile/' . $run['user_id']; ?>"><?php echo $run['name'] ?></a>
						</span>
						<span class="time">
							<abbr class="time" title="<?php echo date('D M j h:m:s', strtotime($run_block['posted'])); ?>"><?php echo fuzzy_time($run['posted_at']) ?></abbr>
						</span>
					</span>
		
					<div class="content forum">
						<p>
							<?php echo schmancy($post); ?>
						</p>
						<br /><br /><br />
						<span class="grey">
							<?php
								if($run['user_id'] == $_COOKIE['user_id'] || isadmin($_COOKIE['user_id']))
								{
									echo '<a href="' . BASE_URL . '/forum/edit/' . $run['id'] . '">Edit</a> | ';
								}							
							?>
							<a class="quote" id="quote-<?php echo $run['id']; ?>">Quote</a>
						</span>
					</div>
					<div style="display:none;" id="reply-<?php echo $run['id']; ?>">[quote][i]<?php echo $run['name'] ?> says:[/i]
<?php echo $run['post']; ?>[/quote]
					</div>
					
					</li>
			<?php
				}
			?>
			</ol>
		</div>
		
        <div id="pages">
			<?php

				
					if( $pagenum )
						echo '<span><a href="', BASE_URL , '/forum/view/' . $id . '/' , ($pagenum) , '">&laquo; Previous</a></span>';

					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="', BASE_URL , '/forum/view/' . $id . '/1"' , $this_page , '>1</a>';
					$this_page = '';
					
					if($pages < 10)
					{
						for($i = 2; $i <= $pages; $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/forum/view/' . $id . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
					}
					elseif($pagenum > ($pages - 10))
					{
						echo '...';
						for($i = ($pages - 9); $i < ($pages); $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/forum/view/' . $id . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}   
					}
					elseif($pagenum > 7)
					{
						echo '...';
						for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/forum/view/' . $id . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
						echo '...';
					}
					else
					{
						for($i = 2; $i <= 9; $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/forum/view/' . $id . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
						echo '...';
					}
					
					if($pages >= 10)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="', BASE_URL , '/forum/view/' . $id . '/' . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="', BASE_URL , '/forum/view/' . $id . '/' . ($pagenum + 2) . '">Next &raquo;</a></span>';
					}
				
               ?>
        </div>
        <div class="spacer"></div>
		<?php
			if( USER_LEVEL >= FORUM_REPLY && ($locked = 0 || isadmin($_COOKIE['user_id'])))
			{
		?>
        <div id="response">
        	
           <form id="reply_form" action="<?php echo BASE_URL; ?>/forum/reply" method="post">
    
           		<div>
    	            <span class="edit_title">
            	        Reply
        	        </span>
                	<span class="edit_form">
						<textarea name="reply" id="reply_box" class="validate['required']"></textarea>
	                </span>
	            </div>
                
                <div>
	                <span class="edit_title">
    	                &nbsp;
        	        </span>
            	    <span class="edit_form">
                		<input type="hidden" name="topic_id" value="<?php echo $id; ?>" />
                    	<input type="hidden" name="user_id" value="<?php echo isset($_COOKIE["user_id"]) ? (int) $_COOKIE["user_id"] : 0; ?>" />
	                    <input type="submit" name="submit" value="Post Reply" />
    	            </span>
        	    </div>
    
           </form>
            
        </div>
        <?php
			}
		?>
		
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>
