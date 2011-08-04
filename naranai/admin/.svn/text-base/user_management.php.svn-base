<?php

	require_once('../hibbity/dbinfo.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	
	$page_type = "account";
	$pics      = 40;
	$pagenum   = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit     = $pics * $pagenum;

	$page_title = "User Management - " . SITE_NAME;

	$sql = "SELECT id FROM `users` WHERE `approved` = 1 ORDER BY id";
	$get = mysql_query($sql);

	$total = mysql_num_rows($get);
	$pages = ceil($total / $pics);

	$sql = "SELECT `id`, `name`, `user_level`, `email` FROM `users` WHERE `approved` = 1 ORDER BY id LIMIT " . $limit . ", " . $pics;
	$get = mysql_query($sql);

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
        	User Management
        </div>
        <div id="alert"></div>
        
        <div class="spacer"></div>
        
         <div id="tags">
            <table cellpadding="0" cellspacing="0">
            	<tr>
                    <th>
                    	ID
                    </th>
                    <th>
                    	User Name
                    </th>
            		<th>
                    	E-Mail
                    </th>
					<th>
                    	Status
                    </th>
                </tr>
    		<?php
				while( $run = mysql_fetch_assoc($get) )
				{	
					if( !empty($run["id"]) && $run['id'] != 1 )
					{
						$status = '';
						switch($run['user_level'])
						{
							case 0:
								$status = '<strong>Banned</strong> | <a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/user">User</a> | <a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/admin">Admin</a>';  //&nbsp; <span class="small">[<a href="' . BASE_URL . '/admin/user/delete/' . $run['id'] . '">Delete</a>]</span>';
								break;
							case 1:
								$status = '<a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/ban">Banned</a> | <strong>User</strong> | <a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/admin">Admin</a>';  //&nbsp; <span class="small">[<a href="' . BASE_URL . '/admin/user/delete/' . $run['id'] . '">Delete</a>]</span>';
								break;
							case 10:
								$status = '<a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/ban">Banned</a> | <a href="' . BASE_URL . '/admin/user/status/' . $run['id'] . '/user">User</a> | <strong>Admin</strong>'; //&nbsp; <span class="small">[<a href="' . BASE_URL . '/admin/user/delete/' . $run['id'] . '">Delete</a>]</span>';
								break;
							case 11:
								$status = 'HERE BE A GOD!';
								break;
							default:
								$status = '';
						}
						
						echo '
								<tr>
									<td style="border-right: 1px dotted #999;text-align:right;width: 50px;">' . $run['id'] . '</td>
									<td style="border-right: 1px dotted #999;">' , $run['name'] , '</td>
									<td style="border-right: 1px dotted #999;">' , $run['email'] , '</td> 
									<td style="width: 150px;">
									 ' . $status . '
									</td>
									</tr>';
					}
				}
			?>
			</table>
            </div>
            
            <div id="pages">
        	
				<?php
					$type = isset($_GET["type"]) ? $_GET['type'] . '/' : '';
					if(isset($find_tag))
					{
						$linker = $find_tag . '/';
					}
					if($pagenum > 0)
					{
						echo '<span><a href="' . BASE_URL . '/admin/users/' . $type . $linker . ($pagenum) . '">&laquo; Previous</a></span>';
					}
					else
					{
						echo '<span>&laquo; Previous</span>';	
					}
					
					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="' . BASE_URL . '/admin/users/' . $type . $linker . '1"' . $this_page . '>1</a>';
					$this_page = '';
                    
					if($pages < 11)
					{
						for($i = 2; $i <= $pages; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/admin/users/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
					}
					elseif($pagenum > ($pages - 10))
                    {
                        echo '...';
                        for($i = ($pages - 9); $i < ($pages); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/admin/users/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }   
                    }
					elseif($pagenum > 7)
                    {
                        echo '...';
                        for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/admin/users/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
                    else
                    {
                        for($i = 2; $i <= 9; $i++)
                        {
                            if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
                            echo '<a href="' . BASE_URL . '/admin/users/' . $type . $linker . $i . '"' . $this_page . '>' . $i . '</a>';
                        }
                        echo '...';
                    }
					
					if($pages >= 11)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="' . BASE_URL . '/admin/users/' . $type . $linker . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1)
					{
						echo '<span><a href="' . BASE_URL . '/admin/users/' . $type . $linker . ($pagenum + 2) . '">Next &raquo;</a></span>';
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
	require_once("../footer.php");
?>