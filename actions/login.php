<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$credential = $_POST['credential'] ?? '';
$password = $_POST['password'] ?? '';

$table = new UsersTable(new Mysql());
$user = $table->findByEmailOrUsernameAndPassword($credential, $password);
if ($user) {
    // successful login: clear attempts and lockout
    unset($_SESSION['login_attempts']);
    unset($_SESSION['lockout_until']);

    if ($user->suspended) {
        HTTP::redirect("/login.php", "suspended=true");
    }
    $_SESSION['user'] = $user;
    HTTP::redirect("/profile.php");
} else {
    // failed attempt
    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

    // if reached 5 consecutive failures, set 5 minute lockout
    if ($_SESSION['login_attempts'] >= 5) {
        $_SESSION['lockout_until'] = time() + (1 * 60); // 5 minutes
        // reset attempts counter after lockout
        $_SESSION['login_attempts'] = 0;
        HTTP::redirect('/login.php?auth=locked');
    }

    HTTP::redirect('/login.php?auth=fail');
}