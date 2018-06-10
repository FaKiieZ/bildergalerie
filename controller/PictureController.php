<?php

require_once '../repository/PictureRepository.php';

class PictureController
{
    public function index()
    {
    	$view = new View('picture_upload');
    	$view->title = 'Bild hochladen';
		$view->heading = 'Bild hochladen';
		$view->error = null;
		$view->active_picture = "active";
		$view->gid = $_GET["gid"];
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
			$pictureRepository->doUpload(htmlspecialchars($filename), $_SESSION['user_id'], $_GET["gid"]);
		}
		
		$view = new View('picture_upload');
		$view->title = 'Bild hochladen';
		$view->heading = 'Bild hochladen';
		$view->error = $error;
    	$view->display();
	}

	public function delete(){
        $uploaddir = "../public/var/www/uploads/";
        if (isset($_GET['bid'])){
            $bid = $_GET['bid'];
            $pictureRepository = new PictureRepository();
            $bild = $pictureRepository->readById($bid);
            $file = $uploaddir + $bild->name;
            die(var_dump($file));
            unlink($file);
            $pictureRepository->deleteById($bid);
            $error = false;
        } else{
            $error = true;
        }

        $gid = $_GET['gid'];

        header("Location: " . $GLOBALS['appurl'] . "/gallery/showById?gid=$gid");
        die();
    }
}
