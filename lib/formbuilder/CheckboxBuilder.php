<?php
  /**
   * Erstellt ein Input-Feld für ein Formular.
   * Der Typ ist beliebig (text, email, password), nur 1 Feld pro Zeile.
   */
  class CheckboxBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('name');
      $this->addProperty('value', null);
    }
    public function build()
    {
      $result = "<div class='form-group'>\n";
      $result .= "<label class='col-md-2 control-label'>{$this->value}</label>\n";
      $result .= "<input style='margin-left: 15px; margin-top: 10px;' type='checkbox' name='{$this->name}'>\n";
      $result .= "</div>\n";
      return $result;
    }
  }
?>