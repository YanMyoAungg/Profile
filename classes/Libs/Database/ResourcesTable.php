<?php

namespace Libs\Database;

use PDO;

class ResourcesTable
{
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getByType($type)
    {
        $statement = $this->db->prepare("SELECT * FROM resources WHERE type = :type ORDER BY created_at DESC");
        $statement->execute(['type' => $type]);
        return $statement->fetchAll();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("INSERT INTO resources (title, type, file_path, description, created_at) VALUES (:title, :type, :file_path, :description, NOW())");
        $statement->execute($data);
        return $this->db->lastInsertId();
    }
}
