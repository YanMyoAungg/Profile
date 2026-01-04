<?php

namespace Libs\Database;

use PDO;

class CommunityRecipesTable
{
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getAll()
    {
        $statement = $this->db->query("
            SELECT community_recipes.*, users.name as author_name 
            FROM community_recipes 
            JOIN users ON community_recipes.user_id = users.id 
            ORDER BY created_at DESC
        ");
        return $statement->fetchAll();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("
            INSERT INTO community_recipes (user_id, title, description, ingredients, instructions, created_at)
            VALUES (:user_id, :title, :description, :ingredients, :instructions, NOW())
        ");
        
        $statement->execute($data);
        return $this->db->lastInsertId();
    }
}
