<?php
	require_once('config.php');
	require_once(SITE_DIR . '/lib/functions.php');
	mysql_connect("localhost", "root", "root");
	mysql_select_db("naranai");
	
	if(!defined('USER_LEVEL'))
	{
		if(isuser($_COOKIE['user_id']))
		{
			if(isowner($_COOKIE['user_id']))
			{
				define('USER_LEVEL', '11');
			}
			elseif(isadmin($_COOKIE['user_id']))
			{
				define('USER_LEVEL', '10');
			}
			else
			{
				define('USER_LEVEL', '1');
			}
		}
		else
		{
			define('USER_LEVEL', '0');
		}
	}
	if(!defined('IMAGE_EDIT'))
	{
		define('IMAGE_EDIT', get_option('permissions_image_edit'));
	}
	if(!defined('UPLOAD'))
	{
		define('UPLOAD', get_option('permissions_upload'));
	}
	if(!defined('TAG_EDIT'))
	{
		define('TAG_EDIT', get_option('permissions_tag_edit'));
	}
	if(!defined('GROUP_EDIT'))
	{
		define('GROUP_EDIT', get_option('permissions_group_edit'));
	}
	if(!defined('COMMENT_LEVEL'))
	{
		define('COMMENT_LEVEL', get_option('permissions_comments'));
	}
	if(!defined('FORUM_VIEW'))
	{
		define('FORUM_VIEW', get_option('premissions_forum_view'));
	}
	if(!defined('FORUM_POST'))
	{
		define('FORUM_POST', get_option('premissions_forum_add'));
	}
	if(!defined('FORUM_REPLY'))
	{
		define('FORUM_REPLY', get_option('premissions_forum_reply'));
	}
	if(!defined('EDITOR_STYLE'))
	{
		define('EDITOR_STYLE', get_option('tag_editor'));
	}
?>