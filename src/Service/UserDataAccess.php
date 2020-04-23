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

    public function editUser(User $user, $id) {
        $params = [
            "name" => $user->getName(),
            "lastName" => $user->getLastName(),
            "category" => $user->getCategory(),
            "role" => $user->getRole(),
            "password" => $user->getPassword(),
            "birthDate" => $user->getBirthDate()->format('Y/m/d'),
            "email" => $user->getEmail(),
            "id" => $id,
        ];

        if(is_null($user->getProfilePicture())){
            $sql = "UPDATE usuarios SET name = :name, last_name = :lastName, category = :category, role = :role,
                  password = :password, birth_date = :birthDate, email = :email WHERE id = :id;";
        } else {
            $sql = "UPDATE usuarios SET name = :name, last_name = :lastName, category = :category, role = :role, 
                    profile_picture = :picture, password = :password, birth_date = :birthDate, email = :email WHERE id = :id;";
            $params["picture"] = self::imageFileToBinary($user->getProfilePicture());
        }
        return parent::executeSQL(
            $sql, $params
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