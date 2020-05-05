<?php


namespace App\Service;


use App\Entity\Comic;

class ComicDataAccess extends DataAccess
{
    public function getComicById($id) {
        return parent::executeSQL(
            "SELECT * FROM comics WHERE id = :id;", [
            "id" => $id
        ])->fetch();
    }

    public function getAllComics() {
        return parent::executeSQL(
            "SELECT * FROM comics;"
        )->fetchAll();
    }

    public function deleteComic($id) {
        return parent::executeSQL(
            "DELETE FROM comics where id = :id;",
            [
                "id" => $id
            ]
        );
    }

}