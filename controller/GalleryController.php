<?php
require_once '../repository/GalleryRepository.php';
require_once '../repository/PictureRepository.php';

class GalleryController
{
    public function index(){
        $galleryRepository = new GalleryRepository();
        $view = new View('gallery');
        $view->title = 'Galerie';
        $view->heading = 'Galerie';
        $view->data = $galleryRepository->readAll();
        $view->display();
    }

    public function createGallery() {
        $view = new View('gallery_create');
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();
    }

    public function doCreate(){
        if(isset($_POST['galleryName'])) {
            $gname = $_POST['galleryName'];
            $publiziert = $_POST['publiziert'];
            session_start();
            $galleryRepository = new GalleryRepository();
            $galleryRepository->create($_SESSION['user_id'], $gname, (isset($publiziert)) ? $publiziert : FALSE);
            $this->index();
        }else{
            die("spitu");
        }
    }

    public function showById(){
        $gid = $_GET['gid'];
        $pictureRepository = new PictureRepository();
        $view = new View('gallery_view');
        $view->title = 'Galerie';
        $view->heading = 'Galerie';
        $view->data = $pictureRepository->readAllByGalleryId($gid, $_SESSION['user_id']);
        $view->display();
    }
}