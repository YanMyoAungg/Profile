<?php
include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\ContactsTable;
use Helpers\HTTP;

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if ($name && $email && $message) {
    $table = new ContactsTable(new Mysql());
    $table->insert([
        'name' => $name,
        'email' => $email,
        'message' => $message
    ]);
    
    HTTP::redirect('/contact.php', 'success=sent');
} else {
    HTTP::redirect('/contact.php', 'error=missing_fields');
}
