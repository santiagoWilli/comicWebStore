<?php


namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $id;

    /**
     * @var array
     * ROLE_ADMIN       Puede hacer cualquier acción.
     * ROLE_USER        Usuarios autenticados de la aplicación.
     */
    private const ROLES = [
        1 => "ROLE_ADMIN",
        4 => "ROLE_USER",
    ];

    private $roles = [];

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
     * @Assert\Positive()
     */
    private $role;

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

    public function __construct($name = null, $lastName = null, $role = null, $password = null, $email = null, $birthDate = null, $profilePicture = null)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->password = $password;
        $this->email = $email;
        try {
            $this->birthDate = new DateTime($birthDate);
        } catch (Exception $e) {
        }
        $this->profilePicture = $profilePicture;

        if($role == null) return;
        $this->roles[] = 'ROLE_USER';
        $this->roles[] = self::ROLES[$role];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * User constructor.
     * @param $name
     * @param $lastName
     * @param $role
     * @param $password
     * @param $email
     * @param $birthDate
     * @param $profilePicture
     */

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

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}