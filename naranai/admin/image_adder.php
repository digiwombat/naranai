<?php

	require_once("../hibbity/dbinfo.php");
	include_once('../lib/colors.inc.php');
	include_once('../lib/color_to_name.php');
	$urls 	  = $_GET["url"];
	$urls 	  = array_unique($urls);
	$username = "Anonymous";
	if(isset($_GET["user"]))
	{
		$username = urlencode(mysql_real_escape_string(trim($_GET["user"])));
		$username = str_replace("%0320", "", $username);
	}
	
	
	foreach($urls as $url)
	{
		$sql = "select id from images where source = '" . $url . "'";
		$run = mysql_num_rows(mysql_query($sql));
		if($run > 0)
		{
			echo "File exists:" . $url;
		}
		else
		{
			
			$filename = explode("/", $url);
			$filename = array_pop($filename);
			$ext = explode(".", $filename);
			$ext = array_pop($ext);
			
			if($ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "GIF" || $ext == "JPG" || $ext == "JPEG" || $ext == "PNG")
			{
				if(eregi("pixiv.net", $url))
				{
					$refer = "-e 'http://www.pixiv.net/member_illust.php'";	
					$command = "curl " . $refer . " -A 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5' " . $url . " > /tmp/file." . $ext;
					exec($command);	
					$hash = md5_file('/tmp/file.' . $ext);
					unlink('/tmp/file.' . $ext);
				}
				if(!isset($hash))
				{
					$hash = md5_file($url);
				}
				$ab = substr($hash, 0, 2);
				$max_width = '192';
				$thumb_name = SITE_DIR . "/thumbs/" . $ab . "/" . $hash;
				$image_name = SITE_DIR . "/images/" . $ab . "/" . $hash;
				
				if(eregi("pixiv.net", $url))
				{
					$refer = "-e 'http://www.pixiv.net/member_illust.php'";	
				}
				$command = "curl " . $refer . " -A 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5' " . $url . " > " . $image_name;
				exec($command);			
				
				$size = @getimagesize($image_name);

				if($size[0] < 25 || $size[1] < 25)
				{
					unlink($image_name);
					die("File too small: " . $size[0] . "x" . $size[1]);
				}
				
				$current_img_width  = $size[0];
				$current_img_height = $size[1];
				
				$too_big_diff_ratio = $current_img_width/$max_width;
				$new_img_width = $max_width;
				$new_img_height = round($current_img_height/$too_big_diff_ratio);
				if($new_img_height > $max_width)
				{
					$too_big_diff_ratio = $current_img_height/$max_width;
					$new_img_height = $max_width;
					$new_img_width = round($current_img_width/$too_big_diff_ratio);
				}
				
				$thumb = imagecreatetruecolor($new_img_width, $new_img_height) or die("Bad dimensions.");
				switch($ext)
				{
					case 'jpg':
						$source = imagecreatefromjpeg($image_name) or die("Bad file.");
						break;
					case 'jpeg':
						$source = imagecreatefromjpeg($image_name) or die("Bad file.");
						break;
					case 'gif':
						$source = imagecreatefromgif($image_name) or die("Bad file.");
						break;
					case 'png':
						$source = imagecreatefrompng($image_name) or die("Bad file.");
						break;
					case 'GIF':
						$source = imagecreatefromgif($image_name) or die("Bad file.");
						break;
					case 'PNG':
						$source = imagecreatefrompng($image_name) or die("Bad file.");
						break;
					default:
						$source = imagecreatefromjpeg($image_name) or die("Bad file.");
						break;
				}
				
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_img_width, $new_img_height, $current_img_width, $current_img_height) or die("Bad reample?.");
				imagejpeg($thumb, $thumb_name, 90) or die("Create thumb file failed.");
				
				$ex=new GetMostCommonColors();
			$ex->image=$thumb;	
			$colors=$ex->Get_Color();
			$how_many=2; // zero based.
			$colors_key=array_keys($colors);
			$color_names = array();
			$color_names = file('../lib/color_names.json');
			for ($i = 0; $i <= 2; $i++)
			{
				$color_name_array[] = color_to_name($colors_key[$i]);
				
			}
			unset($names);
			$color_set   = array();
			$primary = trim($color_name_array[0]);
			$secondary = trim($color_name_array[1]);
			$tertiary = trim($color_name_array[2]);
			$sqlhue = "SELECT `hue`, FIND_IN_SET(`hexadecimal`, '" . $primary . "," . $secondary . "," . $tertiary . "') FROM `colors` WHERE `hexadecimal` IN ('" . $primary . "', '" . $secondary . "', '" . $tertiary . "')";
			$gethue = mysql_query($sqlhue) or die(mysql_error());
			while($runhue = mysql_fetch_assoc($gethue))
			{
				$color_set[] = $runhue['hue'];
			}
				
				$ip  = "255.255.255.255";
				$filesize = filesize($image_name);
				$note = "Linked in IRC by " . $username;
				switch($username)
				{
					case "digiwombat":
						$user = 2;
						break;
					case "Alkenshel":
						$user = 16;
						break;
					case "Ci":
						$user = 4;
						break;
					case "sagematt":
					case "Mastersage":
						$user = 5;
						break;
					case "Zeroblade-":
						$user = 10;
						break;
					case "iluna":
						$user = 17;
						break;
					case "CC":
					case "Tieria":
					case "Liang":
					case "Fasalina":
						$user = 47;
						break;
					case "manga":
						$user = 49;
						break;
					case "Shance":
						$user = 41;
						break;
					case "Shin_Asuka":
						$user = 43;
						break;
					default:
						$sql_user = "select id from users where name = '" . $username . "' LIMIT 1";
						$run_user = mysql_fetch_assoc(mysql_query($sql_user));
						$user = $run_user["id"];
						break;
				}
				if(!$user) $user = 1;
				
				$sql_add = "INSERT INTO images(
											   owner_id,
											   owner_ip,
											   filename,
											   filesize,
											   hash,
											   ext,
											   width,
											   height,
											   source,
											   note,
											   posted,
										   primary_color,
										   secondary_color,
										   tertiary_color
											  )
										VALUES(
											   " . $user . ",
											   '" . $ip . "',
											   '" . $filename . "',
											   " . $filesize . ",
											   '" . $hash . "',
											   '" . $ext . "',
											   " . $size[0] . ",
											   " . $size[1] . ",
											   '" . mysql_real_escape_string($url) . "',
											   '" . $note . "',
											   '" . date('Y-m-d H:i:s') . "',
											   '" . strtolower($color_set[0]) . "',
												'" . strtolower($color_set[1]) . "',
											   '" . strtolower($color_set[2]) . "'
											  )";
				mysql_query($sql_add) or die("Fucked up.");
				
				if($_GET['from_web'] == 1)
				{
					header("Location: " . BASE_URL . "/post/upload/tag/");
					exit();
				}
				echo "Uploaded: " . $url;
			}
		}
	}
?>