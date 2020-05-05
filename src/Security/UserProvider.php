<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function loadUserByUsername($username)
    {
        return $this->getUser($username);
    }

    private function getUser($username)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        try {
            $stmt = $this->connection->prepare($sql);
        } catch (DBALException $e) {
        }
        $stmt->bindValue("email", $username);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row)
        {
            $exception = new UsernameNotFoundException(sprintf('Usuario "%s" no encontrado en la base de datos.', $username));
            $exception->setUsername($username);
            throw $exception;
        }
        else
        {
            return new User($row["name"], $row["last_name"], $row["role"],
                $row["password"], $row["email"], $row["birth_date"]);
        }
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->getUser($user->getUsername());
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
