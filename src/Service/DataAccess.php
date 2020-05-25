<?php


namespace App\Service;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

abstract class DataAccess
{
    private $connection;
    private $security;
    private $requestStack;

    public function __construct(Connection $connection, Security $security, RequestStack $requestStack)
    {
        $this->connection = $connection;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    /**
     * @param String $sql
     * @param array $args
     * @return bool|Statement
     */
    public function executeSQL(string $sql = "", array $args = []) {
        try {
            $stmt = $this->connection->prepare($sql);

            foreach ($args as $clave => $valor) {
                $stmt->bindValue($clave, $valor);
            }

            if ($stmt->execute()) {
                return $stmt;
            } else {
                return false;
            }
        } catch (Exception $e) {
            if ($_ENV["APP_ENV"] == "dev") dump($e->getMessage());
            return false;
        }
    }
}