<?php
require_once '../lib/Repository.php';

    class GalleryRepository extends Repository
    {

        protected $tableName = 'galerie';

        public function create($kid, $gname, $published ){

            $query = "INSERT INTO $this->tableName (kid, beschreibung, published) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('iss', $kid, $gname, $published);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

    }
?>