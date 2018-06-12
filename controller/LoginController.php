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
    public function registration($message = null)
    {
      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->message = $message;
      $view->display();
    }

      // Vergleicht Benutzername & Passwort mit der Datenbank
      public function doLogin(){
          $error = false;
          $userRepository = new UserRepository();
          if(isset($_POST['email']) && isset($_POST['passwort'])){
              $email = $_POST['email'];
              $passwort = sha1($_POST['passwort']);

              // Vergleicht alle Datensätze mit der Eingabe
              foreach($userRepository->readAll() as $user){
                  if ($user->email == $email) {
                      if ($user->passwort == $passwort) {
                          session_start();
                          $_SESSION['user_id'] = $user->kid;
                          $_SESSION['besucht'] = true;
                          $error = false;
                      } else {
                          $error = true;
                      }
                  } else {
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
          // Falls Login korrekt, Weiterleitung zur Galerie
          else{
              header("Location: " .$GLOBALS['appurl'] .  "/gallery/" );
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
                  $this->registration("Der eingegebene Benutzername und die E-Mail Adresse existiern schon.");
              } elseif ($userRepository->userAlreadyExistsByName ( $username )) {
                  $this->registration("Der eingegebene Benutzername exisitiert schon.");
              } elseif ($userRepository->userAlreadyExistsByEmail ( $email )) {
                  $this->registration("Die eingebene E-Mail Adresse existiert schon.");
              }
              elseif (!preg_match("\"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}\"", $_POST['password'])){
                  $this->registration("Das Passwort entspricht nicht den Anforderungen.");
              }
              elseif ( $_POST ['passwordbestätigt'] != $_POST ['password']) {
                  $this->registration("Die Passwörter stimmen nicht überein.");
                  }
              else {
                  $user_id = $userRepository->create($username, $passwort, $email);
                  session_start();
                  $_SESSION ['besucht'] = true;
                  $_SESSION ['user_id'] = $user_id;

                  header("Location: " . $GLOBALS['appurl'] . "/gallery/");
              }
          } else {
              $this->registration("Invalide Daten eingegeben.");
          }
      }
}