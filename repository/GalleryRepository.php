<?php
require_once '../lib/Repository.php';
require_once 'PictureRepository.php';

    class GalleryRepository extends Repository
    {
        protected $tableName = 'galerie';
        protected $tableId = 'gid';

        public function create($kid, $gname, $publiziert){

            $query = "INSERT INTO $this->tableName (kid, name, publiziert) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isb', $kid, $gname, $publiziert);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

        public function updateGallery($kid, $gid, $gname, $publiziert){

            $query = "UPDATE $this->tableName SET $gname, $publiziert WHERE gid = ? and kid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('iisb', $gid, $kid, $gname, $publiziert);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

        public function readByIdAndKid($kid, $gid){

            $query = "SELECT * FROM $this->tableName WHERE gid = ? AND kid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $gid, $kid);
            $statement->execute();

            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }

            $row = $result->fetch_object();

            return $row;
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

        public function deleteByIdAndKid($gid, $kid){

            $query = "DELETE FROM $this->tableName WHERE (gid, kid) = (?,?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $gid, $kid);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }
        }
    }
?>