<?php
$gid = $_GET['gid'];
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$form = new Form($GLOBALS['appurl'] ."/gallery/editGallery?gid=" . $gid);
$button = new ButtonBuilder();
echo "<br>";
echo $form->input()->label('Name der Galerie')->name('galleryName')->type('text')->value($data->id)->lblClass($lblClass)->eltClass($eltClass);
//if ($data->publiziert == "1111111111111111111111111111111") {
    //echo $form->checkbox()->name('publiziert')->value("Publiziert");
//} else {
echo $form->checkbox()->name('publiziert')->value("Publiziert");
//}
echo $button->start($lblClass, $eltClass);
echo $button->label('Speichern')->name('send')->type('submit')->class('btn-default');
echo $button->end();
echo $form->end();
echo "<br>";
?>