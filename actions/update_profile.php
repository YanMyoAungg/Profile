<?php

include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UsersTable;
use Helpers\HTTP;
use Helpers\Auth;

$auth = Auth::check();

$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

if (!$first_name || !$last_name || !$email || !$username || !$phone || !$address) {
    HTTP::redirect('/profile.php', 'error=missing');
}

$data = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'username' => $username,
    'phone' => $phone,
    'address' => $address,
];

$table = new UsersTable(new Mysql());
try {
    $table->updateProfile($auth->id, $data);
    $auth->first_name = $first_name;
    $auth->last_name = $last_name;
    $auth->email = $email;
    $auth->username = $username;
    $auth->phone = $phone;
    $auth->address = $address;
    HTTP::redirect('/profile.php', 'updated=true');
} catch (Exception $e) {
    HTTP::redirect('/profile.php', 'error=true');
}
