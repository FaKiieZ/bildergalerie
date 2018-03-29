<?php
require_once '../repository/UserRepository.php';
/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
  class LoginController
  {
    /**
     * Default-Seite für das Login: Zeigt das Login-Formular an
	 * Dispatcher: /login
     */
    public function index()
    {
      $view = new View('login_index');
      $view->title = 'Bilder-DB';
      $view->heading = 'Login';
      $view->display();
    }
    /**
     * Zeigt das Registrations-Formular an
	 * Dispatcher: /login/registration
     */
    public function registration()
    {
      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->display();
    }

      // Vergleicht Benutzername & Passwort mit der Datenbank
      public function doLogin(){
          $error = false;
          $userRepository = new UserRepository();
          if(isset($_POST['email']) && isset($_POST['passwort'])){
              $email = htmlspecialchars($_POST['email']);
              $passwort = htmlspecialchars(sha1($_POST['passwort']));

              // Vergleicht alle Datensätze mit der Eingabe
              foreach($userRepository->readAll() as $user){
                  if($user->email == $email){
                      if($user->passwort == $passwort){
                          session_start();
                          $_SESSION['user_id'] = $user->kid;
                          $_SESSION['besucht'] = true;
                          $error = false;
                      }
                      else{
                          $error = true;
                      }
                  }
                  else{
                      $error = true;
                  }
              }
          }
          else {
              $error = true;
          }


          // Falls der Login fehl schlägt, Weiterleitung zur Login-Seite
          if($error){
              $view = new View('login_index');
              $view->title = 'Bilder-DB';
              $view->heading = 'Login';
              $view->error = $error;
              $view->display();
          }
          // Falls Login korrekt, Weiterleitung zum Feed
          else{
              header("Location: " .$GLOBALS['appurl']);
              die();
          }
      }

      /**
       * überprüft ob der User schon existiert, wenn ja was schon existiert. Sonst erstellt es einen User
       */
      public function createUser() {
          if (isset ( $_POST ['username'] ) && filter_var ( $_POST ['email'], FILTER_VALIDATE_EMAIL ) && isset ( $_POST ['password'] ) && isset ( $_POST ['passwordbestätigt'])) {

              $username = $_POST ['username'];
              $email = $_POST ['email'];
              $passwort = $_POST ['password'];

              $userRepository = new UserRepository();

              if ($userRepository->userAlreadyExistsByName ( $username ) && $userRepository->userAlreadyExistsByEmail ( $email )) {
                  $view = new View ( 'login_registration' );
                  $view->title = 'Register';
                  $view->heading = 'Register';
                  $view->message = "Der eingegebene Benutzername und die E-Mail Adresse existiern schon.";
                  $view->display ();
              } elseif ($userRepository->userAlreadyExistsByName ( $username )) {
                  $view = new View ( 'login_registration' );
                  $view->title = 'Register';
                  $view->heading = 'Register';
                  $view->message = "Der eingegebene Benutzername exisitiert schon.";
                  $view->display ();
              } elseif ($userRepository->userAlreadyExistsByEmail ( $email )) {
                  $view = new View ( 'login_registration' );
                  $view->title = 'Register';
                  $view->heading = 'Register';
                  $view->message = "Die eingebene E-Mail Adresse existiert schon";
                  $view->display ();
              }
              elseif ( $_POST ['passwordbestätigt'] != $_POST ['password']) {
                  $view = new View ( 'login_registration' );
                  $view->title = 'Register';
                  $view->heading = 'Register';
                  $view->message = "Die Passwörter stimmen nicht überein";
                  $view->display ();
                  }
              else {

                  $user_id = $userRepository->create($username, $passwort, $email);
                  session_start();
                  $_SESSION ['besucht'] = true;
                  $_SESSION ['user_id'] = $user_id;

                  header("Location: " . $GLOBALS['appurl'] . "/login");
              }
          } else {
              $view = new View ( 'login_registration' );
              $view->title = 'Register';
              $view->heading = 'Register';
              $view->message = 'Invalide Daten eingegeben.';
              $view->display ();
          }
      }
}
?>