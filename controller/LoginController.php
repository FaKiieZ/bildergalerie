<?php
require_once '../repository/UserRepository.php';
/**
 * Siehe Dokumentation im DefaultController.
 */
class LoginController
{
    public function index()
    {
        // Anfrage an die URI /user/crate weiterleiten (HTTP 302)
        $view = new View('login');
        $view->title = 'Login';
        $view->heading = 'Login';
        $view->error = false;
        $view->display();
    }

	// Vergleicht Benutzername & Passwort mit der Datenbank
    public function doLogin(){
		$error = false;
		$userRepository = new UserRepository();
		if(isset($_POST['benutzername']) && isset($_POST['passwort'])){
			$benutzername = htmlspecialchars($_POST['benutzername']);
			$passwort = htmlspecialchars(sha1($_POST['passwort']));
			
			// Vergleicht alle Datensätze mit der Eingabe
			foreach($userRepository->readAll() as $user){
				if($user->username == $benutzername){
					if($user->password == $passwort){
						session_start();
						$_SESSION['user_id'] = $user->id;
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
			$view = new View('login');
			$view->title = 'Login';
			$view->heading = 'Login';
			$view->error = $error;
			$view->display();
		}
		// Falls Login korrekt, Weiterleitung zum Feed
		else{
			header("Location: /feed");
			die();
		}
	}



}
