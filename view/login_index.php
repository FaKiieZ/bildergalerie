<?php
    // Falls vom Controller ein Error kommt, wird eine Fehlermeldung ausgegeben.
    if(isset($error) && $error){
        echo('<div class="alert alert-danger"><strong>Error!</strong> Benutzername oder Passwort falsch!
        </div>');
    }
    // Kontrolliert ob eine gültige Session aktiv ist.
    if(isset($_SESSION['besucht']) && $_SESSION['besucht'] == true){
        header("Location: " .$GLOBALS['appurl']);
        exit;
    }

    /**
    * Login-Formular
    * Das Formular wird mithilfe des Formulargenerators erstellt.
    */
    $lblClass = "col-md-2";
    $eltClass = "col-md-4";
    $btnClass = "btn btn-success";
    $form = new Form($GLOBALS['appurl']."/login/doLogin");
    $button = new ButtonBuilder();
    echo $form->input()->label('E-Mail')->name('email')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $form->input()->label('Passwort')->name('passwort')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $button->start($lblClass, $eltClass);
    echo $button->label('Login')->name('send')->type('submit')->class('btn-success');
    echo $button->end();
    echo $form->end();
?>
