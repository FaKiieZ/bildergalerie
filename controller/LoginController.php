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
              header("Location: " .$GLOBALS['appurl'] . "/default");
              die();
          }
      }
}
?>