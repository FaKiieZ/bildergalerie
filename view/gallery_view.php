<?php
$gid = $_GET['gid'];
echo '<a class="btn btn-danger" href="' . $GLOBALS["appurl"] . '/gallery/deleteGallery?gid=' . $gid . '">Galerie löschen</a>';
echo '<a class="btn btn-danger" href="' . $GLOBALS["appurl"] . '/gallery/editGallery?gid=' . $gid . '">Galerie bearbeiten</a>';

echo '<div style="width: 100%; max-width: 90%;">';
if (isset($data) && count($data) > 0){
    foreach ($data as $picture) {
        echo '<div class="col-md-4">';
        echo '<a class="col-md-4" data-lightbox="eis" href="../var/www/uploads/' . $picture->name . '" >';
        echo '<img class="thumbnail" src="../var/www/uploads/' . $picture->name . '" />';
        echo "<a style='position: absolute; bottom: 0' class='btn btn-danger' href='" . $GLOBALS['appurl'] . "/picture/delete?bid=" . $picture->bid . "&gid=" . $gid . "'>Löschen</a>";
        echo '</a></div>';
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>