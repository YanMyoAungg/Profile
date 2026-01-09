<?php
include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$password = $_POST['password'] ?? '';

if (!$first_name || !$last_name || !$username || !$email || !$password) {
    HTTP::redirect('/register.php', 'error=missing');
}

$data = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'username' => $username,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'password' => $password,
];

$table = new UsersTable(new Mysql());
try {
    $table->insert($data);
    HTTP::redirect('/login.php', 'register=success');
} catch (Exception $e) {
    HTTP::redirect('/register.php', 'error=true');
}
