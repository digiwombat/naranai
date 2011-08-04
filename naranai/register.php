<?php

	require_once('hibbity/dbinfo.php');
	
	if($_COOKIE["user_id"])
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	
	switch($_GET["err"])
	{
		case 412:
			$err = 'Passwords or emails don\'t match.';
			$show = ' style="display:block;"';
			break;
		case 415:
			$err = 'Some field was missing. All fields required.';
			$show = ' style="display:block;"';
			break;
		case 422:
			$err = 'A user with that username or email exists.';
			$show = ' style="display:block;"';
			break;
	}
	
	$page_type = "post";
	$head      = array
			(
				'js_load' => '/lib/formcheck.js',
				'js_out'  => '
	window.addEvent(\'domready\', function(){
		new FormCheck(\'registration_form\');
	});',
				'css_load' => '/styles/' . STYLE_DIR . '/formcheck.css'
			);
	$page_title = "Registration - " . SITE_NAME;
	
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
        	User Registration
        </div>
		<div id="alert"<?php echo $show; ?>>
    		<?php echo $err; ?>
	    </div>
        <div class="spacer"></div>
        
        <form class="registration" id="registration_form" method="post" action="<?php echo BASE_URL; ?>/registration">
            <fieldset>
                <legend>User Information</legend>
                <label>
                    <span>Desired username : </span>
                    <input class="validate['required','length[4,16]','alphanum'] text-input" type="text" name="username"/>
                </label>
                <label>
                    <span>Email address : </span>
                    <input class="validate['required','email'] text-input" type="text" name="email"/>
                </label>
                <label>
                    <span>Confirm email address : </span>
                    <input class="validate['confirm[email]'] text-input" type="text" name="email2"/>
                </label>
            </fieldset>
            <fieldset>
                <legend>Password</legend>
                <label>
                    <span>Password : </span>
                    <input class="validate['required','length[6,-1]'] text-input" type="password" name="password"/>
                </label>
                <label>
                    <span>Confirm password : </span>
                    <input class="validate['confirm[password]'] text-input" type="password" name="password2"/>
                </label>
            </fieldset>
            <fieldset>
                <legend>Conditions</legend>
                <div class="infos">Checking this box indicates that you accept liability for any postings you make and that you understand that illegal content will be removed and your information will be turned over to the authorities. If you do not accept these terms, do not use this website. </div>
                <label>
					<input class="validate['required'] checkbox" type="checkbox" name="agree" value="true" />
                    <span class="checkbox">I accept terms of use.</span>
                </label>
                <br /><br />
                <label>
		            <input type="submit" value="Sign Up"/>
                </label>

            </fieldset>
 
        </form>

    </div>    
    
</div>
<?php
	require_once("footer.php");
?>