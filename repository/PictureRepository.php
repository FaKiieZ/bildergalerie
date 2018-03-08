<?php

require_once '../lib/Repository.php';
require_once '../repository/UserLikesPictureRepository.php';

function cmp($a, $b) {
    if ($a->likesCount == $b->likesCount) {
        return 0;
    }
    return ($a->likesCount > $b->likesCount) ? -1 : 1;
}

class PictureRepository extends Repository
{
    protected $tableName = 'picture';

    // Foto hochladen
    public function doUpload($pictureName, $userId)
    {    	
        $query = "INSERT INTO $this->tableName (name, user_id) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si', $pictureName, $userId);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    // Fotos für den Feed laden
    public function readFeed($userId)
    {
        $userLikesPictureRepository = new UserLikesPictureRepository();

        $query = "SELECT u.id as userId, u.username, u.profile_picture, p.id, p.name, p.upload_date FROM user_follows_user ufu
            LEFT JOIN picture AS p ON p.user_id = ufu.user2_id
            LEFT JOIN user AS u ON u.id = ufu.user2_id
            WHERE ufu.user1_id = ? AND p.id IS NOT NULL
            ORDER BY p.upload_date DESC;";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        foreach($rows as $row){
            $row->isLiked = $userLikesPictureRepository->isLiked($row->id, $userId);
            $row->likesCount = $userLikesPictureRepository->likesCount($row->id);
        }

        return $rows;
    }

    // Fotos für Hot laden
    public function readHot($userId)
    {
        $userLikesPictureRepository = new UserLikesPictureRepository();

        $query = "SELECT u.id as userId, u.username, u.profile_picture, p.id, p.name, p.upload_date FROM $this->tableName p
            LEFT JOIN user AS u ON u.id = p.user_id";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        foreach($rows as $row){
            $row->isLiked = $userLikesPictureRepository->isLiked($row->id, $userId);
            $row->likesCount = $userLikesPictureRepository->likesCount($row->id);
        }

        //var_dump($rows);
        uasort($rows, 'cmp');

        return $rows;
    }

    // Fotos fürs Profil laden
    public function readAllByUserId($userId, $sessionUserId){
        $userLikesPictureRepository = new UserLikesPictureRepository();

        $query = "SELECT id, name, upload_date FROM $this->tableName WHERE user_id = ? ORDER BY upload_date DESC";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $userId);
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

        foreach($rows as $row){
            $row->isLiked = $userLikesPictureRepository->isLiked($row->id, $sessionUserId);
            $row->likesCount = $userLikesPictureRepository->likesCount($row->id);
        }

        return $rows;
    }
}
