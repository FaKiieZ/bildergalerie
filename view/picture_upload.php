<?php

if($error){
    echo('<div class="alert alert-danger">Datei konnte nicht hochgeladen werden!</div>');
}
if($error === false){
    echo('<div class="alert alert-success">Datei wurde erfolgreich hochgeladen!</div>');
}
if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: /login");
    die();
}

?>
<form enctype="multipart/form-data" action="/picture/upload" method="POST">
    <!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" class="btn btn-default"/>
    <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
    Diese Datei hochladen: <input name="userfile" type="file" accept="image/*" class="btn btn-default" /><br>
    <input type="submit" value="Send File" class="btn btn-default"/>
</form>