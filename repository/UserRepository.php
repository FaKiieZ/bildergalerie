<?php

require_once '../lib/Repository.php';
require_once '../repository/PictureRepository.php';
require_once '../repository/UserFollowsUserRepository.php';

class UserRepository extends Repository
{
    protected $tableName = 'user';

    public function create($username, $password, $email, $status)
    {
        $password = sha1($password);
        
        $query = "INSERT INTO $this->tableName (username, password, email, status) VALUES (?, ?, ?, ?)";
        
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssss', $username, $password, $email, $status);
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        
        return $statement->insert_id;
    }

    public function readProfile($userId, $sessionUserId){
        // get user
        $query = "SELECT id, username, status, profile_picture FROM $this->tableName WHERE id = ?;";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $user = $result->fetch_object();

        $profile = new stdClass();
        $profile->id = $user->id;
        $profile->username = $user->username;
        $profile->status = $user->status;
        $profile->profile_picture = $user->profile_picture;

        // get pictures from user
        $pictureRepository = new PictureRepository();

        $profile->pictures = $pictureRepository->readAllByUserId($userId, $sessionUserId);

        // get follows
        $userFollowsUserRepository = new UserFollowsUserRepository();

        $profile->followersCount = $userFollowsUserRepository->readFollowersCount($userId);

        $profile->isFollowing = $userFollowsUserRepository->isFollowing($sessionUserId, $userId);

        return $profile;
    }

    public function readSettingsProfile($userId){
        // get user
        $query = "SELECT id, username, status, profile_picture FROM $this->tableName WHERE id = ?;";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        return $result->fetch_object();
    }

    public function readByKeyword($keyword){
        $keyword = "%$keyword%";
        $query = "SELECT id, username, status, profile_picture FROM user
            WHERE username LIKE ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $keyword);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $userFollowsUserRepository = new UserFollowsUserRepository();

        $rows = array();
        while ($row = $result->fetch_object()) {
            $row->followersCount = $userFollowsUserRepository->readFollowersCount($row->id);
            $rows[] = $row;
        }

        return $rows;
    }

    public function updateProfile($id, $status){
        $query = "UPDATE $this->tableName
            SET status = ?
            WHERE id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si', $status, $id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    public function updateProfilePicture($id, $profilePicture){
        $query = "UPDATE $this->tableName
            SET profile_picture = ?
            WHERE id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si', $profilePicture, $id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }
}
