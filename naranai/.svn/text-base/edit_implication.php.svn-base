<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < TAG_EDIT ) {
		header("Location: " . BASE_URL . "/implications/list");
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

	$thing = "Add Implication";
	$page_title = "Add Implication - " . SITE_NAME;
	if( isset($_GET["implication"]) )
	{
		$sql = "SELECT id, tag, implies, reason FROM `implications` WHERE `id` = " . abs($_GET["implication"]);
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		$thing = "Edit Implication";
		$page_title = "Edit Implication: " . $run["tag"] . " - " . SITE_NAME;
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
        	<?php echo $thing ?> <?php echo $run["tag"] ?>
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <div id="edit">
	    <form class="registration" id="edit_form" action="<?php echo BASE_URL; ?>/implications/edit/commit" method="post">
	                
            
            <div>
                <span class="edit_title">
					Tag  
                </span>
                <span class="edit_form">
                    <input type="text" name="tag" id="tag" value="<?php echo $run["tag"] ?>" style="width:250px;" class="validate['required']" />
                </span>
            </div>
            <div>
                <span class="edit_title">
					Implies
                </span>
                <span class="edit_form">
                   	<input type="text" name="implies" id="implies" value="<?php echo $run["implies"] ?>" style="width:250px;" class="validate['required']" />
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
                	<input type="hidden" name="implication_id" value="<?php echo isset($_GET['implication']) ? abs($_GET['implication']) : ''; ?>" />
                    <input type="submit" name="submit" value="<?php echo $thing ?>" />
					<?php
						if(isadmin($_COOKIE['user_id']) && isset($run['id']))
						{
							echo '<span class="small"><a href="' . BASE_URL . '/admin/delete/implication/' . $run['id'] . '">Delete Implication</a></span>';
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