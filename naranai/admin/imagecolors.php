<?php

	require_once('../hibbity/dbinfo.php');
	include_once('../lib/colors.inc.php');
	include_once('../lib/color_to_name.php');
	
	echo "Adding color information for all images without color information.<br />";
	
	$sql = "SELECT hash, id FROM `images` WHERE `primary_color` = '' OR `primary_color` = 'black'";
	$get = mysql_query($sql);
	while($run = mysql_fetch_assoc($get))
	{
	
		$ab = substr($run['hash'], 0, 2);
		$thumb_name = SITE_DIR . "/thumbs/" . $ab . "/" . $run['hash'];
		$source = imagecreatefromjpeg($thumb_name) or die("Bad file.");
		if(!$ex)
			$ex=new GetMostCommonColors();
		$ex->image=$source;	
		$colors=$ex->Get_Color();
		$how_many=2; // zero based.
		$colors_key=array_keys($colors);
		$primary_color   = color_to_name($colors_key[0]);
		$secondary_color = color_to_name($colors_key[1]);
		$tertiary_color  = color_to_name($colors_key[2]);
		
		$delsql = "UPDATE `images` SET 
						`primary_color` = '" . strtolower($primary_color[2]) . "',
						`secondary_color` = '" . strtolower($secondary_color[2]) . "',
						`tertiary_color` = '" . strtolower($tertiary_color[2]) . "'
					WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Added colors for " . $run['id'] . "<br />";
		unset($source);
		
	}
	
?>