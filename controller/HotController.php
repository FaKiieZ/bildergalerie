<?php

require_once('../repository/PictureRepository.php');
require_once('../repository/UserLikesPictureRepository.php');

/**
 * Siehe Dokumentation im DefaultController.
 */
class HotController
{
    public function index()
    {
        $pictureRepository = new PictureRepository();

        $view = new View('hot');
        $view->title = 'Hot';
        $view->heading = 'Hot';
        session_start();
        $view->pictures = $pictureRepository->readHot($_SESSION['user_id']);
        $view->active_hot = "active";
        $view->display();
    }

    public function like(){
        $userLikesPictureRepository = new UserLikesPictureRepository();

        session_start();
        $userId = htmlspecialchars($_SESSION['user_id']);
        $pictureId = htmlspecialchars($_GET['pictureId']);

        $userLikesPictureRepository->like($pictureId, $userId);

        header("Location: /hot");
        die();
    }
}
