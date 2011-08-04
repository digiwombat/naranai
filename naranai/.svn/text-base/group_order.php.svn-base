<?php
	require_once('hibbity/dbinfo.php');
	
	$group      = isset($_GET['group']) ? abs($_GET["group"]) : '';
	if( empty($group) || USER_LEVEL < GROUP_EDIT ) {
		header("Location: " . BASE_URL . "/group/list");
		exit();
	}

	$page_type  = "groups";
	$pagenum    = 0;
	
	$search_tag = "";
	$title      = "all posts";
	$pagenum    = isset($_GET["pagenum"]) ? abs($_GET["pagenum"] - 1) : 0;
	$limit      = $pics * $pagenum;
	$id['id']   = array();
	$id['hash'] = array();
	$tags       = array();
	$counts     = array();
	$types      = array();
	
	$head      = array
			(
				'js_out'  => '
							window.addEvent(\'domready\', function(){
								base_url = \'' . BASE_URL . '\';
								sorter = new Sortables($(\'list\'));
								$(\'formsender\').addEvent(\'click\', function(e) {
									order = sorter.serialize();
									var saver = new Request.HTML({
										url: base_url + \'/group/order/commit\',
										method: \'post\',
										onSuccess: function(e)
										{
											sorter.detach();
											$(\'formsender\').removeEvents();
											$(\'sendwrap\').innerHTML = \'<h1> Order Updated! <a href="\' + base_url + \'/group/view/' . $group . '">View Group &raquo;</a></h1>\'
										}
									});
									saver.send(\'order=\' + order + \'&group_id=' . $group . '\');
								});
							});'
			);
	
	$sql = "SELECT i.id, i.hash FROM `images` i LEFT OUTER JOIN `image_groups` g ON i.id = g.image_id WHERE group_id = " . $group . " GROUP BY i.id ORDER BY g.image_order, i.id";
  	$get = mysql_query($sql);
	
	while( $run = mysql_fetch_assoc($get) )
	{
		$id['id'][] .= $run['id'];
		$id['hash'][] .= $run['hash'];
	}
	
	$sql   = "SELECT group_name FROM groups WHERE id = " . $group . " LIMIT 1";
	$title = mysql_result(mysql_query($sql), 0);
	$page_title = "Viewing Group: " . $title . " - " . SITE_NAME;


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
        	Setting Order For Group: <?php echo $title ?>
        </div>
        <div id="alert">
    		<?php  ?>
	    </div>
        <div class="spacer"></div>
		<div id="list">
    		<?php
				$size       = sizeof($id['id']);
				for($i = 0; $i < $size; ++$i)
				{	
					$imgtags = $id['tags'][$i];
					$class = ' class="smallpic"';
					echo '
				<div id="' . $id['id'][$i] . '" class="list_image" style="width:75px;height:100px;">
					<img src="' , BASE_URL , '/thumbs/' , $id['hash'][$i] , '.jpg" alt="" title=""' , $class , ' />
				</div>';
				}
			?>
		</div>
<div style="clear:both;"></div>		
		<div id="sendwrap">
		<div id="formsender">
		        	<h1>Update Group Order</h1>
		</div> 
		</div>
</div>
<?php
	require_once("footer.php");
?>