<?php

require_once '../lib/Repository.php';

class UserLikesPictureRepository extends Repository
{
    protected $tableName = 'user_likes_picture';

    public function isLiked($pictureId, $userId){
        $query = "SELECT * FROM $this->tableName WHERE picture_id = ? AND user_id = ?";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $pictureId, $userId);
        $statement->execute();
        
        $result = $statement->get_result();
        $object = $result->fetch_object();

        if ($object !== null){
            return true;
        }else{
            return false;
        }
    }   

    public function like($pictureId, $userId){
        if (!$this->isLiked($pictureId, $userId)){
            $query = "INSERT INTO $this->tableName (user_id, picture_id) VALUES(?, ?)";
        
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $userId, $pictureId);
            
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }
        }else{
            $query = "DELETE FROM $this->tableName WHERE user_id = ? AND picture_id = ?";
            
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $userId, $pictureId);
            
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }
        }
    }

    public function likesCount($pictureId){
        $query = "SELECT COUNT(p.id) AS likesCount FROM $this->tableName ulp
            LEFT JOIN picture AS p ON p.id = ulp.picture_id
            WHERE p.id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $pictureId);
        $statement->execute();

        $result = $statement->get_result();
        $object = $result->fetch_object();

        if ($object != null){
            return $object->likesCount;
        }else{
            return 0;
        }
    }
}