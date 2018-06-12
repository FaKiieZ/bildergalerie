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

    public function edit($message = null){
        $userRepository = new UserRepository();
        $view = new View("account_edit");
        $view->title = 'Mein Konto bearbeiten';
        $view->heading = 'Mein Konto bearbeiten';
        $view->konto = $userRepository->readById($_SESSION['user_id']);
        $view->message = $message;
        $view->display();
    }

    public function delete(){
        $userRepository = new UserRepository();
        $userRepository->deleteAllById($_SESSION['user_id']);
        session_destroy();
        header("Location: " . $GLOBALS['appurl'] . "/login/");
        die();
    }

    public function doSave(){
        if (isset ( $_POST ['username'] ) && filter_var ( $_POST ['email'], FILTER_VALIDATE_EMAIL ) && isset ( $_POST ['password'] ) && isset ( $_POST ['passwordbestätigt'])) {

            $username = $_POST['username'];
            $email = $_POST['email'];
            $passwort = $_POST['password'];

            $userRepository = new UserRepository();

            if ($userRepository->userAlreadyExistsByName ( $username ) && $userRepository->userAlreadyExistsByEmail ( $email )) {
                $this->edit("Der eingegebene Benutzername und die E-Mail Adresse existiern schon.");
            } elseif ($userRepository->userAlreadyExistsByName ( $username )) {
                $this->edit("Der eingegebene Benutzername exisitiert schon.");
            } elseif ($userRepository->userAlreadyExistsByEmail ( $email )) {
                $this->edit("Die eingebene E-Mail Adresse existiert schon.");
            }
            elseif (!preg_match("\"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}\"", $_POST['password'])){
                $this->edit("Das Passwort entspricht nicht den Anforderungen.");
            }
            elseif ( $_POST ['passwordbestätigt'] != $_POST ['password']) {
                $this->edit("Die Passwörter stimmen nicht überein.");
            }
            else {
                $userRepository->update($username, $passwort, $email, $_SESSION['user_id']);
                $this->index();
            }
        } else {
            $this->edit("Invalide Daten eingegeben.");
        }
    }
}