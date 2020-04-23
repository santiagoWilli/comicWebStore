<?php


namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;

class User
{
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
    private $category;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $password;

    /**
     * @Assert\Length(max=64)
     */
    private $email;


    private $birthDate;

    /**
     * @Assert\Image(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid png, jpg or jpeg image"
     * )
     */
    private $profilePicture;

    /**
     * User constructor.
     * @param $name
     * @param $lastName
     * @param $role
     * @param $category
     * @param $password
     * @param $email
     * @param $birthDate
     * @param $profilePicture
     */

    public function __construct($name = null, $lastName = null, $role = null, $category = null, $password = null, $email = null, $birthDate = null, $profilePicture = null)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->category = $category;
        $this->password = $password;
        $this->email = $email;
        try {
            $this->birthDate = new DateTime($birthDate);
        } catch (Exception $e) {
        }
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param mixed $profilePicture
     */
    public function setProfilePicture($profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }


}