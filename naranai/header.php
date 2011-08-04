<?php
	
	if(isset($_COOKIE['user_id']))
	{
		$fav = '/post/list/fav:' . $_COOKIE['user_id'];
	}
	$upload = '/post/upload';
	
	$post_menu =	array
					(
						'List' 	 		=> '/post/list',
						'Favourites'	=> $fav,
						'Upload'		=> $upload,
						'Help'			=> '#'
					);
	$forum_menu =	array
					(
						'List' 	 		=> '/forum/list',
						'New Topic'		=> '/forum/new',
						'Help'			=> '#'
					);
	if(!isset($_COOKIE['user_id']) && ANON_UPLOADS == 0)
	{
		unset($post_menu['Upload']);
	}
	if(!isset($_COOKIE['user_id']))
	{
		unset($post_menu['Favourites']);
	}
	$comments_menu = array
					(
						'List'          => '/comment/list'
					);
	$tags_menu =	array
					(
					 	'Tags'	 	 		=> '/tags/list',
						'Add Tag'			=> '/tags/add',
						'spacer_1'			=> 'spacer',
						'Aliases' 	 		=> '/aliases/list',
						'Add Alias'			=> '/aliases/add',
						'spacer_2'			=> 'spacer',
						'Implications' 		=> '/implications/list',
						'Add Implication'	=> '/implications/add'
					);
	$groups_menu =	array
					(
						'List' 	 		=> '/group/list',
						'Add'			=> '/group/add'
					);
	$account_menu =	array
					(
						'Profile' 	 		=> '/user/profile/' . $_COOKIE['user_id'],
						'Change Password'	=> '/user/change/pass'
					);
	$group_view	 =	array
					(
						'spacer_1'					=> 'spacer',
						'View' 						=> '/group/view/' . $group,
						'Edit' 						=> '/group/edit/' . $group,
						'Order'						=> '/group/order/' . $group
					);
	$admin_menu =	array
					(
						'spacer_1'					=> 'spacer',
						'Fix Tag Counts' 			=> '/admin/count',
						'Remove Untagged Images'	=> '/admin/untagged',
						'Remove Spam Users'			=> '/admin/users/spam',
						'User Management'			=> '/admin/users',
						'naranai Settings' 			=> '/admin/settings'
					);
					
	$search_box = '<div id="search">
						<div class="block_title">
							Search
						</div>
						<div class="block_content">
							<form method="post" action="' . BASE_URL . '/search">
							<input type="text" name="q" id="searchbox" value="' . $_GET['q'] . '" />
							</form>
						</div>
					</div>';

	$post_active = $comments_active = $tags_active = $account_active = $groups_active = $post = '';
	switch($page_type)
	{
		case "post":
			$menu = $post_menu;
			$post_active = ' class="active"';
			break;
		case "comments":
			$menu = $comments_menu;
			$comments_active = ' class="active"';
			break;
		case "tags":
			$menu = $tags_menu;
			$tags_active = ' class="active"';
			break;
		case "forum":
			$menu = $forum_menu;
			$forum_active = ' class="active"';
			break;
		case "account":
			$menu = $account_menu;
			if(USER_LEVEL >= '10')
			{
				$menu = array_merge($menu, $admin_menu);
			}
			$account_active = ' class="active"';
			break;
		case "groups":
			$menu = $groups_menu;
			if(isset($group) && USER_LEVEL >= GROUP_EDIT)
			{
				$menu = array_merge($menu, $group_view);
			}
			$groups_active = ' class="active"';
			break;
		default:
			$menu = $post_menu;
			$post = ' class="active"';
			break;
	}

	if($page_title == "")
	{
		$page_title = SITE_NAME;	
	}

include_once('tag_search.php');

// Load the JS
if( !is_array($head))
{
	$header_crap = $head;
	unset($head);
}
if( !isset($head['js_load']) ) $head['js_load'] = array(); else $head['js_load'] = (array)$head['js_load'];
array_unshift($head['js_load'],	'/lib/mootools.js',
								'/lib/mootoolsmore.js',
								'/lib/observer.js',
								'/lib/autocompleter.js',
								'/lib/autocompleter.local.js');

$head['js_out'] =  "
	window.addEvent('domready', function() {
		tags = " . $tag_search . ";
		new Autocompleter.Local('searchbox', tags, {
				'minLength': 1, // We need at least 1 character
				'selectMode': 'true', // Instant completion
				'separator': ' ', // NOT DEFAULT NO MORE BITCHES.
				'multiple': true // Tag support, by default comma separated
		});		 
	});" . (isset($head['js_out']) ? $head['js_out'] : '' );

// Load the CSS
if( !isset($head['css_load']) ) $head['css_load'] = array(); else $head['css_load'] = (array)$head['css_load'];
array_unshift($head['css_load'], '/styles/' . STYLE_DIR . '/style.css', '/styles/' . STYLE_DIR . '/autocompleter.css');
$head['css_out']    =  '
	<!--[if lt IE 8]>
	.list_image {
		display: inline;
	}
	<![endif]-->' . (isset($head['css_out']) ? $head['css_out'] : '' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<title><?php echo $page_title; ?></title>
	
<?php
	if( isset($head['generic_out']) ) 
	{
		echo $head['generic_out'];
	}
	echo $header_crap;

	$tab  = "\n	";
	$tab2 = $tab . '	';

	# Start with the JS
	echo $tab . '<script src="' , BASE_URL , implode('" type="text/javascript"></script>' . $tab . '<script src="' . BASE_URL, $head['js_load']) , '" type="text/javascript"></script>';
	
	if( isset($head['js_var']) ) {
		echo $tab , '<script type="text/javascript">';
		foreach($head['js_var'] as $var => $value) {
			echo $tab2 , 'var ' , $var , ' = ' , is_numeric($value) ? $value : "'" . $value . "'" , ';';
		}
		echo $tab , '</script>';
	}

	echo $tab , '<script type="text/javascript">';
	echo $head['js_out'];
	echo $tab , '</script>';

	# Finally, do the CSS
	echo $tab, '<style type="text/css">';
	echo $tab2, "@import url('", BASE_URL , implode("');" . $tab2 . "@import url('" . BASE_URL, $head['css_load']) , "');";
	echo $tab, '</style>';

	echo $tab , '<style type="text/css">';
	echo $head['css_out'];
	echo $tab , '</style>';

	$head = null;
?>

</head>

<body>

<div id="header">
	
    <div id="site_name">
    	<?php echo SITE_NAME; ?>
    </div>

    <div id="main_menu">
    	<span<?php echo $post_active; ?>>
        	<a href="<?php echo BASE_URL; ?>/post/list">
            	Posts
			</a>
        </span>
		<span<?php echo $comments_active; ?>>
			<a href="<?php echo BASE_URL; ?>/comment/list">
				Comments
			</a>
		</span>
		<?php
		if(USER_LEVEL >= TAG_EDIT)
		{
		?>
        <span<?php echo $tags_active; ?>>
        	<a href="<?php echo BASE_URL; ?>/tags/list">
            	Tags
			</a>
        </span>
		<?php
		}
		?>
        <span<?php echo $groups_active; ?>>
        	<a href="<?php echo BASE_URL; ?>/group/list">
            	Groups
			</a>
        </span>
		<?php
		if(USER_LEVEL >= FORUM_VIEW)
		{
		?>
        <span<?php echo $forum_active; ?>>
        	<a href="<?php echo BASE_URL; ?>/forum/list">
            	Forum
			</a>
        </span>
		<?php
		}
		?>
		<?php
		if(isset($_COOKIE['user_id']))
		{
		?>
        <span<?php echo $account_active; ?>>
		<?php # /account ?>
        	<a href="<?php echo BASE_URL; ?>/user/profile/<?php echo $_COOKIE['user_id']; ?>">
            	Account
			</a>
        </span>
		<?php
		}
		?>
    </div>

    <div id="sub_menu">
    	<div class="left">
    	<?php
			foreach($menu as $name => $link)
			{
				if($link != 'spacer')
				{
					echo '	<span>
				        	<a href="', BASE_URL, $link , '">
            					' , $name , '
							</a>
				        </span>';
				}
				else
				{
					echo '<span><a style="cursor:default;">|</a></span>';
				}
			}
			
		?>
        </div>
        
		<div id="log_menu" class="right">
            <?php
			if( isset($_COOKIE["user_name"]) )
			{
			?>
            <span>
            	<span>
	            	Hello, <?php echo $_COOKIE["user_name"]; ?>.
                </span>
            </span>
			<span>
                <a href="<?php echo BASE_URL; ?>/logout">
                    Logout
                </a>
            </span>
            <?php
			}
			else
			{
			?>
            <span id="login">
                <a href="<?php echo BASE_URL; ?>/login">
                    Login
                </a>
            </span>
            <span id="register">
                <a href="<?php echo BASE_URL; ?>/register">
                    Register
                </a>
            </span>
            <?php
			}
			?>
        </div>
        
        <span class="floatfix">
        </span>
        
    </div>
    

</div>