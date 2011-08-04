<?php
	require_once('hibbity/dbinfo.php');
	
	
	$page_type = "tags";
	$pics      = 40;
	$tag_type  = '';
	$pagenum   = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit     = $pics * $pagenum;

	$page_title = "Viewing Alias List - " . SITE_NAME;

	$sql = "SELECT oldtag FROM `aliases` ORDER BY oldtag";
	$get = mysql_query($sql);

	$total = mysql_num_rows($get);
	$pages = ceil($total / $pics);

	$sql = "SELECT id, oldtag, newtag, reason FROM `aliases` ORDER BY oldtag LIMIT " . $limit . ", " . $pics;
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
        	Viewing Alias List
        </div>
        <div id="alert"></div>
        
        <div class="spacer"></div>
        	
         <div id="aliases">
            <table cellpadding="0" cellspacing="0">
            	<tr>
                    <th>
                    	Entered Tag
                    </th>
                    <th>
                    	Becomes
                    </th>
            		<th>
                    	Reason
                    </th>
					<th>
                    	&nbsp;
                    </th>
                </tr>
    		<?php
				while( $run = mysql_fetch_assoc($get) )
				{	
					if( !empty($run['oldtag']) )
					{
						echo '
								<tr>
									<td style="border-right: 1px dotted #999;width: 150px;">' , $run['oldtag'] , '</td>
									<td style="border-right: 1px dotted #999;width: 150px;">' , $run['newtag'] , '</td>
									<td style="border-right: 1px dotted #999;">' , $run['reason'] , '</td>
									<td style="width: 30px;">';
									if(USER_LEVEL >= TAG_EDIT)
									{
										echo '<a href="', BASE_URL , '/aliases/edit/' , $run['id'] , '">edit</a>';
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
						echo '<span><a href="' . BASE_URL . '/aliases/list/' . $type . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="' . BASE_URL . '/aliases/list/' . $type . '1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 11)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/aliases/list/' . $type . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/aliases/list/' . $type . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/aliases/list/' . $type . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/aliases/list/' . $type . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 11)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="' . BASE_URL . '/aliases/list/' . $type . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1 && $pages > 1)
					{
						echo '<span><a href="' . BASE_URL . '/aliases/list/' . $type . ($pagenum + 2) . '">Next &raquo;</a></span>';
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