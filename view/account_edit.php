<?php
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl']."/account/doSave");
$button = new ButtonBuilder();
if (isset($message)) {
    echo "<div class='alert alert-danger'>";
    echo "<strong>Achtung!</strong> $message";
    echo "</div>";
}
echo $form->input()->label('E-Mail')->name('email')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($konto->email);
echo $form->input()->label('Username')->name('username')->type('text')->lblClass($lblClass)->eltClass($eltClass)->value($konto->benutzername);
echo $form->input()->label('Neues Passwort')->name('password')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Neues Passwort bestätigen')->name('passwordbestätigt')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $button->start($lblClass, $eltClass);
echo $button->label('Speichern')->name('send')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();

?>
