<?php
    $lblClass = "col-md-2";
    $eltClass = "col-md-4";
    $btnClass = "btn btn-success";
    $form = new Form($GLOBALS['appurl']."/login/createUser");
    $button = new ButtonBuilder();
    if (isset($message)) {
        echo "<div class='alert alert-danger'>";
        echo "<strong>Achtung!</strong> $message";
        echo "</div>";
    }
    echo $form->input()->label('E-Mail')->name('email')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $form->input()->label('Username')->name('username')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $form->input()->label('Passwort')->name('password')->type('password')->lblClass($lblClass)->eltClass($eltClass);
    echo $button->start($lblClass, $eltClass);
    echo $button->label('Registrieren')->name('send')->type('submit')->class('btn-success');
    echo $button->end();
    echo $form->end();
 
?>
