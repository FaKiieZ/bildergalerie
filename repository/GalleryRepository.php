<?php
require_once '../lib/Repository.php';
require_once 'UserRepository.php';

    class GalleryRepository extends Repository
    {
        protected $tableName = 'galerie';
        protected $tableId = 'gid';

        public function create($kid, $gname, $publiziert){
            $isPublic = intval($publiziert);
            $query = "INSERT INTO $this->tableName (kid, name, publiziert) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isi', $kid, $gname, $isPublic);

            if (!$statement->execute()) {
                throw new Exception ($statement->error);
            }

            return $statement->insert_id;
        }

        public function updateGallery($kid, $gid, $gname, $publiziert){
            $isPublic = intval($publiziert);
            $query = "UPDATE $this->tableName SET name = ?, publiziert = ? WHERE gid = ? and kid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('siii', $gname, $isPublic, $gid, $kid);

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

        public function readAllWithFirstPictureByKid($kid)
        {
            $query = "SELECT * FROM $this->tableName WHERE kid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $kid);
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
                    $row->firstPictureName = $picture->pathName;
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

        public function readAllPublicWithFirstPicture(){
            $query = "SELECT * FROM $this->tableName WHERE publiziert = 1";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->execute();

            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }

            // Datensätze aus dem Resultat holen und in das Array $rows speichern
            $rows = array();
            while ($row = $result->fetch_object()) {
                $userRepository = new UserRepository();
                $pictureRepository = new PictureRepository();

                $user = $userRepository->readById($row->kid);
                $row->user = $user;

                $picture = $pictureRepository->readFirstPictureOfGallery($row->gid);
                if ($picture != null){
                    $row->firstPictureName = $picture->pathName;
                }

                $rows[] = $row;
            }
            return $rows;
        }

        public function readWithUserById($gid){
            $query = "SELECT * FROM $this->tableName WHERE publiziert = 1 AND gid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $gid);
            $statement->execute();

            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }

            // Datensätze aus dem Resultat holen und in das Array $rows speichern
            $row = $result->fetch_object();
            if ($row != null){
                $userRepository = new UserRepository();

                $user = $userRepository->readById($row->kid);
                $row->user = $user;
            }
            return $row;
        }

        public function deleteAllByKid($kid){
            $query = "DELETE FROM $this->tableName WHERE kid = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $kid);

            if (!$statement->execute()) {
                die($statement->error);
                throw new Exception($statement->error);
            }
        }
    }
?>