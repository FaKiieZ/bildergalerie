<?php

require_once('../repository/PictureRepository.php');

class PictureController
{
    public function index()
    {
    	$view = new View('picture_upload');
    	$view->title = 'Bild hochladen';
		$view->heading = 'Bild hochladen';
		$view->error = null;
		$view->active_picture = "active";
    	$view->display();
    }

    public function upload()
    {
    	$uploaddir = "../public/var/www/uploads/";
		$uploadfile = $uploaddir . addslashes(time()) . basename($_FILES['userfile']['name']);
		$filename = addslashes(time()) . basename($_FILES['userfile']['name']);
		if(strlen($filename) > 60){
			$error = true;
		}
		else{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				$error = false;
			} else {
				$error = true;
			}
		}

    	
        $pictureRepository = new PictureRepository();
		
		if (!$error){
			$pictureRepository->doUpload(htmlspecialchars($filename), $_SESSION['user_id'], 1 );
		}
		
		$view = new View('picture_upload');
		$view->title = 'Bild hochladen';
		$view->heading = 'Bild hochladen';
		$view->error = $error;
    	$view->display();
	}
}
