<?php
	require_once('hibbity/dbinfo.php');

	# All the predefined shit goes here.
	$page_type  = "post";
	$pics       = 20;
	$title      = "all posts";
	$search_tag = '';
	$tag_feed = '';
	$counts     = array();
	$tags       = array();
	$types      = array();
	$id['id']   = array();
	$id['tags'] = array();
	$id['hash'] = array();
	$search_tag = isset($_GET['q']) ? $_GET['q'] : '';
	$pagenum    = isset($_GET["pagenum"]) ? abs($_GET['pagenum'] - 1) : 0;
	$limit      = $pics * $pagenum;
	$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' All Images Feed" href="' . BASE_URL . '/feed" />';
	
	if( !empty($search_tag) )
	{
		$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/' . $search_tag . '" />';
		$search_tags = explode(" ", $search_tag);
		sort($search_tags);
		$search_tags = array_unique($search_tags);
		$title       = htmlspecialchars(implode(' ', $search_tags), ENT_QUOTES);
		$search_tags = array_map('mysql_real_escape_string', $search_tags);
		$find_colors = "WHERE 1=1";
		$count = count($search_tags);
		for($i = 0; $i < $count; $i++)
		{
		
			switch(true)
			{
				case eregi('user:', $search_tags[$i]):
					$user = str_replace('user:', '', $search_tags[$i]);
					if(is_numeric($user))
					{
						$find_colors .= " AND i.owner_id IN (SELECT id FROM `users` WHERE id = " . $user . ")";
					}
					else
					{
						$find_colors .= " AND i.owner_id IN (SELECT id FROM `users` WHERE name = '" . $user . "')";
					}
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('width:', $search_tags[$i]):
					$width = str_replace('width:', '', $search_tags[$i]);
					if(is_numeric($width))
					{
						$find_colors .= " AND i.width = " . $width;
					}
					elseif(eregi('[><=]', $width))
					{
						$find_colors .= " AND i.width " . $width;
					}
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('height:', $search_tags[$i]):
					$height = str_replace('height:', '', $search_tags[$i]);
					if(is_numeric($height))
					{
						$find_colors .= " AND i.height = " . $height;
					}
					elseif(eregi('[><=]', $height))
					{
						$find_colors .= " AND i.height " . $height;
					}
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('rating:', $search_tags[$i]):
					$rating = str_replace('rating:', '', $search_tags[$i]);
					if(is_numeric($rating))
					{
						$find_colors .= " AND i.rating = " . $rating;
					}
					else
					{
						if($rating == 'unrated') $rating = '0';
						if($rating == 'explicit') $rating = '1';
						if($rating == 'questionable') $rating = '2';
						if($rating == 'safe') $rating = '3';
						$find_colors .= " AND i.rating = " . $rating;
					}
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('source:', $search_tags[$i]):
					$site = str_replace('source:', '', $search_tags[$i]);
					$find_colors .= " AND i.source LIKE '%" . $site . "%'";
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('order:', $search_tags[$i]):
					$order = str_replace('order:', '', $search_tags[$i]);
					switch($order)
					{
						case "id":
							$order = "ORDER BY i.id";
							break;
						case "id_desc":
							$order = "ORDER BY i.id DESC";
							break;
						case "filesize":
							$order = "ORDER BY i.filesize DESC";
							break;
						case "filesize_asc":
							$order = "ORDER BY i.filesize";
							break;
						case "resolution":
						case "mpixels":
						case "res":
							$order = "ORDER BY (i.width * i.height) DESC";
							break;
						case "resolution_asc":
						case "mpixels_asc":
						case "res_asc":
							$order = "ORDER BY (i.width * i.height)";
							break;
						case "landscape":
							$order = "ORDER BY (i.width < i.height)"; // Reversed because of ordering.
							break;
						case "portrait":
							$order = "ORDER BY (i.width > i.height)";
							break;
					}
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
				case eregi('parent:', $search_tags[$i]):
					$parent_post = str_replace('parent:', '', $search_tags[$i]);
					$find_colors .= " AND i.parent_post = " . $parent_post;
					unset($search_tags[$i]);
					break;
				case eregi('fav:', $search_tags[$i]):
					$fav_user = str_replace('fav:', '', $search_tags[$i]);
					$faves = "`favourites` f LEFT OUTER JOIN";
					$faves_join = "ON `f`.`image_id` = `i`.`id`";
					$find_colors .= " AND f.user_id = " . $fav_user;
					unset($search_tags[$i]);
					break;
				case iscolor($search_tags[$i]):
					$find_colors .= " AND (i.primary_color = '" . $search_tags[$i] . "')"; // OR i.secondary_color = '" . $search_tags[$i] . "' OR i.tertiary_color = '" . $search_tags[$i] . "')";
					$tag_feed = '<link rel="alternate" type="application/rss+xml" title="' . SITE_NAME . ' Feed For: ' . $search_tag . '" href="' . BASE_URL . '/feed/" />';
					unset($search_tags[$i]);
					break;
			}

		}
		if(!empty($search_tags))
		{
			$search_tag = "HAVING FIND_IN_SET('" . implode("', tags) > 0 AND FIND_IN_SET('", $search_tags) . "', tags) > 0 ";
		}
		else
		{
			$search_tag = "";
		}
	}
	if(!isset($order))
	{
		$order = "ORDER BY i.id DESC";
	}
	$page_title = "Viewing " . $title . " - " . SITE_NAME;

	$sql = "SELECT SQL_CALC_FOUND_ROWS i.id, i.hash, group_concat(t.tag " . $tags_id . " separator ',') AS tags, group_concat(t.count separator ',') AS counts, group_concat(t.type separator ',') AS types, u.name FROM " . $faves . " `images` i " . $faves_join . " LEFT OUTER JOIN `image_tags` s ON i.id = s.image_id LEFT OUTER JOIN `tags` t ON s.tag_id = t.id LEFT OUTER JOIN `users` u ON i.owner_id = u.id " . $find_colors . " GROUP BY i.id " . $search_tag . $order . " LIMIT " . $limit . ", " . $pics;
	//echo $sql;
	$get = mysql_query($sql);
	$sql = "";

	while( $run = mysql_fetch_assoc($get) )
	{
		$id['id'][] .= $run['id'];
		$id['tags'][] .= $run['tags'];
		$id['hash'][] .= $run['hash'];
		$id['name'][] .= $run['name'];
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
	
	$head =	array
		(
			'js_load' =>	array
						(
							'/lib/index.js'
						),
			'js_out' => '
						 window.addEvent(\'domready\', function() {
							new Autocompleter.Local(\'tag_editor_bucket\', tags, {
							\'minLength\': 1, // We need at least 1 character
							\'selectMode\': \'true\', // Instant completion
							\'separator\': \' \', // NOT DEFAULT NO MORE BITCHES.
							\'multiple\': true // Tag support, by default comma separated
							});
						}); 
							'
						,
			'generic_out' =>	$tag_feed
		);
	$pages = ceil(mysql_found_rows() / $pics);
	require_once("header.php");
?>


<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        <div id="tag_list">
        	<div class="block_title">
            	Mode
            </div>
            <div class="block_content">
				<select name="mode" id="mode">
                	<option id="mode_view" value="view">View Posts</option>
                    <?php
						if( USER_LEVEL >= IMAGE_EDIT )
						{
					?>
						<option id="mode_edit_tags" value="edit_tags">Edit Tags</option>
					<?php
						}
					?>
					<?php
						if( isadmin($_COOKIE['user_id']) )
						{
					?>
						<option id="mode_delete" value="delete_images_84838ss">Delete Tags</option>
					<?php
						}
					?>
                </select>
            </div>
        </div>
        
        <div id="tag_list">
        	<div class="block_title">
            	Popular Tags
            </div>
            <div class="block_content">
            	<?php
					$sql = "SELECT tag, count, type FROM tags WHERE count > 0 ORDER BY count DESC LIMIT 15";
					$get = mysql_query($sql);
					while($run = mysql_fetch_assoc($get))
					{
						echo '<a href="', BASE_URL, '/post/list/' , $run['tag'] , '" class="' . $run['type'] . '">' , str_replace('_', ' ', $run['tag']) , '</a> ' , $run['count'] , '<br />';
					}
				?>
            </div>
        </div>
        
        <div id="tag_list">
        	<div class="block_title">
            	Current Page Tags
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
        	Viewing <?php echo $title ?>
        </div>
        <div id="alert">
	    </div>
        <div class="spacer"></div>
		<?php
			if( USER_LEVEL >= IMAGE_EDIT )
			{
		?>
        <div id="tag_editor" style="display:none;">
        	<form id="tag_editor_form" action="<?php echo BASE_URL ?>/save" method="post">
            <span id="tag_editor_span">Editing post: <span id="editing"></span></span><br />
        	<textarea name="tag_field" id="tag_editor_bucket"></textarea>
            <input type="hidden" name="from_main" id="from_main" value="1" />
            <input type="hidden" name="old_tags" id="tag_editor_old_tags" />
            <input type="hidden" name="picture_id" id="tag_editor_id" /><br />
            <input type="button" id="tag_editor_save" value="Save" />
            <input type="button" id="tag_editor_cancel" value="Cancel" /><br />
            </form>
        </div>
		<?php
			}
		?>
    		<?php
				$size       = sizeof($id['id']);
				for($i = 0; $i < $size; ++$i)
				{
					$imgtags = str_replace(",", " ", $id['tags'][$i]);
			        $class = "";
					if(ereg('tagme', $imgtags)) 
					{
						$class = ' class="tagme"';
					}
					elseif($imgtags == "") 
					{
						$class = ' class="tagless"';
					}
					echo '
							<div class="list_image">
								<a href="', BASE_URL , '/post/view/' , $id['id'][$i] , '" id="' . $id['id'][$i] . '">
									<img src="',  BASE_URL , '/thumbs/' , $id['hash'][$i] , '.jpg" alt="' , $imgtags , '" title="' , $imgtags , '"' , $class , ' />
								</a>
							</div>';
				}
			?>
		<div style="clear:both;"></div>
        <div id="pages">
			<?php
				$search_tag = '';
				if( isset($_GET["q"]) ) $search_tag = '/' . $_GET["q"];

				if($pages > 1)
				{
					if( $pagenum )
						echo '<span><a href="', BASE_URL , '/post/list' , $search_tag , '/' , ($pagenum) , '">&laquo; Previous</a></span>';

					if($pagenum == 0) $this_page = ' class="current_page"';
					else $this_page = '';
					echo '<span><a href="', BASE_URL , '/post/list' , $search_tag , '/1"' , $this_page , '>1</a>';
					$this_page = '';
					
					if($pages < 10)
					{
						for($i = 2; $i <= $pages; $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/post/list' . $search_tag . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
					}
					elseif($pagenum > ($pages - 10))
					{
						echo '...';
						for($i = ($pages - 9); $i < ($pages); $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/post/list' . $search_tag . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}   
					}
					elseif($pagenum > 7)
					{
						echo '...';
						for($i = ($pagenum - 3); $i <= ($pagenum + 5); $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/post/list' . $search_tag . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
						echo '...';
					}
					else
					{
						for($i = 2; $i <= 9; $i++)
						{
							if($i == $pagenum+1) $this_page = ' class="current_page"';
							else $this_page = "";
							echo '<a href="', BASE_URL , '/post/list' . $search_tag . '/' . $i . '"' . $this_page . '>' . $i . '</a>';
						}
						echo '...';
					}
					
					if($pages >= 10)
					{
						if($pages == $pagenum+1) $this_page = ' class="current_page"';
						else $this_page = '';	
						echo '<a href="', BASE_URL , '/post/list' . $search_tag . '/' . $pages . '"' . $this_page . '>' . $pages . '</a>';
					}
					echo "</span>";
					
					if($pages != $pagenum+1)
					{
						echo '<span><a href="', BASE_URL , '/post/list' . $search_tag . '/' . ($pagenum + 2) . '">Next &raquo;</a></span>';
					}
				}
               ?>
        </div>
        
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>