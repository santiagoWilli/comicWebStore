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

    public function editComic(Comic $comic, $id) {
        $params = [
            "title" => $comic->getTitle(),
            "description" => $comic->getDescription(),
            "price" => $comic->getPrice(),
            "publisher" => $comic->getPublisher(),
            "genre" => $comic->getGenre(),
            "author" => $comic->getAuthor(),
            "release_date" => $comic->getReleaseDate()->format('Y/m/d'),
            "stock" => $comic->getStock(),
            "id" => $id,
        ];

        if(is_null($comic->getImage())){
            $sql = "UPDATE comics SET title = :title, description = :description, price = :price,
                  publisher = :publisher, genre = :genre, author = :author, release_date = :release_date, 
                  stock = :stock WHERE id = :id;";
        } else {
            $sql = "UPDATE comics SET title = :title, description = :description, price = :price,
                  publisher = :publisher, genre = :genre, author = :author, release_date = :release_date, 
                  image =:image, stock = :stock WHERE id = :id;";
            $params["image"] = FileUtils::imageFileToBinary($comic->getImage());
        }
        return parent::executeSQL(
            $sql, $params
        );
    }
}
