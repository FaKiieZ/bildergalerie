<?php
require_once '../lib/Repository.php';
/**
 * Datenbankschnittstelle für die Benutzer
 */
  class UserRepository extends Repository
  {
      protected $tableName = 'kunde';
      protected $tableId = 'kid';
      
      // Erstellt einen neuen User in der Datenbank
      public function create($benutzername, $passwort, $email) {
          $passwort = sha1 ( $passwort ); // hashed das Passwort

          $query = "INSERT INTO $this->tableName (benutzername, passwort, email) VALUES (?, ?, ?)";

          $statement = ConnectionHandler::getConnection ()->prepare ( $query );
          $statement->bind_param ( 'sss', $benutzername, $passwort, $email);

          if (! $statement->execute ()) {
              throw new Exception ( $statement->error );
          }

          return $statement->insert_id;
      }
      /**
       * Überprüft ob der Username schon besteht
       * @param unknown $name
       * @return boolean
       */	public function userAlreadyExistsByName($benutzername) {
      $query = "SELECT * FROM $this->tableName WHERE benutzername = ?";

      $statement = ConnectionHandler::getConnection ()->prepare ( $query );
      $statement->bind_param ( 's', $benutzername );

      $statement->execute ();

      $result = $statement->get_result ();

      return $result->num_rows >= 1;
  }

      /**
       * Überprüft ob die Email schon besteht
       * @param unknown $email
       * @return boolean
       */
      public function userAlreadyExistsByEmail($email) {
          $query = "SELECT * FROM $this->tableName WHERE email = ?";

          $statement = ConnectionHandler::getConnection ()->prepare ( $query );
          $statement->bind_param ( 's', $email );

          $statement->execute ();

          $result = $statement->get_result ();

          return $result->num_rows >= 1;
      }

      public function getByName($benutzername) {
          $query = "SELECT id FROM $this->tableName WHERE benutzername = ?";

          $statement = ConnectionHandler::getConnection ()->prepare ( $query );
          $statement->bind_param ( 's', $benutzername );

          if (! $statement->execute ()) {
              throw new Exception ( $statement->error );
          }
          else {

              $result = $statement->get_result ();

              if ($result->num_rows == 0) {

                  $view = new View ( 'message' );
                  $view->title = 'Message';
                  $view->heading = 'Message';
                  $view->message = "Something went wrong!";
                  $view->display ();
              } else {

                  return $result->fetch_object ()->id;
              }
          }
      }

      // liest die user_id von einem User aus dessen Name und Passwort übereinstimmen
      public function getByNamePassword($benutzername, $password) {
          $password = sha1 ( $password ); // Turns password into hash

          $query = "SELECT id FROM $this->tableName WHERE name = ? AND password = ?";

          $statement = ConnectionHandler::getConnection ()->prepare ( $query );
          $statement->bind_param ( 'ss', $benutzername, $password );

          if (! $statement->execute ()) {
              throw new Exception ( $statement->error );
          }
          else {

              $result = $statement->get_result ();

              if ($result->num_rows == 0) {

                  return false;
              } else {

                  return $result->fetch_object ()->id;
              }
          }
      }
  }
?>