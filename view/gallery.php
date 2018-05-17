<?php
if (isset($data) && count($data) > 0){
    foreach ($data as $gallery) {
        echo '<div class="col-md-4">';
        echo "<a href='" . $GLOBALS['appurl'] . "/gallery/showById?gid=$gallery->gid'><h5>$gallery->name</h5></a>";
        echo "</div>";
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>
