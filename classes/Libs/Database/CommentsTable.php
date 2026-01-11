<?php

namespace Libs\Database;

use PDO;

class CommentsTable
{
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getByRecipeId($recipe_id)
    {
        $statement = $this->db->prepare("
            SELECT comments.*, users.username, users.photo
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.recipe_id = :recipe_id
            ORDER BY comments.created_at DESC
        ");
        $statement->execute(['recipe_id' => $recipe_id]);
        return $statement->fetchAll();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("
            INSERT INTO comments (user_id, recipe_id, comment, created_at)
            VALUES (:user_id, :recipe_id, :comment, NOW())
        ");
        
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $statement->execute(['id' => $id]);
    }
}
