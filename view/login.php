<?php 

session_start();
// Falls vom Controller ein Error kommt, wird eine Fehlermeldung ausgegeben.
if($error){
	echo('<div class="alert alert-danger"><strong>Error!</strong> Benutzername oder Passwort falsch!
	</div>');
}
// Kontrolliert ob eine gültige Session aktiv ist.
if($_SESSION['besucht'] == true){
	header("Location: /feed"); /* Browser umleiten */
	exit;
}
	
?>
<form action="/login/doLogin" method="POST">
	<span>Benutzername</span><br>
	<input name="benutzername" type="text" placeholder="Benutzername" class="form-control input-md" required><br>
	<span>Password</span><br>
	<input name="passwort" type="password" placeholder="Passwort" class="form-control input-md" required><br>
	<button type="submit" class="btn btn-default">Login</button>
</form>
