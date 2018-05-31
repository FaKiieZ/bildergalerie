<?php

require_once '../lib/Repository.php';

class PictureRepository extends Repository
{
    protected $tableName = 'bild';
    protected $tableId = 'bid';

    // Foto hochladen
    public function doUpload($pictureName, $userId, $galleryId)
    {    	
        $query = "INSERT INTO $this->tableName (name, kid, gid) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sii', $pictureName, $userId, $galleryId);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    public function readAllByGalleryId($gid, $kid){
        $query = "SELECT bid, name FROM $this->tableName WHERE gid = ? AND kid = ?";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $gid, $kid);
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
}
