<?php
require_once '../lib/Repository.php';

    class GalleryRepository extends Repository
    {

        protected $tableName = 'galerie';

        public function create($kid, $gname ){

            $query = "INSERT INTO $this->tableName (kid, gname, published) VALUES (?, ?, FALSE)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isi', $kid, $gname);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

    }
?>