<?php
    $lblClass = "col-md-2";
    $eltClass = "col-md-4";
    $form = new Form($GLOBALS['appurl']."/gallery/doCreate");
    $button = new ButtonBuilder();
    echo "<br>";
    echo $form->input()->label('Name der Galerie')->name('galleryName')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $form->checkbox()->name('publiziert')->value("Publiziert");
    echo $button->start($lblClass, $eltClass);
    echo $button->label('Erstellen')->name('send')->type('submit')->class('btn-default');
    ?>


<?php
    echo $button->end();
    echo $form->end();
    echo "<br>";
?>
