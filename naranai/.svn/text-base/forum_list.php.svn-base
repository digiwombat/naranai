<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < FORUM_VIEW ) {
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	
	$page_type = "forum";
	$pics      = 40;
	$tag_type  = '';
	$pagenum   = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit     = $pics * $pagenum;
		

	$page_title = "Viewing Forum List - " . SITE_NAME;

	$sql = "SELECT count(*) as count FROM `forum_posts` WHERE `topic` = -1 ORDER BY sticky, (SELECT `posted_at` FROM `forum_posts` WHERE `topic` = id) DESC";
	$get = mysql_query($sql);

	$total = mysql_result($get,0);
	$pages = ceil($total['count'] / $pics);

	$sql = "SELECT f.id, f.sticky, f.locked, f.title, f.user_id, u.name  FROM `forum_posts` f LEFT OUTER JOIN `users` u ON f.user_id = u.id WHERE `topic` = -1 ORDER BY f.sticky DESC, (SELECT f.`posted_at` FROM `forum_posts` WHERE f.`topic` = f.`id` OR f.`topic` = -1 ORDER BY f.`id` DESC LIMIT 1) DESC LIMIT " . $limit . ", " . $pics;
	$get = mysql_query($sql);

	require_once('header.php');
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
					$sql_pop = "SELECT tag, count, type FROM tags ORDER BY count DESC LIMIT 15";
					$get_pop = mysql_query($sql_pop);
					while($run = mysql_fetch_assoc($get_pop))
					{
						echo '<a href="', BASE_URL , '/post/list/' , $run['tag'] , '" class="' , $run['type'] , '">' , $run['tag'] , '</a> ' , $run['count'] , '<br />';
					}
				?>
            </div>
        </div>
        
        
    </div>
	
    <div id="content">
    	<div id="page_title">
        	Viewing Forum List
        </div>
        <div id="alert"></div>
        
        <div class="spacer"></div>
        	
         <div id="forum">
            <table cellpadding="0" cellspacing="0">
            	<tr>
                    <th>
                    	Thread
                    </th>
                    <th>
                    	Latest Reply
                    </th>
            		<th>
                    	Replies
                    </th>
                </tr>
    		<?php
				while( $run = mysql_fetch_assoc($get) )
				{	
					if( !empty($run['title']) )
					{
						$locked = '';
						$sticky = '';
						if($run['locked'] == 1)
						{
							$locked = '<span class="small">locked</span>';
						}
						if($run['sticky'] == 1)
						{
							$sticky = '<strong>Sticky:</strong> ';
						}
						$sql_replies = "SELECT (SELECT count(*) FROM `forum_posts` WHERE `topic` = " . $run['id'] . ") as replies, f.posted_at, f.user_id, u.name FROM `forum_posts` f LEFT OUTER JOIN users u ON f.user_id = u.id WHERE f.`topic` = " . $run['id'] . " OR f.`id` = " . $run['id'] . " ORDER BY f.`posted_at` DESC LIMIT 1";
						$get_replies = mysql_query($sql_replies);
						$run_replies = mysql_fetch_row($get_replies);
						
						echo '
								<tr>
									<td style="border-right: 1px dotted #999;width: 80%;">' . $sticky . '<a href="' . BASE_URL . '/forum/view/' . $run['id'] . '">' . $run['title'] . '</a>' . $locked . '<br /><span class="small grey">by 
									<a href="' . BASE_URL . '/user/profile/' . $run['user_id'] . '">'
									. $run['name'] . 
									'</a></span>';
						if(isadmin($_COOKIE['user_id']))
						{	
									$unl = '';
									$uns = '';
									if($run['locked'] == 1)
									{
										$unl = 'un';
									}
									if($run['sticky'] == 1)
									{
										$uns = 'un';
									}
									echo '<div class="right forum-admin">
											<a href="' . BASE_URL . '/admin/forum/lock/' . $run['id'] . '">' . $unl . 'lock</a> / <a href="' . BASE_URL . '/admin/forum/stick/' . $run['id'] . '">' . $uns . 'sticky</a>
										</div>';
									
						}
						echo '		</td>
									<td style="border-right: 1px dotted #999;width: 15%;">' 
									. fuzzy_time($run_replies[1]) . 
									'<br /><span class="small grey">by 
									<a href="' . BASE_URL . '/user/profile/' . $run_replies[2] . '">'
									. $run_replies[3] . 
									'</span></td>
									<td style="width: 5%;"><strong>' 
									. $run_replies[0] . '
									</strong></td>
								</tr>';
					}
				}
			?>
			</table>
            </div>
            
            <div id="pages">
        	
				<?php
					$type = isset($_GET["type"]) ? $_GET['type'] . '/' : '';

					if($pagenum > 0)
					{
						echo '<span><a href="' . BASE_URL . '/forum/list/' . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="' . BASE_URL . '/forum/list/1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 11)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/forum/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/forum/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/forum/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/forum/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 11)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="' . BASE_URL . '/forum/list/' . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="' . BASE_URL . '/forum/list/' . ($pagenum + 2) . '">Next &raquo;</a></span>';
					}
					else
					{
						echo '<span>Next &raquo;</span>';
					}	
                ?>
            </span>
        </div>
        
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>