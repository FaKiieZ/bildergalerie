<?php
require_once '../repository/GalleryRepository.php';
require_once '../repository/PictureRepository.php';

class GalleryController
{
    public function index($message = null){
        $galleryRepository = new GalleryRepository();
        $view = new View('gallery');
        $view->title = 'Meine Galerien';
        $view->heading = 'Meine Galerien';
        $view->data = $galleryRepository->readAllWithFirstPictureByKid($_SESSION['user_id']);
        $view->message = $message;
        $view->display();
    }

    public function createGallery() {
        $view = new View('gallery_create');
        $view->title = 'Galerie erstellen';
        $view->heading = 'Galerie erstellen';
        $view->display();
    }

    public function doCreate(){
        if(isset($_POST['galleryName'])) {
            $gname = $_POST['galleryName'];
            $publiziert = 0;

            if (isset($_POST['publiziert'])){
                $publiziert = $_POST['publiziert'];
            }

            $galleryRepository = new GalleryRepository();
            $galleryRepository->create($_SESSION['user_id'], $gname, $publiziert);
            $this->index();
        }
    }

    public function doSave(){
        if(isset($_GET['gid']) && isset($_SESSION['user_id']) && isset($_POST['galleryName'])){
            $gid = $_GET['gid'];
            $kid = $_SESSION['user_id'];
            $gname = $_POST['galleryName'];
            $publiziert = 0;

            if (isset($_POST['publiziert'])){
                $publiziert = $_POST['publiziert'];
            }

            $galleryRepository = new GalleryRepository();
            $galleryRepository->updateGallery($kid, $gid, $gname, $publiziert);
            header("Location: " . $GLOBALS['appurl'] . "/gallery/showById?gid=$gid");
            die();
        }
    }

    public function deleteGallery(){
        if(isset($_GET['gid']) && isset($_SESSION['user_id'])) {
            $gid = $_GET['gid'];
            $kid = $_SESSION['user_id'];
            $galleryRepository = new GalleryRepository();
            $pictureRepository = new PictureRepository();
            $pictures = $pictureRepository->readAllByGalleryId($gid, $kid);
            $_GET['gid'] = null;
            if ($pictures == NULL) {
                $galleryRepository->deleteByIdAndKid($gid, $kid);
                $this->index();
                die();
            }

            else {
                $this->index("Alle Bilder müssen vor dem Löschen der Galerie entfernt werden.");
                die();
            }
        }
    }

    public function showById(){
        $gid = $_GET['gid'];
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();
        $gallery = $galleryRepository->readWithUserById($gid);
        $isOwner = true;
        if ($gallery == null || $gallery->kid != $_SESSION['user_id']){
            $isOwner = false;
            $_GET['notOwner'] = true;

            if ($gallery == null || $gallery->publiziert == 0){
                $this->index("Dies dürfen Sie nicht tun!");
                die();
            }
        }else {
            $_GET['notOwner'] = null;
        }

        $userName = "";

        if (!$isOwner){
            $userName = " erstellt von " . $gallery->user->benutzername;
        }

        $view = new View('gallery_view');
        $view->title = 'Galerie (' . htmlspecialchars($gallery->name) . $userName . ')';
        $view->heading = 'Galerie (' . htmlspecialchars($gallery->name) . $userName . ')';
        $view->data = $pictureRepository->readAllByGalleryId($gid);
        $view->isOwner = $isOwner;
        $view->display();
    }

    public function editGallery(){
        $gid = $_GET['gid'];
        $galleryRepository = new GalleryRepository();
        $view = new View('gallery_edit');
        $view->data = $galleryRepository->readByIdAndKid($_SESSION['user_id'], $gid);
        $view->title = 'Galerie bearbeiten';
        $view->heading = 'Galerie bearbeiten';
        $view->display();
    }

    public function showPublic(){
        $galleryRepository = new GalleryRepository();
        $view = new View('gallery_public');
        $view->title = 'Publizierte Galerien';
        $view->heading = 'Publizierte Galerien';
        $view->data = $galleryRepository->readAllPublicWithFirstPicture();
        $view->display();
    }
}