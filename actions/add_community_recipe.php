<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\CommunityRecipesTable;
use Helpers\HTTP;

$auth = $_SESSION['user'] ?? null;

if (!$auth) {
    HTTP::redirect('/login.php', 'auth=fail');
}

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$ingredients = $_POST['ingredients'] ?? '';
$instructions = $_POST['instructions'] ?? '';

if ($title && $ingredients && $instructions) {
    $table = new CommunityRecipesTable(new Mysql());
    $table->insert([
        'user_id' => $auth->id,
        'title' => $title,
        'description' => $description,
        'ingredients' => $ingredients,
        'instructions' => $instructions
    ]);
    
    HTTP::redirect('/community.php', 'success=added');
} else {
    HTTP::redirect('/community.php', 'error=missing_fields');
}
