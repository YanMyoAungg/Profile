<?php
include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$name = $_POST['name'] ?? '';
if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $name = trim($_POST['first_name'] . ' ' . $_POST['last_name']);
}
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    HTTP::redirect('/register.php', 'error=missing');
}

$data = [
    'name' => $name,
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
    // Could be duplicate email or DB error
    HTTP::redirect('/register.php', 'error=true');
}
