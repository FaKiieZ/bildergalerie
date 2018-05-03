<?php
require_once '../lib/Repository.php';

    class GalleryRepository extends Repository
    {
        protected $tableName = 'galerie';

        public function create($kid, $gname, $publiziert){

            $query = "INSERT INTO $this->tableName (kid, name, publiziert) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isb', $kid, $gname, $publiziert);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

    }
?>