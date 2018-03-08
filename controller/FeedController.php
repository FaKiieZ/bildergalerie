<?php

require_once('../repository/PictureRepository.php');
require_once('../repository/UserLikesPictureRepository.php');

/**
 * Siehe Dokumentation im DefaultController.
 */
class FeedController
{
    public function index()
    {
        $pictureRepository = new PictureRepository();

        $view = new View('feed');
        $view->title = 'Feed';
        $view->heading = 'Feed';
        session_start();
        $view->pictures = $pictureRepository->readFeed($_SESSION['user_id']);
        $view->active_feed = "active";
        $view->display();
    }

    public function like(){
        $userLikesPictureRepository = new UserLikesPictureRepository();

        session_start();
        $userId = htmlspecialchars($_SESSION['user_id']);
        $pictureId = htmlspecialchars($_GET['pictureId']);

        $userLikesPictureRepository->like($pictureId, $userId);

        header("Location: /feed");
        die();
    }
}
