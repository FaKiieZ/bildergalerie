<a class="btn btn-default" href="<?php echo $GLOBALS['appurl']?>/gallery/createGallery" > Erstelle Galerie </a>
<?php
    foreach ($data as $gallery) {
        echo "<div>";
        echo $gallery->name;
        echo "<div>";
    }
?>