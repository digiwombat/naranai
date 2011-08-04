<?php
require_once('../hibbity/config.php');
$cache_age = 900;
if(!isset($_GET['page']))
{
	$page = 1;
}
else
{
	$page = $_GET['page'];
}
$start = ($page-1)*25;
if(isset($_GET['tags']))
{
	$cache = md5('piclens' . $_GET['tags'] . $page);
}
else
{
	$cache = md5('piclensnone' . $page);
}

$cache_file = SITE_DIR . '/feed_cache/' . $cache;

if (file_exists($cache_file) && (time() - $cache_age < filemtime($cache_file)))
{
	header("Content-type: text/xml");
	@readfile($cache_file);
	exit();
 
}
else
{
	require_once('../hibbity/dbinfo.php');
	$sql = "SELECT id, posted, hash, ext FROM images ORDER BY id DESC LIMIT " . $start . ", 25";
	$title = "All Images";
	if(isset($_GET['tags']))
	{	
		$title = "Images tagged: " . $_GET['tags'];
		$tags = "'";
		$tags .= mysql_real_escape_string($_GET['tags']) . "'";
		$tags = str_replace(' ', "','", $tags);
		
		
		$sql = "SELECT i.id, i.posted, i.hash, i.ext FROM images i LEFT OUTER JOIN image_tags c ON i.id = c.image_id LEFT OUTER JOIN tags t ON c.tag_id = t.id WHERE tag IN (" . $tags . ") ORDER BY i.id DESC LIMIT " . $start . ", 25";
	}
	$query = mysql_query($sql) or die(mysql_error());
	header("Content-type: text/xml");

	$feed = "<rss version=\"2.0\"
             xmlns:media=\"http://search.yahoo.com/mrss/\"
             xmlns:atom=\"http://www.w3.org/2005/Atom\">
	<channel>
	<title>" . SITE_NAME . " - " . $title . "</title>
	<link>" . BASE_URL . "</link>
	<description>With naranai, nothing is possible! Updated every 15 minutes.</description>
	<language>en-us</language>
	<lastBuildDate>" . date("D, d M Y h:i:s") . " PST</lastBuildDate>
	<atom:link href=\"" . BASE_URL . "/cooliris\" rel=\"self\" type=\"application/rss+xml\" />
	";
	if(isset($tags))
	{
		$tags = $_GET['tags'] . '/';
	}
	if($page > 1)
    {
		$feed .='<atom:link rel="previous" href="' . BASE_URL .  '/cooliris/' . $tags . 'page/' . ($page-1) . '" />';
    }
	
    $feed .='<atom:link rel="next" href="' . BASE_URL .  '/cooliris/' . $tags . 'page/' . ($page+1) . '" />';

	while($row = mysql_fetch_array($query))
	{
		$title 			= 'Image (' . $row['id'] . ') Posted At [' . $row['posted'] . ']';
		$link 			= BASE_URL . '/post/view/' . $row['id'];


		$feed .= '<item>
		  <title>' . $title . '</title>
		  <link>' . $link . '</link>
		  <media:thumbnail url="' . BASE_URL . '/thumbs/' . $row['hash'] . '.jpg" />
		  <media:content url="' . BASE_URL . '/images/' . $row['hash'] . '.' . $row['ext'] . '" />
		  <guid isPermaLink="false">'. $row['id'] .'</guid>
		</item>';
	}
	$feed .= "</channel></rss>";
	echo $feed;
	file_put_contents($cache_file, $feed);
}
?>