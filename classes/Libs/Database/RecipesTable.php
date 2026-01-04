<?php

namespace Libs\Database;

use PDO;

class RecipesTable
{
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getAll()
    {
        $statement = $this->db->query("SELECT * FROM recipes ORDER BY created_at DESC");
        return $statement->fetchAll();
    }

    public function getById($id)
    {
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("INSERT INTO recipes (title, description, image, difficulty, prep_time, ingredients, instructions, created_at) VALUES (:title, :description, :image, :difficulty, :prep_time, :ingredients, :instructions, NOW())");
        $statement->execute($data);
        return $this->db->lastInsertId();
    }
}
