<?php
$gid = $_GET['gid'];
$lblClass = "col-md-1";
$eltClass = "col-md-1";
$btnClass = "btn btn-danger";
$form = new Form($GLOBALS['appurl']."/gallery/deleteGallery?gid=$gid");
$button = new ButtonBuilder();
echo $button->start($lblClass, $eltClass);
echo $button->label('Galerie löschen')->name('deleteGallery')->type('submit')->class('btn-danger');
echo $button->end();
echo $form->end();

echo '<div style="width: 100%; max-width: 90%;">';
if (isset($data) && count($data) > 0){
    echo '<div style="max-width: 90%;">';
    foreach ($data as $picture) {
        echo '<a class="thumbnail col-md-4" data-lightbox="eis" style="object-fit: cover; width:230px; height:230px;" href="../var/www/uploads/' . $picture->name . '" />';
    }
    echo "</div>";
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
echo "</div>";
?>
<br>
