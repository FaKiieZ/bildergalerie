<?php
require_once '../repository/GalleryRepository.php';

class GalleryController
{
    public function index(){
        $view = new View('gallery');
        $view->title = 'Galerie';
        $view->heading = 'Galerie';
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

            $galleryRepository = new GalleryRepository();
            session_start();
            $galleryRepository->create($_SESSION['user_id'], $gname);
            $view = new View ( 'gallery' );
            $view->title = 'Galerie';
            $view->heading = 'Galerie';
        }
    }
}