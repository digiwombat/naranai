<?php

function fuzzy_time( $time ) {

	if ( ( $time = strtotime( $time ) ) == false ) {
		return 'an unknown time';
	}
	define( 'NOW',        time() );
	define( 'ONE_MINUTE', 60 );
	define( 'ONE_HOUR',   3600 );
	define( 'ONE_DAY',    86400 );
	define( 'ONE_WEEK',   ONE_DAY*7 );
	define( 'ONE_MONTH',  ONE_WEEK*4 );
	define( 'ONE_YEAR',   ONE_MONTH*12 );
 
  // sod = start of day :)
  $sod = mktime( 0, 0, 0, date( 'm', $time ), date( 'd', $time ), date( 'Y', $time ) );
  $sod_now = mktime( 0, 0, 0, date( 'm', NOW ), date( 'd', NOW ), date( 'Y', NOW ) );
 
  // used to convert numbers to strings
  $convert = array( 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven' );
 
  // today
  if ( $sod_now == $sod ) {
    if ( $time > NOW-(ONE_MINUTE*3) ) {
      return 'just a moment ago';
    } else if ( $time > NOW-(ONE_MINUTE*7) ) {
      return 'a few minutes ago';
	} else if ( $time > NOW-(ONE_MINUTE*30) ) {
      return 'less than a half hour ago';
    } else if ( $time > NOW-(ONE_HOUR) ) {
      return 'less than an hour ago';
    }
    return 'today at ' . date( 'g:ia', $time );
  }
 
  // yesterday
  if ( ($sod_now-$sod) <= ONE_DAY ) {
    if ( date( 'i', $time ) > (ONE_MINUTE+30) ) {
      $time += ONE_HOUR/2;
    }
    return 'yesterday around ' . date( 'ga', $time );
  }
 
  // within the last 5 days
  if ( ($sod_now-$sod) <= (ONE_DAY*5) ) {
    $str = date( 'l', $time );
    $hour = date( 'G', $time );
    if ( $hour < 12 ) {
      $str .= ' morning';
    } else if ( $hour < 17 ) {
      $str .= ' afternoon';
    } else if ( $hour < 20 ) {
      $str .= ' evening';
    } else {
      $str .= ' night';
    }
    return strtolower($str);
  }
 
  // number of weeks (between 1 and 3)...
  if ( ($sod_now-$sod) < (ONE_WEEK*3.5) ) {
    if ( ($sod_now-$sod) < (ONE_WEEK*1.5) ) {
      return 'about a week ago';
    } else if ( ($sod_now-$sod) < (ONE_DAY*2.5) ) {
      return 'about two weeks ago';
    } else {
      return 'about three weeks ago';
    }
  }
 
  // number of months (between 1 and 11)...
  if ( ($sod_now-$sod) < (ONE_MONTH*11.5) ) {
    for ( $i = (ONE_WEEK*3.5), $m=0; $i < ONE_YEAR; $i += ONE_MONTH, $m++ ) {
      if ( ($sod_now-$sod) <= $i ) {
        return 'about ' . $convert[$m] . ' month' . (($m>1)?'s':'') . ' ago';
      }
    }
  }
 
  // number of years...
  for ( $i = (ONE_MONTH*11.5), $y=0; $i < (ONE_YEAR*10); $i += ONE_YEAR, $y++ ) {
    if ( ($sod_now-$sod) <= $i ) {
      return 'about ' . $convert[$y] . ' year' . (($y>1)?'s':'') . ' ago';
    }
  }
 
  // more than ten years...
  return 'more than ten years ago';
}

function isadmin()
{
	if( defined('ISADMIN') ) return ISADMIN;
	if( isset($_COOKIE['user_id']) && isset($_COOKIE['password']))
	{
		$id = abs($_COOKIE['user_id']);
		$pass = mysql_real_escape_string($_COOKIE['password']);	
	}
	else
	{
		return false;
	}
	$sql = "SELECT user_level  FROM `users` WHERE `id` = " . $id . " AND pass = '" . $pass . "';";
	define('ISADMIN', mysql_result(mysql_query($sql), 0) >= '10' ? true : false);
	return ISADMIN;
}

function isuser()
{
	if( defined('ISUSER') ) return ISUSER;
	if( isset($_COOKIE['user_id']) && isset($_COOKIE['password']) )
	{
		$id = abs($_COOKIE['user_id']);
		$pass = mysql_real_escape_string($_COOKIE['password']);
	}
	else
	{
		return false;
	}
	$sql = "SELECT user_level  FROM `users` WHERE `id` = " . $id . " AND pass = '" . $pass . "';";
	define('ISUSER', mysql_result(mysql_query($sql), 0) >= '1' ? true : false);
	return ISUSER;
}

function isowner()
{
	if( defined('ISOWNER') ) return ISOWNER;
	if( isset($_COOKIE['user_id']) && isset($_COOKIE['password']) )
	{
		$id = abs($_COOKIE['user_id']);
		$pass = mysql_real_escape_string($_COOKIE['password']);
	}
	else
	{
		return false;
	}
	$sql = "SELECT user_level  FROM `users` WHERE `id` = " . $id . " AND pass = '" . $pass . "';";
	define('ISOWNER', mysql_result(mysql_query($sql), 0) == '11' ? true : false);
	return ISOWNER;
}

function isapproved()
{
	if( defined('ISAPPROVED') ) return ISADMIN;
	if( isset($_COOKIE['user_id']) )
		$id = abs($_COOKIE['user_id']);
	else
		return false;
	$sql = "SELECT `approved`  FROM `users` WHERE `id` = " . $id;
	define('ISAPPROVED', mysql_result(mysql_query($sql), 0) == '1' ? true : false);
	return ISAPPROVED;
}

function iscolor($search)
{
	$search = strtolower($search);
	$colors = array("red","orange","yellow","green","blue","violet","brown","black","grey","white");
	$check	= in_array($search, $colors);
	if(!$check)
	{
		return false;
	}
	return true;
}

function get_option($option_name)
{
	$sql = "SELECT value FROM `config` WHERE `name` = '" . $option_name . "'";
	$value = @mysql_result(mysql_query($sql), 0);
	return $value;
}

function forum_time($user_id, $set = 0)
{
	if($set == 0)
	{
		$sql = "SELECT forums FROM `users` WHERE `id` = '" . $user_id . "'";
		$value = @mysql_result(mysql_query($sql), 0);
		return $value;
	}
	else
	{
		$sql = "UPDATE `users` SET forums = NOW() WHERE id = " . $user_id . " LIMIT 1";
		mysql_query($sql);
	}
}

function mysql_found_rows()
{
	return mysql_result(mysql_query("SELECT FOUND_ROWS()"), 0);
}

function schmancy($post, $type = 'forum', $reverse = 0)
{
	$forum_bbcode = array(
					'[b]', 
					'[/b]', 
					'[i]',
					'[/i]',
					'[quote]',
					'[/quote]',
					'[spoiler]',
					'[/spoiler]',
					'[ul]',
					'[/ul]',
					'[ol]',
					'[/ol]',
					'[li]',
					'[/li]',
					'[tn]',
					'[/tn]'
				);
	$forum_html   = array('<strong>', 
					'</strong>', 
					'<em>',
					'</em>',
					'<blockquote>',
					'</blockquote>',
					'<span class="spoiler">',
					'</span>',
					'<ul>',
					'</ul>',
					'<ol>',
					'</ol>',
					'<li>',
					'</li>',
					'<div class="translation_note">',
					'</div>'
				);
	$comment_bbcode = array(
					'[b]', 
					'[/b]', 
					'[i]',
					'[/i]',
					'[quote]',
					'[/quote]',
					'[spoiler]',
					'[/spoiler]'
				);
	$comment_html   = array('<strong>', 
					'</strong>', 
					'<em>',
					'</em>',
					'<blockquote>',
					'</blockquote>',
					'<span class="spoiler">',
					'</span>'
				);
	$tn_bbcode = array(
					'[b]', 
					'[/b]', 
					'[i]',
					'[/i]',
					'[tn]',
					'[/tn]'
				);
	$tn_html   = array('<strong>', 
					'</strong>', 
					'<em>',
					'</em>',
					'<div class="translation_note">',
					'</div>'
				);
					
$patterns[0] = '/\[post\](\d*)\[\/post\]/';
$replacements[0] = '<a href="' . BASE_URL . '/post/view/$1">post #$1</a>';
$patterns[1] = '/\[forum\](\d*)\[\/forum\]/';
$replacements[1] = '<a href="' . BASE_URL . '/forum/view/$1">forum #$1</a>';
$patterns[2] = '/\[group\](\d*)\[\/group\]/';
$replacements[2] = '<a href="' . BASE_URL . '/group/view/$1">group #$1</a>';
$patterns[3] = '/\[link=([^\]]+)\](.+)\[\/link\]/';
$replacements[3] = '<a href="$1">$2</a>';

if($reverse == 0)
{
	if($type == 'forum')
	{
		$post = str_replace($forum_bbcode, $forum_html, $post);
		$post = preg_replace($patterns, $replacements, $post);
	}
	if($type == 'comment')
	{
		$post = str_replace($comment_bbcode, $comment_html, $post);
		$post = preg_replace($patterns, $replacements, $post);
	}
	if($type == 'tn')
	{
		$post = str_replace($tn_bbcode, $tn_html, $post);
	}
	
}
else
{
	$post = str_replace($html, $bbcode, $post);
}

return $post;
}

function clean_tags($string)
{
	// Replace other special chars
	$chars = array(
					'#',
					'$',
					'%',
					'&',
					'@',
					'.',
					'?',
					'+',
					'=',
					'\\',
					'/',
					',',
					'"',
					"\n",
					"\r"
				);

	$reps = array(
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'-',
					'-',
					'',
					'',
					''
				);
				
				
	$string = str_replace($chars, $reps, $string);

	// Remove all remaining other unknown characters
		$string = preg_replace('/[-]{2,}/', ' ', $string);

	return $string;
}

?>