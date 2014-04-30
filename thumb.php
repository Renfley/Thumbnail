<?php

/**
 * Andre St-Jacques (PHP)
 * @version 0.1
 * @since April 22, 2014
 * @author Andre St-Jacques
 *
 * Custom Thumbnail Solution Written and Supported by Andre St-Jacques
 * 
 */

//This is the size of the thumbnails we want to create.
$thumb_width = 150;
$thumb_height = 100;

//Please change the # for the Image url ie: http://example.com/image.jpg
$url = "##";


//This is where we will save the image.
//For the sake of development ill name the file Andre
$file_destination = "images/andre.gif";


$file_type = explode(".", $url);
$file_type = $file_type[count($file_type) - 1];


//This function will determine the size of any given image file and return the dimensions along 
//with the file type and a height/width text string to be used inside a normal HTML IMG tag and 
//the correspondant HTTP content type.
$url_file_size = getimagesize($url);
$url_file_width = $url_file_size[0];
$url_file_height = $url_file_size[1];


//We switch the format of the file we will create depending on the orginal extension.
switch($file_type) {
    case 'gif' :
		$source_image = imagecreatefromgif($url);
		break;
	case 'jpg' :
		$source_image = imagecreatefromjpeg($url);
		break;
	case 'png' :
		$source_image = imagecreatefrompng($url);
		break;
}

$fimg = imagecreatetruecolor($thumb_width, $thumb_height);
$wm = $url_file_width / $thumb_width;
$hm = $url_file_height / $thumb_height;
$h_height = $thumb_height / 2;
$w_height = $thumb_width / 2;

if ($url_file_width > $url_file_height) {
	$adjusted_width = $url_file_width / $hm;
	$half_width = $adjusted_width / 2;
	$int_width = $half_width - $w_height;
	imagecopyresampled($fimg, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $thumb_height, $url_file_width, $url_file_height);
} elseif (($url_file_width < $url_file_height) || ($url_file_width == $url_file_height)) {     $adjusted_height = $url_file_height / $wm;
	$half_height = $adjusted_height / 2;
	$int_height = $half_height - $h_height;
	imagecopyresampled($fimg, $source_image, 0, -$int_height, 0, 0, $thumb_width, $adjusted_height, $url_file_width, $url_file_height);
} else {     imagecopyresampled($fimg, $source_image, 0, 0, 0, 0, $thumb_width, $thumb_height, $url_file_width, $url_file_height);
}
//Uncomment the following to allow the file to be saved to a local source
//imagejpeg($fimg, $file_destination, 100);

//imagegif($fimg, $file_destination, 100);

// Handle output
if(function_exists('imagegif'))
{
    // For GIF
    header('Content-Type: image/gif');
    imagegif($fimg);
}
elseif(function_exists('imagejpeg'))
{
    // For JPEG
    header('Content-Type: image/jpeg');
    imagejpeg($fimg, NULL, 100);
}
elseif(function_exists('imagepng'))
{
    // For PNG
    header('Content-Type: image/png');
    imagepng($fimg);
}
else
{
    imagedestroy($fimg);
    die('No image support in this PHP server');
}

// If image support was found for one of these
// formats, then free it from memory
if($fimg)
{
    imagedestroy($fimg);
}

?>
<!-- <img src="images/andre.jpg"> -->