<?php
/**
 * This class can be used to get the most common colors in an image. It needs one parameter: $image, which is the filename of the image you want to process.
 *
 */
class GetMostCommonColors
{
	/**
 * The filename of the image (it can be a JPG, GIF or PNG image)
 *
 * @var string
 */
	var $image;

	/**
	 * Returns the colors of the image in an array, ordered in descending order, where the keys are the colors, and the values are the count of the color.
	 *
	 * @return array
	 */
	function Get_Color()
	{
		if (isset($this->image))
		{
			$im = $this->image;
			$imgWidth = imagesx($im);
			$imgHeight = imagesy($im);
			for ($y=0; $y < $imgHeight; $y += 5)
			{
				for ($x=0; $x < $imgWidth; $x += 5)
				{
					$index = imagecolorat($im,$x,$y);
					$Colors = imagecolorsforindex($im,$index);
					$Colors['red']=intval((($Colors['red'])+15)/32)*32;    //ROUND THE COLORS, TO REDUCE THE NUMBER OF COLORS, SO THE WON'T BE ANY NEARLY DUPLICATE COLORS!
					$Colors['green']=intval((($Colors['green'])+15)/32)*32;
					$Colors['blue']=intval((($Colors['blue'])+15)/32)*32;
					if ($Colors['red']>=256)
					$Colors['red']=240;
					if ($Colors['green']>=256)
					$Colors['green']=240;
					if ($Colors['blue']>=256)
					$Colors['blue']=240;
					$hexarray[]=substr("0".dechex($Colors['red']),-2).substr("0".dechex($Colors['green']),-2).substr("0".dechex($Colors['blue']),-2);
				}
			}
			$hexarray=array_count_values($hexarray);
			natsort($hexarray);
			$hexarray=array_reverse($hexarray,true);
			return $hexarray;

		}
		else die("You must enter a filename! (\$image parameter)");
	}
}
?>