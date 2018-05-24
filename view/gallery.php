<?php
if (isset($data) && count($data) > 0){
    foreach ($data as $gallery) {
        echo "<a href='" . $GLOBALS['appurl'] . "/gallery/showById?gid=$gallery->gid'>";
        echo '<div class="col-md-4 gallery">';

        if (isset($gallery->firstPictureName)) {
            echo '<img class="thumbnail" src="var/www/uploads/' . $gallery->firstPictureName . '" />';
        }else{
            echo '<img class="thumbnail" src="var/www/default/gallery.jpg" />';
        }

        echo "<h5 style='text-align: center'>$gallery->name</h5>";
        echo "</div></a>";
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>
