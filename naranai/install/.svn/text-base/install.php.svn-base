<?php
require_once('../hibbity/dbinfo.php');


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="IE=8" http-equiv="X-UA-Compatible">
	<title>Installer</title>
	
	<script type="text/javascript" src="<?php echo BASE_URL ?>/lib/mootools.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL ?>/lib/mootoolsmore.js"></script>
	
	<script type="text/javascript">
		window.addEvent('domready', function() {
			$('install_button').addEvent('click', function(event)
			{
				var db = new Request({
										method: 'get', 
										url: '<?php echo BASE_URL ?>/install/stuff/installer.php', 
										onSuccess: function(response, crap)
													{
														$('db').innerHTML = response; 
														colors.send('do=colors');
													}
									});
				var settings = new Request({
										method: 'get', 
										url: '<?php echo BASE_URL ?>/install/stuff/installer.php', 
										onSuccess: function(response, crap)
													{
														$('settings').innerHTML = response;
														user.send('do=user&user=' + $('user').value + '&pass=' + $('pass').value); 
													}
									});
				var user = new Request({
										method: 'get', 
										url: '<?php echo BASE_URL ?>/install/stuff/installer.php', 
										onSuccess: function(response, crap)
													{
														$('main_area').innerHTML = '<h1>INSTALLED! Please remove install folder.';
													}
									});
				var colors = new Request({
										method: 'get', 
										url: '<?php echo BASE_URL ?>/install/stuff/installer.php', 
										onSuccess: function(response, crap)
													{
														$('colors').innerHTML = response;
														settings.send('do=settings');
													}
									});
				
				db.send('do=db');
			});

		});
	</script>
	<style type="text/css">
		@import url('<?php echo BASE_URL ?>/styles/main/style.css');
		@import url('<?php echo BASE_URL ?>/styles/main/autocompleter.css');
	</style>
	<style type="text/css">
	<!--[if lt IE 8]>
	.list_image {
		display: inline;
	}
	<![endif]-->
	</style>
</head>
<body>
	<div id="header">
	
    <div id="site_name">
    	naranai   </div>

    <div id="main_menu">
    	<span class="active">
        	<a href="<?php echo BASE_URL ?>/post/list" tooltip="linkalert-tip">
            	Installer
			</a>
        </span>
	</div>

    <div id="sub_menu">
    	<div class="left">
			
		</div>
        
        <span class="floatfix">
        </span>
        
    </div>
    

	</div>
	
	 <br /> <br />
	<div style="margin-left: 100px;" id="main_area">
		Admin User: <input type="text" id="user" /> <span class="small">Must be between 2 and 16 characters.</span><br />
		Admin Pass: <input type="password" id="pass" /> <span class="small">Must be at least 6 characters.</span><br /><br />
		<button id="install_button">Install naranai</button> <br />
		 <br />
		Installing DB..... <span style="color:green;" id="db"></span> <br />
		Installing Settings..... <span style="color:green;" id="settings"></span> <br />
		Adding God User..... <span style="color:green;" id="user"></span> <br />
		Installing Colors..... <span style="color:green;" id="colors"></span> <br />
		
	</div>
	 <br /> <br />
<?php
require_once('../footer.php');
?>