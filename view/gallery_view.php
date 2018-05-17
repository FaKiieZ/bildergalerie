<?php
if (isset($data) && count($data) > 0){
    foreach ($data as $picture) {
        echo '<div class="col-md-4">';
        echo '<img class="thumbnail" style="object-fit: cover; width:230px; height:230px;" src="../var/www/uploads/' . $picture->name . '" />';
        echo '</div>';
    }
}else{
    echo "<h5>Keine Einträge vorhanden.</h5>";
}
?>
<br>