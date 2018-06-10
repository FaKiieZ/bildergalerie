<?php

if($error){
    echo('<div class="alert alert-danger">Datei konnte nicht hochgeladen werden!</div>');
}
if($error === false){
    echo('<div class="alert alert-success">Datei wurde erfolgreich hochgeladen!</div>');
}
if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: " . $GLOBALS['appurl'] . "/login");
    die();
}
?>
<form enctype="multipart/form-data" action="<?=$GLOBALS['appurl']?>/picture/upload?gid=<?=$_GET['gid']?>" method="POST">
    <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
    <input name="userfile" type="file" accept="image/*" class="btn btn-default" /><br>
<?php
    //$form = new Form($GLOBALS['appurl']."/picture/upload");
    //echo $form->dropdown()->name("galerie")->label("Galerie: ");
?>
    <input type="submit" value="Bild hochladen" class="btn btn-default"/>
</form>