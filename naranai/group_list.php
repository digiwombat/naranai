<?php

	require_once('hibbity/dbinfo.php');
	
	
	$page_type = "groups";
	$pagenum   = 0;
	$pics      = 20;
	$pagenum  = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit     = $pics * $pagenum;
	
	$sql = "SELECT DISTINCT id FROM `groups` WHERE group_name != '' GROUP BY id ORDER BY id DESC";
	$get = mysql_query($sql);
	
	$page_title = "Viewing Group List - " . SITE_NAME;
	
	$total = mysql_num_rows($get);
	$pages = ceil($total / $pics);
	
	$sql = "SELECT DISTINCT id, group_name FROM `groups` WHERE group_name != '' GROUP BY id ORDER BY id DESC LIMIT " . $limit . ", " . $pics;
	$get = mysql_query($sql);
	
	
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
					$sql_pop = "SELECT tag, count, type FROM tags ORDER BY count DESC LIMIT 15";
					$get_pop = mysql_query($sql_pop);
					while($run = mysql_fetch_assoc($get_pop))
					{
						echo '<a href="', BASE_URL , '/post/list/' . $run['tag'] . '" class="' . $run['type'] . '">' . str_replace('_', ' ', $run['tag']) . '</a> ' . $run['count'] . '<br />';
					}
				?>
            </div>
        </div>
        
        
    </div>
	
    <div id="content">
    	<div id="page_title">
        	Viewing Group List
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    		<?php
				while($run = mysql_fetch_assoc($get))
				{	
					$sql_pop = "SELECT count(*) as count FROM image_groups WHERE group_id = " . $run['id'];
					$get_pop = mysql_query($sql_pop);
					$run_pop = mysql_fetch_assoc($get_pop);
					$count	 = $run_pop['count'];
					$sql_pop = "SELECT g.image_id, i.hash FROM image_groups g LEFT OUTER JOIN images i ON g.image_id = i.id WHERE group_id = " . $run['id'] . " ORDER BY g.image_order, g.image_id LIMIT 1";
					$get_pop = mysql_query($sql_pop);
					$run_pop = mysql_fetch_assoc($get_pop);
					echo '
							<div class="list_image">
								<span class="small">' . stripslashes($run['group_name']) . '
								<span class="light">(' . $count . ' images)</span></span><br />
								<a href="', BASE_URL , '/group/view/' . $run['id'] . '">
									<img src="' . BASE_URL . '/thumbs/' . $run_pop['hash'] . '.jpg" alt="" title="" />
								</a>
							</div>';
				}
			?>
		<div style="clear:both;"></div>
        <div id="pages">
        	
				<?php
					                    
					if($pagenum > 0)
					{
						echo '<span><a href="', BASE_URL , '/group/list/' . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="', BASE_URL , '/group/list/1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 10)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="', BASE_URL , '/group/list/' . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 10)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="', BASE_URL , '/group/list/' . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="', BASE_URL , '/group/list/' . ($pagenum + 2) . '">Next &raquo;</a></span>';
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