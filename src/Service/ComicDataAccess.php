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
        $success = parent::executeSQL(
            "INSERT INTO comics (title, description , price, publisher, image, release_date, stock, author) 
                    VALUES (:title, :description, :price, :publisher, :image, :release_date, :stock, :author);", [
                "title" => $comic->getTitle(),
                "description" => $comic->getDescription(),
                "price" => $comic->getPrice(),
                "publisher" => $comic->getPublisher(),
                "image" => is_null($image = $comic->getImage()) ? null : FileUtils::imageFileToBinary($image),
                "release_date" => $comic->getReleaseDate()->format('Y/m/d'),
                "stock" => $comic->getStock(),
                "author" => $comic->getAuthor(),
            ]
        );

        $genres = explode(';', $comic->getGenre());
        foreach ($genres as $genre) {
            $success2 = parent::executeSQL(
                "INSERT INTO comics_tags (comic_id, name) VALUES ((SELECT MAX(id) FROM comics), :genre);", [
                    "genre" => $genre,
                ]
            );
            $success = ($success and $success2);
        }
        return $success;
    }

    public function editComic(Comic $comic, $id) {
        $params = [
            "title" => $comic->getTitle(),
            "description" => $comic->getDescription(),
            "price" => $comic->getPrice(),
            "publisher" => $comic->getPublisher(),
            "author" => $comic->getAuthor(),
            "release_date" => $comic->getReleaseDate()->format('Y/m/d'),
            "stock" => $comic->getStock(),
            "id" => $id,
        ];

        if(is_null($comic->getImage())){
            $sql = "UPDATE comics SET title = :title, description = :description, price = :price,
                  publisher = :publisher, author = :author, release_date = :release_date, 
                  stock = :stock WHERE id = :id;";
        } else {
            $sql = "UPDATE comics SET title = :title, description = :description, price = :price,
                  publisher = :publisher, author = :author, release_date = :release_date, 
                  image =:image, stock = :stock WHERE id = :id;";
            $params["image"] = FileUtils::imageFileToBinary($comic->getImage());
        }
        $success = parent::executeSQL(
            $sql, $params
        );

        parent::executeSQL(
            "DELETE FROM comics_tags WHERE comic_id = :id;", [
                "id" => $id,
            ]
        );

        $genres = explode(';', $comic->getGenre());
        foreach ($genres as $genre) {
            $success2 = parent::executeSQL(
                "INSERT INTO comics_tags (comic_id, name) VALUES (:id, :genre);", [
                    "genre" => $genre,
                    "id" => $id,
                ]
            );
            $success = ($success and $success2);
        }

        return $success;
    }

    public function getTags() {
        return parent::executeSQL(
            "SELECT * FROM tags;"
        )->fetchAll();
    }

    public function getComicsWithTag($tag) {
        return parent::executeSQL(
            "SELECT * FROM comics WHERE id IN (SELECT comic_id FROM comics_tags WHERE name = :tag);", [
                "tag" => $tag
            ]
        )->fetchAll();
    }

    public function getTagsFromComic($id) {
        return parent::executeSQL(
            "SELECT name FROM comics_tags WHERE comic_id = :id;", [
                "id" => $id
            ]
        )->fetchAll();
    }

    public function search($comic_title) {
        return parent::executeSQL("SELECT * FROM comics WHERE title LIKE (:comic_title)", [
            "comic_title" => '%'.$comic_title.'%',
        ])->fetchAll();
    }
}
