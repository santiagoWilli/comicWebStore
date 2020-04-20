<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=32)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=64)
     */
    private $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=32)
     */
    private $role;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=32)
     */
    private $categoy;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $password;

    /**
     * @Assert\Length(max=255)
     */
    private $email;

    /**
     * @Assert\Date()
     */
    private $birthDate;

    /**
     * @Assert\Image(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid png, jpg or jpeg image"
     * )
     */
    private $profilePicture;
}