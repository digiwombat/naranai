<?php
//	Fucking Color to Fucking Name
//		Created by Randall Fitzgerald
//	Code Adapted From:
//		http://www.colblindor.com/color-name-hue/
//	And 
// 		http://chir.ag/projects/ntc/



function color_to_name($color) 
{
	if(!isset($GLOBALS['color_names']))
	{
		global $color_names;
		$color_names = file(dirname(__FILE__) . '/color_names.json');
	}

	$color = strtoupper($color);

    $r = hexdec(substr($color, 0, 2));
	$g = hexdec(substr($color, 2, 2));
	$b = hexdec(substr($color, 4, 2));
	
	$hsl = hsl($color);
	$h = $hsl[0]; 
	$s = $hsl[1]; 
	$l = $hsl[2];
	
    $ndf1 = 0; 
	$ndf2 = 0; 
	$ndf = 0;
    $cl = -1;
	$df = -1;
	
	
	$count = count($GLOBALS['color_names']);
    for($i = 0; $i < $count; $i++)
    {
		if($color == $GLOBALS['color_names'][$i])
			return $GLOBALS['color_names'][$i];
		
		$name_r = hexdec(substr($GLOBALS['color_names'][$i], 0, 2));
		$name_g = hexdec(substr($GLOBALS['color_names'][$i], 2, 2));
		$name_b = hexdec(substr($GLOBALS['color_names'][$i], 4, 2));
		$name_hsl = hsl($GLOBALS['color_names'][$i]);
		$name_h = $name_hsl[0]; 
		$name_s = $name_hsl[1]; 
		$name_l = $name_hsl[2];
		
		$ndf1 = pow($r - $name_r, 2) + pow($g - $name_g, 2) + pow($b - $name_b, 2);
		$ndf2 = abs(pow($h - $name_h, 2)) + pow($s - $name_s, 2) + abs(pow($l - $name_l, 2));
		
		$ndf = $ndf1 + $ndf2 * 2;
		if($df < 0 || $df > $ndf)
		{
        	$df = $ndf;
        	$cl = $i;
      	}
    }
	
	return ($cl < 0 ? array("#000000", "Invalid Color: " . $color . '|' . $cl . '|' . $df, "#000000") : $GLOBALS['color_names'][$cl]);
}


function hsl($color) 
{

    $r = hexdec(substr($color, 0, 2)) / 255;
	$g = hexdec(substr($color, 2, 2)) / 255;
	$b = hexdec(substr($color, 4, 2)) / 255;

    $min = min($r, min($g, $b));
    $max = max($r, max($g, $b));
    $delta = $max - $min;
    $l = ($min + $max) / 2;

    $s = 0;
    if($l > 0 && $l < 1)
      $s = $delta / ($l < 0.5 ? (2 * $l) : (2 - 2 * $l));

    $h = 0;
    if($delta > 0)
    {
      if ($max == $r && $max != $g) $h += ($g - $b) / $delta;
      if ($max == $g && $max != $b) $h += (2 + ($b - $r) / $delta);
      if ($max == $b && $max != $r) $h += (4 + ($r - $g) / $delta);
      $h = $h/6;
    }
    return array(($h * 255), ($s * 255), ($l * 255));
}

?>