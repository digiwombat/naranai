<?php
	require_once('hibbity/dbinfo.php');
	

	$pic = abs($_GET['picture_id']);
	if( !$pic )
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}

	$page_type     = "post";
	$unrated       = '';
	$explicit      = '';
	$questionable  = '';
	$safe          = '';
	$unrated       = '';
	$rating        = '';
	$counts_proper = array();

	$sql = "SELECT i.id, i.filename, i.source, i.height, i.width, i.hash, i.ext, i.posted, i.numeric_score, i.rating, i.parent_post, group_concat(t.tag ORDER BY t.tag separator ' ') AS tags, group_concat(t.count ORDER BY t.tag separator ' ') AS counts, group_concat(t.type ORDER BY t.tag separator ' ') AS types FROM `images` i LEFT OUTER JOIN `image_tags` s ON  i.id = s.image_id LEFT OUTER JOIN `tags` t ON s.tag_id = t.id WHERE i.id = " . $pic . " GROUP BY i.id";
	$get = mysql_query($sql);

	if( !mysql_num_rows($get) )
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}

	$run = mysql_fetch_assoc($get);

	$sql        = "SELECT CAST(id as UNSIGNED) FROM notes WHERE image_id = " . $pic . " ORDER BY id DESC LIMIT 1";
	$h          = mysql_query($sql);
	$note_count = mysql_num_rows($h) ? mysql_result($h, 0) : 0;
	
	if(EDITOR_STYLE == 'normal')
	{
		$ac = "
		window.addEvent('domready', function() { 
			new Autocompleter.Local('img_tags', tags, {
				'minLength': 1, // We need at least 1 character
				'selectMode': 'true', // Instant completion
				'separator': ' ', // NOT DEFAULT NO MORE BITCHES.
				'multiple': true // Tag support, by default comma separated
			});
		});";
		$load = array
						(
							'/lib/formcheck.js',
							'/lib/moocombo.js',
							'/lib/view.js'
						);
	}
	else
	{
		$load = array
						(
							'/lib/textboxlist.js',
							'/lib/facebooklist.js',
							'/lib/formcheck.js',
							'/lib/moocombo.js',
							'/lib/view.js'
						);
	}
	$head =	array
		(
			'js_load' =>	$load,
			'js_var'  =>	array
						(
							'orig_width' => $run['width'],
							'orig_height' => $run['height'],
							'note_id'    => $note_count,
							'base_url'   => BASE_URL,
							'editor_style'	=> EDITOR_STYLE
						),
			'css_load' =>	array
						(
							'/styles/' . STYLE_DIR . '/facelist.css',
							'/styles/' . STYLE_DIR . '/comments.css',
							'/styles/' . STYLE_DIR . '/formcheck.css'
						),
			'js_out' => $ac
		);
	
	$page_title = "Post " . $run['id'] . " - " . SITE_NAME;
	
	$source = empty($run['source']) ? "None" : '<a href="' . $run['source'] . '">' . $run['source'] . '</a>';
	
	$form_tags = $run['tags'];
	$tags      = explode(" ", $run['tags']);
	$counts    = explode(" ", $run['counts']);
	$types     = explode(" ", $run['types']);
	
	$sql_user = "SELECT u.id, u.name FROM `images` i LEFT OUTER JOIN `users` u ON i.owner_id = u.id WHERE i.id = " . $pic;
	$get_user = mysql_query($sql_user);
	$run_user = mysql_fetch_assoc($get_user);
	
	$sql_re = "SELECT count(*) FROM `favourites` WHERE image_id = " . $pic;
	$get_re = mysql_query($sql_re);
	$fav_count = mysql_result($get_re, 0);
	
	$sql_re = "SELECT `id` FROM `images` WHERE `id` < " . $pic . " ORDER BY `id` DESC LIMIT 1";
	$get_re = mysql_query($sql_re);
	$prev_post = @mysql_result($get_re, 0);
	
	$sql_re = "SELECT `id` FROM `images` WHERE `id` > " . $pic . " ORDER BY `id` LIMIT 1";
	$get_re = mysql_query($sql_re);
	$next_post = @mysql_result($get_re, 0);
	
	$sql_re = "SELECT g.id, g.group_name FROM `image_groups` i INNER JOIN `groups` g ON i.group_id = g.id WHERE i.image_id = " . $pic;
	$get_re = mysql_query($sql_re);
	$group_name = mysql_fetch_assoc($get_re);
	$group_id = $group_name['id'];
	$group_name = $group_name['group_name'];
	
	$sql_re = "SELECT `image_id` FROM `image_groups` WHERE `image_id` > " . $pic . " AND `group_id` = " . $group_id . " ORDER BY `image_order`, `image_id` LIMIT 1";
	$get_re = mysql_query($sql_re);
	$group_next = @mysql_result($get_re, 0);
	
	$sql_re = "SELECT `image_id` FROM `image_groups` WHERE `image_id` < " . $pic . " AND `group_id` = " . $group_id . " ORDER BY `image_order` DESC, `image_id` DESC LIMIT 1";
	$get_re = mysql_query($sql_re);
	$group_prev = @mysql_result($get_re, 0);
	
	$sql_child = "SELECT `id` FROM `images` WHERE `parent_post` = " . $pic;
	$get_child = mysql_query($sql_child);
	$child_posts = mysql_num_rows($get_child);
	
	if($group_name != '')
	{
		$group_info = 'This post belongs to the <strong>' . $group_name . '</strong> group.
						<br />';
		if($group_prev)
		{
			$group_info .= '<a href="' . BASE_URL . '/post/view/' . $group_prev . '">Previous</a> | ';
		}
		if($group_next)
		{
			$group_info .= '<a href="' . BASE_URL . '/post/view/' . $group_next . '">Next</a> | ';
		}
		$group_info .= '<a href="' . BASE_URL . '/group/view/' . $group_id . '">View All</a>';
		$group		= '<a href="' . BASE_URL . '/group/view/' . $group_id . '">' . $group_name . '</a>';
	}
	else
	{
		$group = "None";
	}
	
	$size = sizeof($counts);
	for($i = 0; $i < $size; ++$i) $counts_proper[] = array($counts[$i], $types[$i]);

	$counts = "";
	
	$tags = array_combine($tags, $counts_proper);
	//arsort($tags, SORT_STRING);
	array_slice($tags, 0, 15);
	$parent_post = $run['parent_post'];
	switch($run['rating'])
	{
		case 0:
			$unrated = ' checked="checked"';
			$rating = 'unrated';
			break;
		case 1:
			$explicit = ' checked="checked"';
			$rating = 'explicit';
			break;
		case 2:
			$questionable = ' checked="checked"';
			$rating = 'questionable';
			break;
		case 3:
			$safe = ' checked="checked"';
			$rating = 'safe';
			break;
		default:
			$unrated = ' checked="checked"';
			$rating = 'unrated';
			break;
	}
	
	require_once("header.php");

?>


<div id="main">
	
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        <div id="tag_list">
        	<div class="block_title">
            	Image Tags
            </div>
            <div class="block_content">
            	<?php
					foreach($tags as $tag => $count)
					{
						echo '<a href="' , BASE_URL , '/post/list/' , $tag , '" class="' , $count[1] , '">' , str_replace('_', ' ', $tag) , '</a> ' , $count[0] , '<br />';
					}
				?>
            </div>
        </div>
		
		<div id="file_info">
        	<div class="block_title">
            	File Info
            </div>
            <div class="block_content">
            	<strong>Resolution:</strong> <?php echo $run['width'] , 'x' , $run['height']; ?><br />
                <strong>Rating:</strong> <?php echo $rating; ?><br />
                <strong>Score:</strong> <?php echo $run['numeric_score']; ?><br />
				<strong>Favourites:</strong> <?php echo $fav_count; ?>
            </div>
        </div>
        
		<div id="img_admin">
        	<div class="block_title">
            	Options
            </div>
            <div class="block_content">
				<a id="resize">Resize Image</a><br />
				<?php
						if( USER_LEVEL >= IMAGE_EDIT )
						{
				?>
					<a id="add_note">Add Translation</a><br />
            	<?php
						}
						if(isset($_COOKIE['user_id']))
						{
							$sqlfav = "select id from `favourites` where image_id =" . $pic . " AND user_id = " . $_COOKIE['user_id'];
							$getfav = mysql_query($sqlfav);
							$isfav = mysql_num_rows($getfav);
							if($isfav > 0)
							{
								echo '<a id="remove_favorite">Remove from Favourites</a>
									<a id="add_favorite" style="display:none;">Add to Favourites</a>';
							}
							else
							{
								echo '<a id="remove_favorite" style="display:none;">Remove from Favourites</a>
									<a id="add_favorite">Add to Favourites</a>';
							}
						}
						echo '<br />';

						if( USER_LEVEL >= IMAGE_EDIT )
						{
							if($group_id >= 0)
							{
								echo '<a href="', BASE_URL , '/group/remove/' , $pic , '" onclick="return confirm_delete(\'group\');">Remove from Group</a><br />';
							}
						}

						if( isadmin() )
						{
							echo '<a href="', BASE_URL , '/admin/delete/' , $pic , '" onclick="return confirm_delete();">Remove Image</a><br />';
						}
				?>
            </div>
        </div>
		
		<div id="related">
        	<div class="block_title">
            	Related Posts
            </div>
            <div class="block_content">
				<?php
					if($prev_post)
					{
				?>
            	<a href="<?php echo BASE_URL . '/post/view/' . $prev_post ?>">Previous</a><br />
				<?php
					}
				?>
				<?php
					if($next_post)
					{
				?>
                <a href="<?php echo BASE_URL . '/post/view/' . $next_post ?>">Next</a><br />
				<?php
					}
				?>
				<a href="<?php echo BASE_URL ?>/post/random">Random</a><br />
            </div>
        </div>
		
    </div>
	
    <div id="content">
    	<div id="page_title">
        	Viewing post <?php echo $pic; ?>
        </div>
        <div id="alert">  		
	    </div>
		<div id="group" class="alert" <?php if($group_id) echo 'style="display:block;"'; ?>>
			<?php echo $group_info; ?>
		</div>
		<div id="parent-post" class="alert" <?php if($parent_post) echo 'style="display:block;"'; ?>>
			This image has a <a href="<?php echo BASE_URL . '/post/view/' . $parent_post; ?>">parent post</a>
		</div>
		<div id="child-posts" class="alert" <?php if($child_posts) echo 'style="display:block;"'; ?>>
			This image has <a href="<?php echo BASE_URL . '/post/list/parent:' . $pic ?>">child posts</a>
		</div>
        <div class="spacer"></div>
        
        <div id="note-holder" style="display:none;">
			<textarea rows="7" id="note_text" style="margin: 2px 2px 12px; width: 350px;"></textarea><br />
            <input type="button" value="Save" id="note_save" /><input type="button" value="Cancel" id="note_cancel" />
			<?php
				if(isadmin($_COOKIE['user_id']))
				{
					echo '<input type="button" value="Remove" id="note_remove" style="display:none;" />';
				}
			?>
            <input type="hidden" id="note_id" value="new" />
            <input type="hidden" id="note_new" value="true" />
            <input type="hidden" id="note_image_id" value="<?php echo $pic; ?>" />
            <input type="hidden" id="note_user_id" value="<?php echo isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : 0; ?>" />
        </div>
        
        <div id="image_holder">

    		<?php
				$sql_notes = "SELECT * FROM `notes` WHERE `image_id` = " . $pic;
				$get_notes = mysql_query($sql_notes);
				$pic_note_count = mysql_num_rows($get_notes);
				while($run_notes = mysql_fetch_assoc($get_notes))
				{
					echo '<div id="note_' , $run_notes['id'] , '" class="image_note" style="position: absolute; left: ' , $run_notes['x'] , 'px; top: ' , $run_notes['y'] , 'px; width: ' , $run_notes['width'] , 'px; height: ' . $run_notes['height'] . 'px;cursor: default;" onmouseover="this.getElement(\'.tip\').show();" onmouseout="this.getElement(\'.tip\').hide();">
						<div id="drag_' , $run_notes['id'] , '" class="drag">
							
						</div>
						<div class="tip_space"></div>
						<div id="tip_' , $run_notes['id'] , '" class="tip" style="display: none;cursor: default;">
							' , schmancy(nl2br(stripslashes($run_notes['note'])), 'tn') , '
						</div>
						<div id="tip_original_' , $run_notes['id'] , '" style="display:none;">
							' . $run_notes['note'] . '
						</div>
					</div>';
				}
				echo '<img id="main_image" src="' , BASE_URL , '/images/' , $run['hash'] , '.' , $run['ext'] , '" alt="" />';
				
			?>

        </div>
        
		<div id="main_info">
        	
            <div>
            	<span>
                    <strong>Uploader:</strong> <a href="<?php echo BASE_URL . '/user/profile/' . $run_user['id'] ?>"><?php echo $run_user['name'] ?></a>
                </span>
                <span>
                    <strong>Posted:</strong> <?php echo fuzzy_time($run['posted']); ?>
                </span>
                <span>
	                <strong>Original Name:</strong> <?php echo $run['filename'] ?>
				</span>
                <span>
                    <strong>Source:</strong> <?php echo $source; ?>
                </span>
                <span>
                    <strong>Group:</strong> <?php echo $group; ?>
                </span>
			</div>
            
            <div>
			<?php
				if( USER_LEVEL >= IMAGE_EDIT )
				{
			?>
                <span>
                    <a id="editclick">Edit</a>
                </span>
			<?php
				}
			?>
                <span>
                    <a>History</a>
                </span>
			</div>
            
        </div>
        <?php
			if( USER_LEVEL >= IMAGE_EDIT )
			{
		?>
		<div id="edit">
        	<form id="tagform" action="<?php echo BASE_URL; ?>/save" method="post">
            
        	<div>
                <span class="edit_title">
                    Source
                </span>
                <span class="edit_form">
                    <input type="text" name="source_field" id="source_field" value="<?php echo $run['source']; ?>" style="width:350px;" class="validate['url']" />
                </span>
            </div>
            
            <div>
                <span class="edit_title">
                    Group
                </span>
                <span class="edit_form" style="position:relative">
                	
                    <select name="group_field" id="group_field" class="combo_box">
                    	<option value="None">None</option>
                    	<?php
							$sql_group = "SELECT id, group_name FROM `groups`";
							$get_group = mysql_query($sql_group);
							
							while($run_group = mysql_fetch_assoc($get_group))
							{
								$select = "";
								if($group_id == $run_group["id"])
								{
									$select = ' selected="selected"';
								}
								if($run_group["group_name"] != "")
								{
						?>
                        	
								<option value="<?php echo stripslashes($run_group["group_name"]); ?>"<?php echo $select; ?>><?php echo stripslashes($run_group["group_name"]); ?></option>
                            
                        <?php
								}
							}
						?>
                    </select>
                </span>
            </div>
            
            <div>
                <span class="edit_title">
                    Rating
                </span>
                <span class="edit_form">
	                <label class="radio">
                        <input id="rating_unrated" type="radio" value="0" name="rating"<?php echo $unrated; ?> />
                        Unrated
                    </label>
                    <label class="radio">
                        <input id="rating_explicit" type="radio" value="1" name="rating"<?php echo $explicit; ?> />
                        Explicit
                    </label>
                    <label class="radio">
                        <input id="rating_questionable" type="radio" value="2" name="rating"<?php echo $questionable; ?> />
                        Questionable
                   </label>
                   <label class="radio">
                        <input id="rating_safe" type="radio" value="3" name="rating"<?php echo $safe; ?> />
                        Safe
                   </label>
				</span>
			</div>
			
			<div>
                <span class="edit_title">
                    Parent Post
                </span>
                <span class="edit_form">
	                <label class="radio">
                        <input id="parent_post" type="text" name="parent_post" value="<?php echo $parent_post; ?>" />
                    </label>
				</span>
			</div>
            
            <div>
                <span class="edit_title">
                    Tags
                </span>
                <span class="edit_form">
                    <textarea name="tag_field" id="img_tags"<?php if( EDITOR_STYLE == 'normal' ) echo ' style="width:350px;height:100px;"' ?>><?php echo $form_tags; ?></textarea>
					<?php
						if( EDITOR_STYLE == 'enhanced' )
						{
					?>
                    <div id="taglist">
                    	<div class="default">
                        	Type for delicious tag search. Need a new tag? Type it and hit space.
						</div>
                    	<?php
								
								echo "<ul>";
								if(!$form_tags)
								{
									echo "<li>tagme</li>";	
								}
								else
								{
									$form_tag_loop = explode(" ", $form_tags);
									foreach($form_tag_loop as $form_tag)
									{
										echo "<li>" , $form_tag , "</li>";	
									}
								}
								echo "</ul>";
						?>
                    </div>
					<?php
						}
					?>
                </span>
            </div>
            
            <div>
                <span class="edit_title">
                    &nbsp;
                </span>
                <span class="edit_form">
                	<input type="hidden" name="picture_id" value="<?php echo $pic; ?>" />
                    <input type="hidden" name="old_tags" value="<?php echo $form_tags; ?>" />
                    <input type="submit" name="submit" value="Save Changes" />
                </span>
            </div>
            
            </form>
			
        </div>
        <?php
			}
		?>
        <div id="comments">
        	<ol class="comment">
            <?php
					$sql_block = "SELECT c.id, c.owner_id, u.name, u.email, c.posted, c.comment FROM `comments` c LEFT OUTER JOIN `users` u ON c.owner_id = u.id WHERE c.image_id = " . $pic . " ORDER BY c.id";
					$get_block = mysql_query($sql_block);
					$size = 40;
					while($run_block = mysql_fetch_assoc($get_block))
					{
					$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" . md5(strtolower($run_block['email'])) . "&d=identicon&size=" . $size; 
			?>
                        	<li id="comment-<?php echo $run_block['id'] ?>">
								<span class="info">
									<span class="poster">
										<img src="<?php echo $grav_url ?>" alt="<?php echo $run_block['name'] ?>" />
										<a href="<?php echo BASE_URL . '/user/profile/' . $run_block['owner_id'] ?>"><?php echo $run_block['name'] ?></a>
									</span>
									<span class="time">
										<abbr class="time" title="<?php echo date('D M j h:m:s', strtotime($run_block['posted'])); ?>"><?php echo fuzzy_time($run_block['posted']) ?></abbr>
									</span>
								</span>
					
								<div class="content">
									<p>
										<?php echo schmancy(stripslashes(nl2br($run_block['comment'])), 'comment'); ?>
									</p>
								</div>
								<div class="actions">
									<span class="self">
									</span>
									<span class="pointquote">
									</span>
								</div>
								</li>
			<?php
					}
			?>
            	
            </ol>
        </div>
        <?php
			if( USER_LEVEL >= COMMENT_LEVEL )
			{
		?>
        <div id="response">
        	
           <form id="comment_form" action="<?php echo BASE_URL; ?>/comment" method="post">
    
           		<div>
    	            <span class="edit_title">
            	        Comment
        	        </span>
                	<span class="edit_form">
						<textarea name="comment" id="comment_box" class="validate['required']"></textarea>
	                </span>
	            </div>
                
                <div>
	                <span class="edit_title">
    	                &nbsp;
        	        </span>
            	    <span class="edit_form">
                		<input type="hidden" name="picture_id" value="<?php echo $pic; ?>" />
                    	<input type="hidden" name="user_id" value="<?php echo isset($_COOKIE["user_id"]) ? (int) $_COOKIE["user_id"] : 0; ?>" />
	                    <input type="submit" name="submit" value="Post Comment" />
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
