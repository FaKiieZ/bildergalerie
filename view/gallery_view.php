<?php
$gid = $_GET['gid'];
if ($isOwner) {
    echo '<div class="btn-group">';
    echo '<a class="btn btn-danger" href="' . $GLOBALS["appurl"] . '/gallery/deleteGallery?gid=' . $gid . '">Galerie löschen</a>';
    echo '<a class="btn btn-default" href="' . $GLOBALS["appurl"] . '/gallery/editGallery?gid=' . $gid . '">Galerie bearbeiten</a>';
    echo '</div>';
}

echo '<div style="width: 100%; max-width: 90%;">';
if (isset($data) && count($data) > 0){
    foreach ($data as $picture) {
        echo '<div class="col-md-4">';
        echo '<a class="col-md-4" data-lightbox="eis" href="../var/www/uploads/' . $picture->pathName . '" >';
        echo '<img class="thumbnail" src="../var/www/uploads/thumbnails/thumb' . $picture->pathName . '" />';
        echo '</a>';
        if ($isOwner) {
            echo '<div class="btn-group picture-btn-group">';
            echo "<a class='btn btn-danger pictureDeleteButton' href='" . $GLOBALS['appurl'] . "/picture/delete?bid=" . $picture->bid . "&gid=" . $gid . "'><i class='glyphicon glyphicon-trash'></i></a>";
            echo "<a class='btn btn-primary pictureDeleteButton' href='" . $GLOBALS['appurl'] . "/picture/edit?bid=" . $picture->bid . "&gid=" . $gid . "'><i class='glyphicon glyphicon-pencil'></i></a>";
            echo "</div>";
        }
        echo "<span class='picture-name' title='$picture->name'>$picture->name</span>";
        echo '</div>';
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>