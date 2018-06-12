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
		$thumbFileName = "thumb" . $filename;
        $pictureName = $_POST['pictureName'];
		if(strlen($filename) > 60 || $pictureName == "" || !isset($_GET["gid"])){
			$error = true;
		}
		else{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				$error = false;
				$this->makeThumbnail($uploadfile, $thumbFileName);
			} else {
				$error = true;
			}
		}
    	
        $pictureRepository = new PictureRepository();
		
		if (!$error){
			$pictureRepository->doUpload($filename, $_SESSION['user_id'], $_GET["gid"], $pictureName);
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
            $file = $uploaddir . $bild->pathName;
            $thumbnail = $uploaddir . "thumbnails/thumb" . $bild->pathName;
            unlink($file);
            unlink($thumbnail);
            $pictureRepository->deleteById($bid);
            $error = false;
        } else{
            $error = true;
        }

        $gid = $_GET['gid'];

        header("Location: " . $GLOBALS['appurl'] . "/gallery/showById?gid=$gid");
        die();
    }

    public function edit(){
        $bid = $_GET['bid'];
        $pictureRepository = new PictureRepository();
        $view = new View('picture_edit');
        $view->data = $pictureRepository->readByIdAndKid($_SESSION['user_id'], $bid);
        $view->title = 'Bild bearbeiten';
        $view->heading = 'Bild bearbeiten';
        $view->display();
    }

    public function doSave(){
        $pictureName = $_POST['pictureName'];
        $gid = $_GET['gid'];
        if (isset($_GET['bid']) && $pictureName != ""){
            $bid = $_GET['bid'];
            $pictureRepository = new PictureRepository();
            $pictureRepository->update($bid, $_SESSION['user_id'], $pictureName);
        }

        header("Location: " . $GLOBALS['appurl'] . "/gallery/showById?gid=$gid");
        die();
    }

    private function makeThumbnail($src, $fileName){
        $destination = "../public/var/www/uploads/thumbnails/";

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $destination .= $fileName;

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * (250 / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor(250, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, 250, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $destination);
    }
}
