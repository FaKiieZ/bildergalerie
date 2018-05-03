<?php
require_once "../repository/GalleryRepository.php";

/**
 * Erstellt ein Input-Feld für ein Formular.
 * Der Typ ist beliebig (text, email, password), nur 1 Feld pro Zeile.
 */
class DropdownBuilder extends Builder
{
    public function __construct()
    {
        $this->addProperty('name');
        $this->addProperty('label', null);
    }
    public function build()
    {
        $galleryRepository = new GalleryRepository();

        $data = $galleryRepository->readAll();

        $result = "<div class='form-group'>\n";
        $result .= "<label class='col-md-2 control-label'>{$this->label}</label>\n";
        $result .= "<select name='test'>\n";
        foreach ($data as $gallery) {
            $result .= "<option value='$gallery->gid'>$gallery->name</option>\n";
        }
        $result .= "</select>\n";
        $result .= "</div>\n";
        return $result;
    }
}
?>