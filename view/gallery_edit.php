<?php
$gid = $_GET['gid'];
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$form = new Form($GLOBALS['appurl'] ."/gallery/doSave?gid=" . $gid);
$button = new ButtonBuilder();
if (isset($data)) {
    echo "<br>";
    echo $form->input()->label('Name der Galerie')->name('galleryName')->type('text')->value($data->name)->lblClass($lblClass)->eltClass($eltClass);
    echo $form->checkbox()->name('publiziert')->value("Publiziert")->checked($data->publiziert);
    echo $button->start($lblClass, $eltClass);
    echo $button->label('Speichern')->name('send')->type('submit')->class('btn-default');
    echo $button->end();
    echo $form->end();
    echo "<br>";
}
?>