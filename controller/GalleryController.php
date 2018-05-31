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
        $view->data = $galleryRepository->readAllWithFirstPicture();
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
            $publiziert = isset($_POST['publiziert']) ? $_POST['publiziert'] : false;

            $galleryRepository = new GalleryRepository();
            $galleryRepository->create($_SESSION['user_id'], $gname, (isset($publiziert)) ? $publiziert : FALSE);
            $this->index();
        }
    }

    public function deleteGallery(){
        if(isset($_GET['gid']) && isset($_SESSION['user_id'])) {
            $gid = $_GET['gid'];
            $kid = $_SESSION['user_id'];
            $galleryRepository = new GalleryRepository();
            $pictureRepository = new PictureRepository();
            $pictures = $pictureRepository->readAllByGalleryId($gid, $kid);
            if ($pictures == NULL) {
                $galleryRepository->deleteByIdAndKid($gid, $kid);
                $view = new View('gallery');
                $view->title = 'Galerie';
                $view->heading = 'Galerie';
                $view->data = $galleryRepository->readAll();
                $view->display();
            }

            else {
                $view = new View('gallery');
                $view->title = 'Galerie';
                $view->heading = 'Galerie';
                $view->data = $galleryRepository->readAll();
                $view->message = "Alle Bilder müssen vor dem Löschen der Galerie entfernt werden.";
                $view->display();
            }
        }

    }

    public function showById(){
        $gid = $_GET['gid'];
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();
        $gallery = $galleryRepository->readById($gid);
        $view = new View('gallery_view');
        $view->title = 'Galerie (' . $gallery->name . ')';
        $view->heading = 'Galerie (' . $gallery->name . ')';
        $view->data = $pictureRepository->readAllByGalleryId($gid, $_SESSION['user_id']);
        $view->display();
    }

    public function doRead(){
        $gid = $_GET['gid'];
        $galleryRepository = new GalleryRepository();
        $gallery = $galleryRepository->readNameAndPubliziertByGidAndKid($gid, $_SESSION['user_id']);
        $view = new View('gallery_edit');
        $view->title = 'Galerie';
        $view->heading = 'Galerie';
        $view->display();
    }
}