<?php
	require_once('hibbity/dbinfo.php');

	if( USER_LEVEL < GROUP_EDIT ) {
		header("Location: " . BASE_URL . "/group/list");
		exit();
	}

	$page_type = "groups";
	$normal    = '';
	$character = '';
	$artist    = '';
	$series    = '';

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

	$thing = "Add Group";
	$page_title = "Add Group - " . SITE_NAME;
	if( isset($_GET["group"]) )
	{
		$group = $_GET["group"];
		$sql = "SELECT id, group_name, description, active FROM `groups` WHERE `id` = " . abs($_GET["group"]);
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		$thing = "Edit Group";
		$page_title = "Edit Group: " . $run["group_name"] . " - " . SITE_NAME;
		if($run['active'])
		{
			$active = ' checked="checked"';
		}
	}
	
	
	
	require_once("header.php");
	
?>

<div id="main">
    <div id="sidebar">
    
    	<?php
			echo $search_box;
		?>
        
        
    </div>    
	
    <div id="content">
    	<div id="page_title">
        	<?php echo $thing ?> <?php echo $run["group_name"] ?>
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <div id="edit">
	    <form class="registration" id="edit_form" action="<?php echo BASE_URL; ?>/group/edit/commit" method="post">
	                
            
            <div>
                <span class="edit_title">
                    Name
                </span>
                <span class="edit_form">
                    <input type="text" name="name_field" id="name_field" value="<?php echo stripslashes($run["group_name"]); ?>" style="width:250px;" class="validate['required']" />
                </span>
            </div>
            <div>
                <span class="edit_title">
					Description
                </span>
                <span class="edit_form">
                   	<textarea name="description" style="width:250px;height:100px;"><?php echo stripslashes($run["description"]); ?></textarea>
                </span>
            </div>
			<div>
                <span class="edit_title">
					Active
                </span>
                <span class="edit_form">
                   	<input id="active" value="1" name="active" type="checkbox"<?php echo $active ?>>
                </span>
            </div>
            <div>
                <span class="edit_title">
                    &nbsp;
                </span>
                <span class="edit_form">
                	<input type="hidden" name="group_id" value="<?php echo isset($_GET['group']) ? abs($_GET["group"]) : ''; ?>" />
                    <input type="submit" name="submit" value="<?php echo $thing ?>" />
					<?php
						if(isadmin($_COOKIE['user_id']) && isset($run['id']))
						{
							echo '<span class="small"><a href="' . BASE_URL . '/admin/delete/group/' . $run['id'] . '">Delete Group</a></span>';
						}
					?>
                </span>
            </div>

    
        </form>
        </div>
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>