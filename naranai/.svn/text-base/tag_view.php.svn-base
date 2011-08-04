<?php

	require_once('hibbity/dbinfo.php');
	
	
	$page_type = "tags";
	$pics      = 40;
	$type      = "Tag";
	$tag_type  = '';
	$pagenum   = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit     = $pics * $pagenum;

	if( isset($_GET["type"]) )
	{
		$type     = ucfirst($_GET["type"]);
		$tag_type = " WHERE type = '" . mysql_real_escape_string($_GET["type"]) . "'";
	}
	if( isset($_GET["find_tag"]) )
	{
		$search     = ucfirst($_GET["find_tag"]);
		$find_tag 	= mysql_real_escape_string($_GET["find_tag"]);
		$linker		= $find_tag . '/';
		if(!empty($tag_type))
		{
			$tag_search = " AND tag LIKE '%" . $find_tag . "%'";
		}
		else
		{
			$tag_search = " WHERE tag LIKE '%" . $find_tag . "%'";
		}
	}
	$find_tag = stripslashes($find_tag);
	$page_title = "Viewing " . $type . $find_tag . " List - " . SITE_NAME;

	$sql = "SELECT id FROM `tags`" . $tag_type . $tag_search . " ORDER BY tag";
	$get = mysql_query($sql);

	$total = mysql_num_rows($get);
	$pages = ceil($total / $pics);

	$sql = "SELECT `id`, `tag`, `count`, `type` FROM `tags`" . $tag_type . $tag_search . " ORDER BY tag LIMIT " . $limit . ", " . $pics;
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
						echo '<a href="', BASE_URL , '/post/list/' , $run['tag'] , '" class="' , $run['type'] , '">' , $run['tag'] , '</a> ' , $run['count'] , '<br />';
					}
				?>
            </div>
        </div>
        
        
    </div>
	
    <div id="content">
    	<div id="page_title">
        	Viewing <?php echo $type; ?> List
        </div>
        <div id="alert"></div>
        
        <div class="spacer"></div>
        <div class="spacer small">
		<form action="<?php echo BASE_URL ?>/tags/search" method="POST">
		Search: <input type="text" name="find_tag" style="width:150px;" value="<?php echo $find_tag ?>" /> <a href="<?php echo BASE_URL ?>/tags/list">Clear Search</a>
		<br /><br />
		Show: <a href="<?php echo BASE_URL ?>/tags/list<?php echo $linker ?>">All</a> | <a href="<?php echo BASE_URL ?>/tags/list/normal<?php echo $linker ?>">Normal</a> | <a href="<?php echo BASE_URL ?>/tags/list/series<?php echo $linker ?>">Series</a> | <a href="<?php echo BASE_URL ?>/tags/list/character<?php echo $linker ?>">Characters</a> | <a href="<?php echo BASE_URL ?>/tags/list/artist<?php echo $linker ?>">Artists</a>
		<input type="hidden" name="type" value="<?php echo strtolower($type) ?>"
		</form>
		</div>
         <div id="tags">
            <table cellpadding="0" cellspacing="0">
            	<tr>
                    <th>
                    	Posts
                    </th>
                    <th>
                    	Tag Name
                    </th>
            		<th>
                    	Type
                    </th>
					<th>
                    	&nbsp;
                    </th>
                </tr>
    		<?php
				while( $run = mysql_fetch_assoc($get) )
				{	
					if( !empty($run["tag"]) )
					{
						echo '
								<tr>
									<td style="border-right: 1px dotted #999;text-align:right;width: 100px;">' . $run['count'] . '</td>
									<td style="border-right: 1px dotted #999;">' , $run['tag'] , '</td>
									<td style="border-right: 1px dotted #999;">' , $run['type'] , '</td> 
									<td style="width: 30px;">';
									if(USER_LEVEL >= TAG_EDIT)
									{
										echo '<a href="', BASE_URL , '/tags/edit/' , $run['id'] , '">edit</a>';
									}
									echo '</td>
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
						echo '<span><a href="' . BASE_URL . '/tags/list/' . $type . $linker . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="' . BASE_URL . '/tags/list/' . $type . $linker . '1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 11)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/tags/list/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/tags/list/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/tags/list/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/tags/list/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 11)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="' . BASE_URL . '/tags/list/' . $type . $linker . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="' . BASE_URL . '/tags/list' . $type . $linker . ($pagenum + 2) . '">Next &raquo;</a></span>';
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