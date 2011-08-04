<?PHP
/**
	This code is given out under the GPL license agreement.
	You may use this code as you wish, I only wish you'll link back to my site http://codefat.com when 
	using my code in a project or a public place. 
	
	Please look at license.txt before using the code! By using the code you are agreeing to the license agreement
	
	Please do not steal my work, if you change it, please link back to me and I would really be happy
	if you sent me your changes to gawy.gawy@gmail.com so I could implement them if they look good and add them to 
	my site to reach all other people.	
	
	Thank you!
	
	v1.3 BETA
	Changes:
		*Removed _resize, _checkifresizable as I decided that images are not the same if they are different sizes!
		*Added some new functions to clean up the code
		*Added random removing of pixels to fasten up the code, this will be done better later on to check pixels if the deviation is bigger than 10%
		*Added debug code to check for values
		*_checkPixels improved
		
	@TODO:
		* Add comments to all functions
		* Clean up some comparission code
		* Fix random check to 10%
		* Merge some loops
		* Optimize code
		* Add a logo detection code
		
	Tutorial:
		Example use:
			$t = new imageCompare('/somedir/1.jpg', '/somedir/2.jpg');
				if($t->same())
					echo "Same";
				else
					echo "Not same";
					
	Please report any bugs or suggestions to:
		gawy.gawy@gmail.com
		Please mark the mail as "ImageCompare: Bugs/Suggestions"
**/
class imageCompare {
	private $im1, 
			$im2, 
			$id = -1, 
			$procent, 
			$_pixelOffset,
			$checked = 0,
			$random,
			$_debug = false,
			$_debug_values = array();
		
	function __construct($path1, $path2, $_pixelOffset = 10, $procent = 10, $debug = false) {
		set_time_limit(0);
		$this->_debug = $debug;
		if(!file_exists($path1) || !file_exists($path2)) {
			if($this->_debug)
				echo "<b>DEBUG</b>: Image(1): $path1<br/>Image(2): $path2<br/>";
				
			throw new Exception('ImageCompare: One or more of the given files does not exist');
		}
	
		if(md5_file($path1) == md5_file($path2)) { // If md5 sum is identical, images are identical, hopefully :p
			$this->id = 1;
			if($this->_debug) {
				$this->_debug_values['popped'] = 0;
				$this->_debug_values['shuffled'] = 0;
				echo "<b>DEBUG</b>: Md5_file sums matched! (" . md5_file($path1) . " == " . md5_file($path2) . ")<br/>";
			}
		} else {
			if($this->_debug)
				echo "<b>DEBUG</b>: PidelOffset: $_pixelOffset px<br/><b>DEBUG</b>: Percent: $procent %<br/>";
			
			$this->_pixelOffset = $_pixelOffset; $this->procent = $procent;
			$this->_buildImages($path1, $path2); // Build the images from the given paths
		}
	}
	
	private function _createFromType($image, $return = false) {
		switch($image[2]) {
			case 1:
				// GIF
				if($this->_debug)
					echo "<b>DEBUG</b>: Type is GIF for $image[path]<br/>";
					
				if($return)
					return imagecreatefromgif($image['path']);
				$image['image'] = imagecreatefromgif($image['path']);
			break;
			case 2:
				// JPEG
				if($this->_debug)
					echo "<b>DEBUG</b>: Type is JPEG for $image[path]<br/>";
				if($return)
					return imagecreatefromjpeg($image['path']);
				$image['image'] = imagecreatefromjpeg($image['path']);
			break;
			case 3:
				// PNG
				if($this->_debug)
					echo "<b>DEBUG</b>: Type is PNG for $image[path]<br/>";
				if($return)
					return imagecreatefrompng($image['path']);
				$image['image'] = imagecreatefrompng($image['path']);
			break;
			/*case 6:
				// BMP
				// What to do here?
			break;*/
			default:
				throw new Exception('ImageCompare: unsupported image format');
			break;
		}
	}	
	
	private function _buildImages($path1, $path2) {	
		// Get image information
		$this->im1 = getimagesize($path1); $this->im2 = getimagesize($path2);
		
		$this->im1['path'] = $path1;
		$this->im2['path'] = $path2;
		
		// Build images
		$this->_createFromType(&$this->im1); $this->_createFromType(&$this->im2);
		
		if($this->im1[0] != $this->im2[0] || $this->im1[1] != $this->im2[1])
			$this->identical = false;
	}
	
	public function same() {
		if($this->id == 1)
			return $this->id;
		else {
			if($this->_debug)
				echo "<b>DEBUG</b>: Image not checked, running check now....<br/>";
			$identical = $this->_identical();
			
			if($this->_debug) {
				echo "<b>DEBUG:</b> Popped " . $this->_debug_values[popped] . " values<br/>";
				echo "<b>DEBUG:</b> Shuffled " . $this->_debug_values[shuffled] . " times<br/>";
			}
			return $identical;
		}
	}
	
	private function _identical() {			
		$dev = 0; $num++;
		
		for($i = 0; $i < $this->im1[0]; $i += $this->_pixelOffset) 
			for($j = 0; $j < $this->im1[1]; $j += $this->_pixelOffset) {
				$dev += $this->_isDeviatePixels($i, $j);
				$num++;
			}
		
		if($this->_debug)
			echo "<b>DEBUG</b>: " . round(($this->checked/($this->im1[0]*$this->im1[1]))*100) . "% of image checked<br/>";
		
		if(($dev/$num)*100 < 99)
			return false;
		return true;
	}
	
	private function _checkPixels($pixels) {
		$medel = 0;
		$upper_limit = (1 + ($this->procent/100)); $lower_limit = (1 - ($this->procent/100));
		
		for($i = count($pixels['x']); $i > 0; $i--) {
			for($j = count($pixels['y']); $j > 0; $j--) {
					$ci_1 = imagecolorat($this->im1['image'], $pixels['x'][$i], $pixels['y'][$j]);
					$ci_2 = imagecolorat($this->im2['image'], $pixels['x'][$i], $pixels['y'][$j]);
					
					$ct_1 = imagecolorsforindex($this->im1['image'], $ci_1);
					$ct_2 = imagecolorsforindex($this->im2['image'], $ci_2);
					
					if($ct_1['red'] > $upper_limit*$ct_2['red'] || $ct_1['red'] < $lower_limit*$ct_2['red'] ||  $ct_1['blue'] > $upper_limit*$ct_2['blue'] ||  $ct_1['blue'] < $lower_limit*$ct_2['blue'] ||  $ct_1['green'] > $upper_limit*$ct_2['green'] ||  $ct_1['green'] < $lower_limit*$ct_2['green']) {
						$medel -= 5;
					} else 
						$medel += 1;
					$this->checked++;
			}
		}
		return $medel;
	}
	
	private function _isDeviatePixels($x, $y) {
		$dx = $this->_pixelOffset; $dy = $this->_pixelOffset;
		$pL = array(); $pR = array(); $pL['x'] = array(); $pL['y'] = array();
		$pR['x'] = array(); $pR['y'] = array();
		
		while($x + $dx > $this->im1[0] && $dx != 0)	$dx--;
		while($y + $dy > $this->im1[1] && $dy != 0)	$dy--;
		
		
		$halfX = floor($dx/2);
		$halfY = floor($dy/2);
		
		for($i = $x; $i < $x + $dx; $i++)
			array_push($pL['x'], $i);
		for($i = $y; $i < $y + $dy; $i++)
			array_push($pL['y'], $i);		
			
		if(rand(0,1)) {
			if($this->_debug)
				$this->_debug_values['shuffled']++;
			shuffle($pL['x']);
			shuffle($pL['y']);
			
			for($i = rand(1, 2); $i > 0; $i--) {
				if($this->_debug)
					if(is_numeric($this->_debug_values['popped']))
						$this->_debug_values['popped']++;
					else
						$this->_debug_values['popped'] = 0;
				array_pop($pL['x']);
				array_pop($pL['y']);
			}
		}
		return $this->_checkPixels($pL) > 1 ? 1 : 0;
	}	
	
	public function __destruct() {
		imagedestroy($this->im1['image']);
		imagedestroy($this->im2['image']);
		unset($this);
	}
}	
?>
