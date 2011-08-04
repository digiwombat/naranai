<?php
	require_once('../hibbity/dbinfo.php');
	
	if( USER_LEVEL < 11 ) {
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}

	$page_type = "account";
	$normal    = '';
	$character = '';
	$artist    = '';
	$series    = '';
	$run       = array('type' => 'normal', 'tag' => '');

	$head =	array
		(
			'js_load' =>	array
						(
							'/lib/formcheck.js'
						),
			'css_load' =>	array
						(
							'/styles/' . STYLE_DIR . '/formcheck.css'
						)
		);

	$page_title = "Edit naranai Settings - " . SITE_NAME;
	$thing = "Edit naranai Settings";
	switch(get_option('permissions_tag_edit'))
	{
		case "0":
			$tag_anon = ' selected="selected"';
			break;
		case "1":
			$tag_user = ' selected="selected"';
			break;
		case "10":
			$tag_admin = ' selected="selected"';
			break;
		case "11":
			$tag_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_image_edit'))
	{
		case "0":
			$image_anon = ' selected="selected"';
			break;
		case "1":
			$image_user = ' selected="selected"';
			break;
		case "10":
			$image_admin = ' selected="selected"';
			break;
		case "11":
			$image_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_group_edit'))
	{
		case "0":
			$group_anon = ' selected="selected"';
			break;
		case "1":
			$group_user = ' selected="selected"';
			break;
		case "10":
			$group_admin = ' selected="selected"';
			break;
		case "11":
			$group_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_upload'))
	{
		case "0":
			$upload_anon = ' selected="selected"';
			break;
		case "1":
			$upload_user = ' selected="selected"';
			break;
		case "10":
			$upload_admin = ' selected="selected"';
			break;
		case "11":
			$upload_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_comments'))
	{
		case "0":
			$comment_anon = ' selected="selected"';
			break;
		case "1":
			$comment_user = ' selected="selected"';
			break;
		case "10":
			$comment_admin = ' selected="selected"';
			break;
		case "11":
			$comment_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_forum_view'))
	{
		case "0":
			$forum_view_anon = ' selected="selected"';
			break;
		case "1":
			$forum_view_user = ' selected="selected"';
			break;
		case "10":
			$forum_view_admin = ' selected="selected"';
			break;
		case "11":
			$forum_view_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_forum_add'))
	{
		case "0":
			$forum_add_anon = ' selected="selected"';
			break;
		case "1":
			$forum_add_user = ' selected="selected"';
			break;
		case "10":
			$forum_add_admin = ' selected="selected"';
			break;
		case "11":
			$forum_add_owner = ' selected="selected"';
			break;
	}
	switch(get_option('permissions_forum_reply'))
	{
		case "0":
			$forum_reply_anon = ' selected="selected"';
			break;
		case "1":
			$forum_reply_user = ' selected="selected"';
			break;
		case "10":
			$forum_reply_admin = ' selected="selected"';
			break;
		case "11":
			$forum_reply_owner = ' selected="selected"';
			break;
	}
	if(get_option('tag_editor') == 'normal')
	{
		$normal = ' checked="checked"';
	}
	else
	{
		$enhanced = ' checked="checked"';
	}
		
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
        	<?php echo $thing ?>
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <div id="edit">
	    <form class="registration" id="edit_form" action="<?php echo BASE_URL; ?>/admin/settings/save" method="post">
	    <fieldset>
        <legend>Permissions</legend>
			<div>
                <span class="setting_title">
					Upload Photos
                </span>
                <span class="setting_form">
                   	<select id="uploads" name="uploads">
	                    <option value="0"<?php echo $upload_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $upload_user ?>>Registered Users</option>
                        <option value="10"<?php echo $upload_admin ?>>Administrators</option>
						<option value="11"<?php echo $upload_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			<div>
                <span class="setting_title">
					Create Comments
                </span>
                <span class="setting_form">
                   	<select id="comments" name="comments">
	                    <option value="0"<?php echo $comment_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $comment_user ?>>Registered Users</option>
                        <option value="10"<?php echo $comment_admin ?>>Administrators</option>
						<option value="11"<?php echo $comment_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			<div>
                <span class="setting_title">
					Edit Images<br /><span class="small">Source, Tags, Rating, Etc.</span>
                </span>
                <span class="setting_form">
                   	<select id="edit_images" name="edit_images">
	                    <option value="0"<?php echo $image_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $image_user ?>>Registered Users</option>
                        <option value="10"<?php echo $image_admin ?>>Administrators</option>
						<option value="11"<?php echo $image_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
            <div>
                <span class="setting_title">
					Add/Edit Tags<br /><span class="small">Includes aliases and implications.</span>
                </span>
                <span class="setting_form">
                   	<select id="edit_tags" name="edit_tags">
	                    <option value="0"<?php echo $tag_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $tag_user ?>>Registered Users</option>
                        <option value="10"<?php echo $tag_admin ?>>Administrators</option>
						<option value="11"<?php echo $tag_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			<div>
                <span class="setting_title">
					Add/Edit Groups<br /><span class="small">Doesn't cover things added through image editing.</span>
                </span>
                <span class="setting_form">
                   	<select id="edit_groups" name="edit_groups">
	                    <option value="0"<?php echo $group_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $group_user ?>>Registered Users</option>
                        <option value="10"<?php echo $group_admin ?>>Administrators</option>
						<option value="11"<?php echo $group_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			</fieldset>
			<fieldset>
			<legend>Forum Settings</legend>
			<div>
                <span class="setting_title">
					View Forum
                </span>
                <span class="setting_form">
                   	<select id="forum_view" name="forum_view">
	                    <option value="0"<?php echo $forum_view_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $forum_view_user ?>>Registered Users</option>
                        <option value="10"<?php echo $forum_view_admin ?>>Administrators</option>
						<option value="11"<?php echo $forum_view_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			<div>
                <span class="setting_title">
					Create New Topics
                </span>
                <span class="setting_form">
                   	<select id="forum_add" name="forum_add">
	                    <option value="0"<?php echo $forum_add_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $forum_add_user ?>>Registered Users</option>
                        <option value="10"<?php echo $forum_add_admin ?>>Administrators</option>
						<option value="11"<?php echo $forum_add_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			<div>
                <span class="setting_title">
					Reply to Topics
                </span>
                <span class="setting_form">
                   	<select id="forum_reply" name="forum_reply">
	                    <option value="0"<?php echo $forum_reply_anon ?>>Anonymous Users</option>
                        <option value="1"<?php echo $forum_reply_user ?>>Registered Users</option>
                        <option value="10"<?php echo $forum_reply_admin ?>>Administrators</option>
						<option value="11"<?php echo $forum_reply_owner ?>>Owner</option>
                    </select>
                </span>
            </div>
			</fieldset>
			<fieldset>
			<legend>Other Crap</legend>
			<div>
                <span class="setting_title">
					Tag Editor Style
                </span>
                <span class="setting_form">
                   	<input type="radio" name="editor_style" id="normal" value="normal" style="display:inline;"<?php echo $normal; ?> /><label for="normal" >Plain Textarea w/ Auto Complete</label><br />
					<input type="radio" name="editor_style" id="enhanced" value="enhanced" style="display:inline;"<?php echo $enhanced; ?> /><label for="enhanced">Enhanced Tagging System</label>
                </span>
            </div>
			</fieldset>
			<fieldset>
			<legend>Save Settings</legend>
				<div>
                <span class="setting_title">
                    &nbsp;
                </span>
                <span class="setting_form">
                    <input type="submit" name="submit" value="Save Settings" />
                </span>
            </div>
			</fieldset>
        </form>
        </div>
    </div>    
    
</div>
<?php
	require_once("../footer.php");
?>