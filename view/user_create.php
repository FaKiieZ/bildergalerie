<?php

	if($error){
		echo('<div class="alert alert-danger"><strong>Error!</strong> Benutzername oder Email sind schon vorhanden!
	  </div>');
	}

?>

<form action="/user/create" method="POST">
	<span>Benutzername</span><br>
	<input name="benutzername" type="text" placeholder="Benutzername" class="form-control input-md" required><br>
	<span>Password</span><br>
	<input name="passwort" type="password" placeholder="Passwort" class="form-control input-md" required><br>
	<span>Email</span><br>
	<input name="email" type="email" placeholder="Email" class="form-control input-md" required><br>
	<button type="submit" class="btn btn-default">Registrieren</button>
</form>