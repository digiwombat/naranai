<?php
	require_once('hibbity/dbinfo.php');
	
	if((!isset($_COOKIE['user_id']) && ANON_UPLOADS == 0) || USER_LEVEL < UPLOAD)
	{
		header('Location: ' . BASE_URL . '/post/list');
		exit();
	}
	if( !isset($_COOKIE["user_id"]) ) {
		$sql      = "SELECT COUNT(*) as uploads FROM `images` WHERE `posted` >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) AND `owner_ip` = '" . $_SERVER['REMOTE_ADDR'] . "'";
		$uploaded = intval(mysql_result(mysql_query($sql), 0));
		$sep      = "&";
	} else {
		$uploaded = 0;
		$sep      = "?";
	}

	$page_type = "post";

	$head =	array
		(
			'js_load' =>	array
							(
								'/lib/Swiff.Uploader.js',
								'/lib/Fx.ProgressBar.js',
								'/lib/FancyUpload2.js',
								'/lib/moocombo.js'
							),
			'js_out' =>	"
	window.addEvent('domready', function() {
		$('upload_status').hide();
		var swiffy = new FancyUpload2($('upload_status'), $('file_list'), {
			url: $('upload_form').action,
			fieldName: 'photoupload',
			path: '" . BASE_URL . "/lib/Swiff.Uploader.swf',
			limitSize: 2 * 1024 * 1024,
			limitFiles: " . MAX_UPLOADS . ",
			onLoad: function() {
				$('upload_status').show();
				$('form_fallback').destroy();
			},
			onFileSuccess: function(file, response) {
				var json = new Hash(JSON.decode(response, true) || {});
	 
				if (json.get('status') == '1') {
					file.element.addClass('file-success');
					file.info.set('html', '<strong>Image was uploaded:</strong> ' + json.get('width') + ' x ' + json.get('height') + 'px, <em>' + json.get('mime') + '</em>)');
				} else {
					file.element.addClass('file-failed');
					file.info.set('html', '<strong>An error occured:</strong> ' + (json.get('error') ? (json.get('error') + ' #' + json.get('code')) : response));
				}
			},
			onComplete: function() {
				$('progress_holder').innerHTML = '<h1>All Uploads Complete.</h1><br /><a href=\"" . BASE_URL . "/post/upload/tag\" style=\"font-size:20px;font-weight:bold;\">Tag Uploads &raquo;</a>';
			},
			onFail: function(error) {
				switch (error) {
					case 'hidden': // works after enabling the movie and clicking refresh
						alert('To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).');
						break;
					case 'blocked': // This no *full* fail, it works after the user clicks the button
						alert('To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).');
						break;
					case 'empty': // Oh oh, wrong path
						alert('A required file was not found, please be patient and we fix this.');
						break;
					case 'flash': // no flash 9+ :(
						alert('To enable the embedded uploader, install the latest Adobe Flash plugin.')
				}
			},
			// The changed parts!
			verbose: true, // enable logs, uses console.log
			target: 'file_browse' // the element for the overlay (Flash 10 only)
		});
		
		swiffy.options.typeFilter = {'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'};

		
		$('file_browse').addEvent('click', function() {	
			swiffy.browse();
			return false;
		});
	 
	 
		$('file_clear').addEvent('click', function() {
			swiffy.removeFile();
			return false;
		});
	 
		$('file_upload').addEvent('click', function() {
			swiffy.setOptions({url: $('upload_form').action + '/' + encodeURIComponent($('group_field').value)});
			swiffy.upload();
			return false;
		});
	});",

			'css_load' =>	array
							(
								'/styles/' . STYLE_DIR . '/formcheck.css',
								'/styles/' . STYLE_DIR . '/upload.css'
							)
		);

	$page_title = "Image Upload - " . SITE_NAME;

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
        	Image Upload
        </div>
        <div id="alert">
    		
	    </div>
        <div class="spacer"></div>
    	
        <?php
			if(isset($_COOKIE["user_id"]) || $uploaded < ANON_UPLOADS )
			{
		?>
	    <form enctype="multipart/form-data" class="registration" id="upload_form" action="<?php echo BASE_URL; ?>/uploader/<?php echo $_COOKIE["user_id"] ?>/<?php echo $_COOKIE["password"] ?>" method="post">
	    
        <h4>Posting Guidelines</h4>
        
        <ul>
        	<li>
            	Try not to upload shitty pictures.
            </li>
            <li>
            	Nothing illegal. That means no CP.
            </li>
            <li>
            	Please properly tag the stuff you upload. If you don't know anything about the picture, use the tagme tag.
            </li>
            <li>
            	After the images upload, please follow the link to tag images
            </li>
             <li>
            	You can upload <?php echo MAX_UPLOADS ?> images at a time.
            </li>
            <li>
            	Anonymous users can only upload <?php echo ANON_UPLOADS ?> files per day.
            </li>
            <li>
            	<strong>If you don't see the javascript uploader below</strong>, you are a tool who should die and you can only upload one image at a time.
            </li>
		</ul>
            
        <fieldset id="form_fallback">
            <legend>File Upload</legend>
            <p>
                Select a photo to upload.<br />
            </p>
            <label for="photoupload">
                Upload Photos:
                <input type="file" name="photoupload" id="reg_photoupload" />
                <input type="hidden" name="fail" value="true" />
                <input type="hidden" name="group_field" value="" />
                <input type="submit" name="submit" value="Upload" />
            </label>
        </fieldset>
    
        <div id="upload_status">
    
            <div id="progress_holder" class="left">
                <p>
                    <a href="#" id="file_browse">Browse Files</a> |
                    <a href="#" id="file_clear">Clear List</a> |
                    <a href="#" id="file_upload">Upload</a>
                </p>
                <div>
        
                    <strong class="overall-title">Overall progress</strong><br />
                    <img src="<?php echo BASE_URL; ?>/lib/assets/progress-bar/bar.gif" class="progress overall-progress" />
                </div>
                <div>
                    <strong class="current-title">File Progress</strong><br />
                    <img src="<?php echo BASE_URL; ?>/lib/assets/progress-bar/bar.gif" class="progress current-progress" />
                </div>
                <div>
                <strong class="overall-title">Add Uploads to the Following Group</strong><br />
                <span style="position:relative;">
                <select name="group_field" id="group_field" class="combo_box" style="position:relative;top:4px;left:4px;">
                    	<option value="None">None</option>
                    	<?php
							$sql_group = "SELECT id, group_name FROM `groups`";
							$get_group = mysql_query($sql_group);
							
							while($run_group = mysql_fetch_assoc($get_group))
							{
								$select = "";
								if($group_id == $run_group['id'])
								{
									$select = ' selected="selected"';
								}
								if($run_group["group_name"] != "")
								{
						?>
                        	
								<option value="<?php echo $run_group["group_name"]; ?>"<?php echo $select ?>><?php echo $run_group["group_name"]; ?></option>
                            
                        <?php
								}
							}
						?>
                    </select>
                    </span>
                </div>
                <div class="current-text"></div>
    		</div>
			
            <div id="list_holder" class="left">
            	<ul id="file_list"></ul>
            </div>            
            
            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
            
        </form>
        <?php
			}
			else
			{
		?>
        	<div id="upload_alert">
            	<h1>You have reached your upload quota for the day.</h1>
            </div>
        <?php
			}
		?>
    </div>    
    
</div>
<?php
	require_once("footer.php");
?>