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

    public function addComic(Comic $comic) {
        return parent::executeSQL(
            "INSERT INTO comics (title, description , price, publisher, genre, image, release_date, stock, author) 
                    VALUES (:title, :description, :price, :publisher, :genre, :image, :release_date, :stock, :author);", [
                "title" => $comic->getTitle(),
                "description" => $comic->getDescription(),
                "price" => $comic->getPrice(),
                "publisher" => $comic->getPublisher(),
                "genre" => $comic->getGenre(),
                "image" => is_null($image = $comic->getImage()) ? null : FileUtils::imageFileToBinary($image),
                "release_date" => $comic->getReleaseDate()->format('Y/m/d'),
                "stock" => $comic->getStock(),
                "author" => $comic->getAuthor(),
            ]
        );
    }

}