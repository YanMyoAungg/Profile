<?php

include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\CommentsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

if (!$auth) {
    HTTP::redirect("/login.php");
}

$data = [
    "user_id" => $auth->id,
    "recipe_id" => $_POST['recipe_id'],
    "comment" => $_POST['comment']
];

if (empty($data['recipe_id']) || empty($data['comment'])) {
    HTTP::redirect("/community.php?error=missing_fields");
}

$table = new CommentsTable(new Mysql());
$table->insert($data);

HTTP::redirect("/community.php?success=comment_added");
