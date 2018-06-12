<?php
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$gid = $_GET['gid'];
$button = new ButtonBuilder();

if(isset($error)){
    if($error){
        echo('<div class="alert alert-danger">Datei konnte nicht hochgeladen werden!</div>');
    }
    if($error === false){
        echo('<div class="alert alert-success">Datei wurde erfolgreich hochgeladen!</div>');
    }
}

if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: " . $GLOBALS['appurl'] . "/login");
    die();
}

$form = new Form($GLOBALS['appurl']."/picture/doSave?bid=$data->bid&gid=$gid", "POST", "multipart/form-data");
echo $form->input()->label('Name')->name('pictureName')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($data->name);
echo $button->start($lblClass, $eltClass);
echo $button->label('Speichern')->name('send')->type('submit')->class('btn-default');
echo $button->end();
echo $form->end();