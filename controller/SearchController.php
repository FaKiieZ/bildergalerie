<?php

require_once('../repository/UserRepository.php');

/**
 * Siehe Dokumentation im DefaultController.
 */
class SearchController
{
    public function index()
    {
        $userRepository = new UserRepository();

        $view = new View('search');
        $view->title = 'Suche';
        $view->heading = 'Suche';
        if(isset($_GET['keyword'])){
            $view->result = $userRepository->readByKeyword(htmlspecialchars($_GET['keyword']));
        }else{
            $view->result = $userRepository->readByKeyword('');
        }
        $view->display();
    }
}
