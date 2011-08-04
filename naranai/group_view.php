<?php
	require_once('hibbity/dbinfo.php');
	require_once(SITE_DIR . '/lib/functions.php');
	
	$group      = isset($_GET['group']) ? abs($_GET["group"]) : '';
	if( empty($group) ) {
		header("Location: " . BASE_URL . "/group/list");
		exit();
	}

	$page_type  = "groups";
	$pagenum    = 0;
	$pics       = 25;
	$search_tag = "";
	$title      = "all posts";
	$pagenum    = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit      = $pics * $pagenum;
	$id['id']   = array();
	$id['hash'] = array();
	$tags       = array();
	$counts     = array();
	$types      = array();

	$sql = "SET group_concat_max_len = 2500;";
	mysql_query($sql);
	$sql = "SELECT SQL_CALC_FOUND_ROWS i.id, i.hash, group_concat(t.tag " . $tags_id . " separator ',') AS tags, group_concat(t.count separator ',') AS counts, group_concat(t.type separator ',') AS types FROM `images` i LEFT OUTER JOIN `image_tags` s ON i.id = s.image_id LEFT OUTER JOIN `tags` t ON s.tag_id = t.id LEFT OUTER JOIN `image_groups` g ON i.id = g.image_id WHERE group_id = " . $group . " GROUP BY i.id ORDER BY g.image_order, i.id LIMIT " . $limit . ", " . $pics;
  	$get = mysql_query($sql);
	
	while( $run = mysql_fetch_assoc($get) )
	{
		$id['id'][] .= $run['id'];
		$id['tags'][] .= $run['tags'];
		$id['hash'][] .= $run['hash'];
		$tags .= $run['tags'] . ',';
		$counts .= $run['counts'] . ',';
		$types .= $run['types'] . ',';
	}

	if( mysql_num_rows($get) ) {
		$tags = explode(",", $tags);
		$counts = explode(",", $counts);
		$types = explode(",", $types);
		for($i = 0; $i < count($counts); $i++)
		{
			$counts_proper[] .=  $counts[$i] . ':' . $types[$i];
		}
		$counts = "";
		$tags = array_combine($tags, $counts_proper);

		array_pop($tags);
		arsort($tags, SORT_NUMERIC);
		$tags = array_slice($tags, 0, 15);
		array_pop($tags);
	}
	
	$pages = ceil(mysql_found_rows() / $pics);
	
	$sql   = "SELECT group_name FROM groups WHERE id = " . $group . " LIMIT 1";
	$title = mysql_result(mysql_query($sql), 0);
	$page_title = "Viewing Group: " . $title . " - " . SITE_NAME;
	

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
					$sql = "SELECT tag, count, type FROM tags ORDER BY count DESC LIMIT 15";
					$get = mysql_query($sql);
					while($run = mysql_fetch_assoc($get))
					{
						echo '<a href="', BASE_URL , '/post/list/' , $run['tag'] , '" class="' , $run['type'] , '">' , str_replace('_', ' ', $run['tag']) , '</a> ' , $run['count'] , '<br />';
					}
				?>
            </div>
        </div>
        
        <div id="tag_list">
        	<div class="block_title">
            	Group Tags
            </div>
            <div class="block_content">
            	<?php
					foreach($tags as $tag => $count)
					{
						$count = explode(":", $count);
						echo '<a href="'  . BASE_URL . '/post/list/' . $tag . '" class="' . $count[1] . '">' . str_replace('_', ' ', $tag) . '</a> ' . $count[0] . '<br />';
					}
				?>
            </div>
        </div>
        
    </div>
	
    <div id="content">
    	<div id="page_title">
        	Viewing Group: <?php echo stripslashes($title); ?>
        </div>
        <div id="alert">
    		<?php  ?>
	    </div>
        <div class="spacer"></div>
    		<?php
				$size       = sizeof($id['id']);
				for($i = 0; $i < $size; ++$i)
				{	
					$imgtags = $id['tags'][$i];
					$class = "";
					if( ereg('tagme', $imgtags) ) 
					{
						$class = ' class="tagme"';
					}
					echo '
				<div class="list_image">
					<a href="', BASE_URL ,'/post/view/' , $id['id'][$i] , '">
						<img src="' , BASE_URL , '/thumbs/' , $id['hash'][$i] , '.jpg" alt="' , $imgtags , '" title="' , str_replace(',', ' ', $imgtags) , '"' , $class , ' />
					</a>
				</div>';
				}
			?>
		
        <div id="pages">
			<?php
				
				if($pagenum > 0)
					{
						echo '<span><a href="', BASE_URL , '/group/view/' . $group . '/' . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="', BASE_URL , '/group/view/' . $group . '/1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 10)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/view/' . $group . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/view/' . $group . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/view/' . $group . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/view/' . $group . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 10)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="', BASE_URL , '/group/view/' . $group . '/' . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="', BASE_URL , '/group/view/' . $group . '/' . ($pagenum + 2) . '">Next &raquo;</a></span>';
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