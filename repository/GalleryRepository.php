<?php
require_once '../lib/Repository.php';
require_once 'PictureRepository.php';

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

        public function readAllWithFirstPicture()
        {
            $query = "SELECT * FROM $this->tableName";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->execute();

            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }

            // Datensätze aus dem Resultat holen und in das Array $rows speichern
            $rows = array();
            while ($row = $result->fetch_object()) {
                $pictureRepository = new PictureRepository();

                $picture = $pictureRepository->readFirstPictureOfGallery($row->gid);

                if ($picture != null){
                    $row->firstPictureName = $picture->name;
                }

                $rows[] = $row;
            }
            return $rows;
        }
    }
?>