<?php
require_once '../config.php';
require_once 'Image.php';


if(isset($_POST)){
	$file = $_FILES['image'];
	$tmp_file = $file['tmp_name'];
	$type = $file['type'];
	$allowed_type =  ['image/jpeg', 'image/jpg', 'image/png'];
	$ext  = pathinfo($file['name'], PATHINFO_EXTENSION);

	$filename = sha1(mt_rand(111111,9999999)).'.'.$ext;



	$data = [];
	

	if (!in_array($type, $allowed_type)) {
		$data['error'] = 'Unsupported image format';
		echo json_encode($data);die();
	}

	if($file['error'] == 1){
		$data['error'] = 'Image corrupted.';
		echo json_encode($data);die();
	}

	if($file['size'] == 0){
		$data['error'] = 'Image size too small.';
		echo json_encode($data);die();
	}

	$upload_url = APP_URL.'/public/uploads/';

	if(!file_exists($upload_url)){
		mkdir($upload_url);
	}

	if(!file_exists($upload_url.'temp/')){
		mkdir($upload_url.'temp/');
	}


	$dir_for_full = $upload_url.'temp/full/';
	$dir_for_thumb = $upload_url.'temp/thumb/';


	if(!file_exists($dir_for_full)){
		mkdir($dir_for_full);
	}
	if(!file_exists($dir_for_thumb)){
		mkdir($dir_for_thumb);
	}
	$full_image = $dir_for_full.$filename;

	move_uploaded_file($tmp_file, $dir_for_full.$filename);
	
	$image = new Image();
	$image->create_thumbnail($filename,300,$dir_for_full);

	$data['image'] = $filename;

	$data['view'] = '<div class="col-md-4" style="height:229px;"><img src="'.SITE_URL.'uploads/temp/thumb/'.$filename.'" alt="" class="img img-thumbnail"></div>';
	
	echo json_encode($data);die();
}


?>