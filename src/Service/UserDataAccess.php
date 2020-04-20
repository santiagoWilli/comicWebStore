<?php


namespace App\Service;


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
}