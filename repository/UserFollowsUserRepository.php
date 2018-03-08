<?php

require_once '../lib/Repository.php';

class UserFollowsUserRepository extends Repository
{
    protected $tableName = 'user_follows_user';

    public function readFollowersCount($userId){
        $query = "SELECT COUNT(*) as followersCount FROM $this->tableName WHERE user2_id = ?;";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $object = $result->fetch_object();
        return $object->followersCount;
    }

    public function isFollowing($user1Id, $user2Id){
        $query = "SELECT * FROM $this->tableName WHERE user1_id = ? AND user2_id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $user1Id, $user2Id);
        $statement->execute();

        $result = $statement->get_result();
        $object = $result->fetch_object();

        if ($object !== null){
            return true;
        }else{
            return false;
        }
    }

    public function follow($user1Id, $user2Id){
        if (!$this->isFollowing($user1Id, $user2Id) && $user1Id != $user2Id){
            $query = "INSERT INTO $this->tableName(user1_id, user2_id) VALUES (?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $user1Id, $user2Id);
    
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }
        }else{
            $query = "DELETE FROM $this->tableName WHERE user1_id = ? AND user2_id = ?";
            
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ii', $user1Id, $user2Id);
            
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }
        }
    }
}