<?php
$gid = $_GET['gid'];
echo '<a class="btn btn-danger" href="' . $GLOBALS["appurl"] . '/gallery/deleteGallery?gid=' . $gid . '">Galerie löschen</a>';

echo '<div style="width: 100%; max-width: 90%;">';
if (isset($data) && count($data) > 0){
    foreach ($data as $picture) {
        echo '<a class="thumbnail col-md-4" data-lightbox="eis" href="../var/www/uploads/' . $picture->name . '" >';
        echo '<div class="col-md-4">';
        echo '<img class="thumbnail" style="object-fit: cover; width:230px; height:230px;" src="../var/www/uploads/' . $picture->name . '" />';
        echo '</div></a>';
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>