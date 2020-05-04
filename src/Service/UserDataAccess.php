<?php


namespace App\Service;


use App\Entity\User;

class UserDataAccess extends DataAccess
{
    public function getUserById($id) {
        return parent::executeSQL(
            "SELECT * FROM users WHERE id = :id;", [
                "id" => $id
            ])->fetch();
    }

    public function getAllUsers() {
        return parent::executeSQL(
            "SELECT * FROM users;"
        )->fetchAll();
    }

    public function addUser(User $user) {
        return parent::executeSQL(
            "INSERT INTO users (name, last_name, role, profile_picture, password, birth_date, email) 
                    VALUES (:name, :lastName, :role, :picture, :password, :birthDate, :email);", [
                "name" => $user->getName(),
                "lastName" => $user->getLastName(),
                "role" => $user->getRole(),
                "picture" => is_null($image = $user->getProfilePicture()) ? null : FileUtils::imageFileToBinary($image),
                "password" => $user->getPassword(),
                "birthDate" => $user->getBirthDate()->format('Y/m/d'),
                "email" => $user->getEmail(),
            ]
        );
    }

    public function editUser(User $user, $id) {
        $params = [
            "name" => $user->getName(),
            "lastName" => $user->getLastName(),
            "role" => $user->getRole(),
            "password" => $user->getPassword(),
            "birthDate" => $user->getBirthDate()->format('Y/m/d'),
            "email" => $user->getEmail(),
            "id" => $id,
        ];

        if(is_null($user->getProfilePicture())){
            $sql = "UPDATE users SET name = :name, last_name = :lastName, role = :role,
                  password = :password, birth_date = :birthDate, email = :email WHERE id = :id;";
        } else {
            $sql = "UPDATE users SET name = :name, last_name = :lastName, role = :role, 
                    profile_picture = :picture, password = :password, birth_date = :birthDate, email = :email WHERE id = :id;";
            $params["picture"] = FileUtils::imageFileToBinary($user->getProfilePicture());
        }
        return parent::executeSQL(
            $sql, $params
        );
    }

    public function deleteUser($id) {
        return parent::executeSQL(
            "DELETE FROM users where id = :id;",
            [
                "id" => $id
            ]
        );
    }
}