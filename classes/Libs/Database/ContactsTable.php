<?php

namespace Libs\Database;

use PDO;

class ContactsTable
{
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("
            INSERT INTO contacts (name, email, message, created_at)
            VALUES (:name, :email, :message, NOW())
        ");
        
        $statement->execute($data);
        return $this->db->lastInsertId();
    }
}
