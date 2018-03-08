<?php

require_once '../lib/Repository.php';

class UserCommentsPictureRepository extends Repository
{
    protected $tableName = 'user_comments_picture';

    public function comment($pictureId, $userId, $comment){
        $query = "INSERT INTO $this->tableName (user_id, picture_id, comment) VALUES(?, ?, ?)";
    
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iis', $userId, $pictureId, $comment);
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }
}