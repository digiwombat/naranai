<?php
	require_once('hibbity/dbinfo.php');
	require_once('lib/functions.php');
	
	if( USER_LEVEL < TAG_EDIT ) {
		header("Location: " . BASE_URL . "/aliases/list");
		exit();
	}
	$page_type = "tags";

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

	$thing = "Add Alias";
	$page_title = "Add Alias - " . SITE_NAME;
	if( isset($_GET["alias"]) )
	{
		$sql = "SELECT id, oldtag, newtag, reason FROM `aliases` WHERE `id` = " . abs($_GET["alias"]);
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		$thing = "Edit Alias";
		$page_title = "Edit Alias: " . $run["oldtag"] . " - " . SITE_NAME;
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
        	<?php echo $thing ?> <?php echo $run["oldtag"] ?>
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <div id="edit">
	    <form class="registration" id="edit_form" action="<?php echo BASE_URL; ?>/aliases/edit/commit" method="post">
	                
            
            <div>
                <span class="edit_title">
					Entered Tag   
                </span>
                <span class="edit_form">
                    <input type="text" name="oldtag" id="oldtag" value="<?php echo $run["oldtag"] ?>" style="width:250px;" class="validate['required']" />
                </span>
            </div>
            <div>
                <span class="edit_title">
					Change To
                </span>
                <span class="edit_form">
                   	<input type="text" name="newtag" id="newtag" value="<?php echo $run["newtag"] ?>" style="width:250px;" class="validate['required']" />
                </span>
            </div>
			<div>
                <span class="edit_title">
					Reason
                </span>
                <span class="edit_form">
                   	<input type="text" name="reason" id="reason" value="<?php echo $run["reason"] ?>" style="width:250px;" class="validate['required']" />
                </span>
            </div>
            <div>
                <span class="edit_title">
                    &nbsp;
                </span>
                <span class="edit_form">
                	<input type="hidden" name="alias_id" value="<?php echo isset($_GET['alias']) ? abs($_GET['alias']) : ''; ?>" />
                    <input type="submit" name="submit" value="<?php echo $thing ?>" />
					<?php
						if(isadmin($_COOKIE['user_id']) && isset($run['id']))
						{
							echo '<span class="small"><a href="' . BASE_URL . '/admin/delete/alias/' . $run['id'] . '">Delete Alias</a></span>';
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