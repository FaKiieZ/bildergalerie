<?php

require_once '../lib/Repository.php';

class PictureRepository extends Repository
{
    protected $tableName = 'bild';
    protected $tableId = 'bid';

    // Foto hochladen
    public function doUpload($pictureName, $userId, $galleryId, $name)
    {
        $query = "INSERT INTO $this->tableName (pathName, name, kid, gid) VALUES (?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssii', $pictureName, $name, $userId, $galleryId);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    public function readAllByGalleryId($gid){
        $query = "SELECT bid, name, pathName FROM $this->tableName WHERE gid = ?";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $gid);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result){
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function readFirstPictureOfGallery($gid){
        $query = "SELECT * FROM $this->tableName WHERE gid = ? LIMIT 1";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $gid);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $picture = $result->fetch_object();

        return $picture;
    }

    public function readByIdAndKid($kid, $bid){

        $query = "SELECT * FROM $this->tableName WHERE bid = ? AND kid = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $bid, $kid);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $row = $result->fetch_object();

        return $row;
    }

    public function update($bid, $userId, $name)
    {
        $query = "UPDATE $this->tableName SET name = ? WHERE bid = ? AND kid = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sii', $name, $bid, $userId);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
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
