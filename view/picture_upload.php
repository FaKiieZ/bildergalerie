<?php
$lblClass = "col-md-2";
$eltClass = "col-md-4";

$gid = $_GET['gid'];
$button = new ButtonBuilder();

if($error){
    echo('<div class="alert alert-danger">Datei konnte nicht hochgeladen werden!</div>');
}
if($error === false){
    echo('<div class="alert alert-success">Datei wurde erfolgreich hochgeladen!</div>');
}
if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: " . $GLOBALS['appurl'] . "/login");
    die();
}

$form = new Form($GLOBALS['appurl']."/picture/upload?gid=$gid", "POST", "multipart/form-data");
?>
    <div class='form-group'>
        <label class='<?=$lblClass?> control-label'>Datei</label>
        <div class='<?=$eltClass?>'>
            <label class="btn btn-default">
                <input name="userfile" type="file" accept="image/*" />
            </label>
        </div>
    </div>
<?php
    echo $form->input()->label('Name')->name('pictureName')->type('text')->lblClass($lblClass)->eltClass($eltClass);
    echo $button->start($lblClass, $eltClass);
    echo $button->label('Bild hochladen')->name('send')->type('submit')->class('btn-default');
    echo $button->end();
    echo $form->end();
?>
