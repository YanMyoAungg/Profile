<?php

namespace Libs\Database;

use PDO;
use PDOException;

class Mysql
{
    private $db = null;
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

    public function __construct(
        $dbhost = null,
        $dbuser = null,
        $dbpass = null,
        $dbname = null
    ) {
        if (!isset($_ENV['DB_HOST'])) {
            try {
                // Attempt to load .env from project root (3 levels up from this file's dir)
                $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
                $dotenv->safeLoad();
            } catch (\Exception $e) {
                // ignore
            }
        }

        $this->dbhost = $dbhost ?? $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbuser = $dbuser ?? $_ENV['DB_USER'] ?? 'root';
        $this->dbpass = $dbpass ?? $_ENV['DB_PASS'] ?? '';
        $this->dbname = $dbname ?? $_ENV['DB_NAME'] ?? 'food_fusion';
    }
    public function connect()
    {
        try {
            $this->db = new PDO(
                "mysql:dbhost=$this->dbhost;
                dbname=$this->dbname",
                $this->dbuser,
                $this->dbpass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
            return $this->db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
