<?php


namespace App\Service;


use App\Entity\User;

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

    private static function imageFileToBinary($file) {
        $strm = fopen($file->getRealPath(),'rb');
        return stream_get_contents($strm);
    }
}