<?php


namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;

class Comic
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=32)
     */
    private $title;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=500)
     */
    private $description;

    /**
     * @Assert\NotBlank
     */

    private $price;

    /**
     * @Assert\Length(max=32)
     */
    private $publisher;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=32)
     */
    private $genre;

    private $release_date;

    private $stock;

    /**
     * @Assert\Length(max=32)
     */
    private $author;

    /**
     * @Assert\Image(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid png, jpg or jpeg image"
     * )
     */
    private $image;

    /**
     * User constructor.
     * @param $title
     * @param $description
     * @param $price
     * @param $publisher
     * @param $genre
     * @param $release_date
     * @param $stock
     * @param $author
     * @param $image
     */

    public function __construct($title = null, $description = null, $price = null, $publisher = null,
                                $genre = null, $release_date = null, $stock = null,
                                $author = null, $image = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->publisher = $publisher;
        $this->genre = $genre;
        try {
            $this->release_date = new DateTime($release_date);
        } catch (Exception $e) {
        }
        $this->stock = $stock;
        $this->author = $author;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher): void
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * @param mixed $release_date
     */
    public function setReleaseDate($release_date): void
    {
        $this->release_date = $release_date;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

}