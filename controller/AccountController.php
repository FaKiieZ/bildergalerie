<?php
require_once '../repository/UserRepository.php';

class AccountController
{
    public function index(){
        $view = new View('account');
        $view->title = 'Mein Konto';
        $view->heading = 'Mein Konto';
        $view->display();
    }

    public function edit(){

    }

    public function delete(){
        $userRepository = new UserRepository();
        $userRepository->deleteAllById($_SESSION['user_id']);
        session_destroy();
        header("Location: " . $GLOBALS['appurl'] . "/login/");
        die();
    }
}