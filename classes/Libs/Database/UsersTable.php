<?php

namespace Libs\Database;

class UsersTable
{
    private $db;
    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getAll()
    {
        $statement = $this->db->query(
            "SELECT users.*, CONCAT(users.first_name, ' ', users.last_name) AS name, roles.name AS role FROM users LEFT JOIN roles ON users.role_id = roles.id"
        );
        return $statement->fetchAll();
    }

    public function findByEmailOrUsernameAndPassword($credential, $password)
    {
        $statement = $this->db->prepare("SELECT * FROM users WHERE email=:credential OR username=:credential");
        $statement->execute(["credential" => $credential]);
        $user = $statement->fetch();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public function findById($id)
    {
        $statement = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function insert($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $statement = $this->db->prepare(
            "INSERT INTO users(first_name,last_name,username,email,phone,address,password,role_id,created_at) VALUES (:first_name,:last_name,:username,:email,:phone,:address,:password,1,NOW())"
        );
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function updatePhoto($photo, $id)
    {
        $statement = $this->db->prepare("UPDATE users SET photo=:photo WHERE id=:id");
        $statement->execute(['photo' => $photo, 'id' => $id]);
        return $statement->rowCount();
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $statement->execute(['id' => $id]);
        return $statement->rowCount();
    }

    public function suspend($id)
    {
        $statement = $this->db->prepare("UPDATE users SET suspended=1 WHERE id=:id");
        $statement->execute(['id' => $id]);
        return $statement->rowCount();
    }

    public function unsuspend($id)
    {
        $statement = $this->db->prepare("UPDATE users SET suspended=0 WHERE id=:id");
        $statement->execute(['id' => $id]);
        return $statement->rowCount();
    }
    public function changeRole($id, $role_id)
    {
        $statement = $this->db->prepare("UPDATE users SET role_id=:role_id WHERE
        id=:id");
        $statement->execute(['id' => $id, 'role_id' => $role_id]);
        return $statement->rowCount();
    }

    public function updateProfile($id, $data)
    {
        $statement = $this->db->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, username=:username, phone=:phone, address=:address WHERE id=:id");
        $statement->execute([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ]);
        return $statement->rowCount();
    }
}
