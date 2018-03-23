<?php

/**
* 
*/
class Image
{
	public function create_thumbnail($filename, $desired_width,$dir_for_full)
	{
		
		$format = mime_content_type($dir_for_full.$filename);
		/* read the source image */

		$source_image = $dir_for_full.$filename;
		if($format == 'image/jpeg')
		{
			$source_image = imagecreatefromjpeg($source_image);
		}
		else if($format == 'image/png')
		{
			$source_image = imagecreatefrompng($source_image);
		}

		$width = imagesx($source_image);
		$height = imagesy($source_image);
		$desired_width = 300;
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height * ($desired_width / $width));

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

		imageAlphaBlending($virtual_image, false);
		imageSaveAlpha($virtual_image, true);

		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

		$dir_for_thumb = APP_URL.'/public/uploads/temp/thumb/';
		/* create the physical thumbnail image to its destination */
		header('Content-Type: image/jpeg');

		if($format == 'image/jpeg')
		{
			imagejpeg($virtual_image, $dir_for_thumb.$filename);
		}
		else if($format == 'image/png')
		{
			imagepng($virtual_image, $dir_for_thumb.$filename);
		}

	}

	public function save(){
		//dsada
	}
}
?>