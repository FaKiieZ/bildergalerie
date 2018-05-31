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
<form enctype="multipart/form-data" action="<?php echo $GLOBALS['appurl']?>/picture/upload" method="POST">
    <!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
    <input type="hidden" name="MAX_FILE_SIZE" value="4000000" class="btn btn-default"/>
    <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
    <input name="userfile" type="file" accept="image/*" class="btn btn-default" /><br>
<?php
    $form = new Form($GLOBALS['appurl']."/picture/upload");
    echo $form->dropdown()->name("galerie")->label("Galerie: ");
?>
    <input type="submit" value="Bild hochladen" class="btn btn-default"/>
</form>