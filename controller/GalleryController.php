<?php
require_once '../repository/GalleryRepository.php';

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
        if(isset($_POST['galleryName']) && isset($_POST['publiziert'])) {
            $gname = $_POST['galleryName'];
            $publiziert = $_POST['publiziert'];

            $galleryRepository = new GalleryRepository();
            session_start();
            $galleryRepository->create($_SESSION['user_id'], $gname, $publiziert);
            $view = new View ( 'gallery' );
            $view->title = 'Galerie';
            $view->heading = 'Galerie';
        }else{
            die("spitu");
        }
    }
}