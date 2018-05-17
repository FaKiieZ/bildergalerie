<?php
if (isset($data) && count($data) > 0){
    echo '<div style="max-width: 90%;">';
    foreach ($data as $picture) {
        echo '<img class="thumbnail col-md-4" style="object-fit: cover; width:230px; height:230px;" src="../var/www/uploads/' . $picture->name . '" />';
        echo '<div class="col-sm-1"></div>';
    }
    echo '</div>';
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>
