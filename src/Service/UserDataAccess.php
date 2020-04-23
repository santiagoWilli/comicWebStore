<?php


namespace App\Service;


use App\Entity\User;

class UserDataAccess extends DataAccess
{
    public function getUserById($id) {
        return parent::executeSQL(
            "SELECT * FROM usuarios WHERE id = :id;", [
                "id" => $id
            ])->fetch();
    }

    public function getAllUsers() {
        return parent::executeSQL(
            "SELECT * FROM usuarios;"
        )->fetchAll();
    }

    public function addUser(User $user) {
        return parent::executeSQL(
            "INSERT INTO usuarios (name, last_name, category, role, profile_picture, password, birth_date, email) 
                    VALUES (:name, :lastName, :category, :role, :picture, :password, :birthDate, :email);", [
                "name" => $user->getName(),
                "lastName" => $user->getLastName(),
                "category" => $user->getCategory(),
                "role" => $user->getRole(),
                "picture" => is_null($image = $user->getProfilePicture()) ? null : self::imageFileToBinary($image),
                "password" => $user->getPassword(),
                "birthDate" => $user->getBirthDate()->format('Y/m/d'),
                "email" => $user->getEmail(),
            ]
        );
    }

    public function deleteUser($id) {
        return parent::executeSQL(
            "DELETE FROM usuarios where id = :id;",
            [
                "id" => $id
            ]
        );
    }

    private static function imageFileToBinary($file) {
        $strm = fopen($file->getRealPath(),'rb');
        return stream_get_contents($strm);
    }
}