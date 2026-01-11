<?php

namespace Helpers;

use Libs\Database\Mysql;
use Libs\Database\UsersTable;

class Auth
{
    static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $table = new UsersTable(new Mysql());
            $freshUser = $table->findById($user->id);
            
            if ($freshUser && $freshUser->suspended) {
                unset($_SESSION['user']);
                HTTP::redirect('/login.php', 'suspended=true');
            }
            
            return $_SESSION['user'];
        } else {
            HTTP::redirect("/index.php", "auth=fail");
        }
    }
}

// namespace Helpers;

// class Auth
// {
//     static $loginUrl = '/index.php';
//     static function check()
//     {
//         session_start();
//         if (isset($_SESSION['user'])) {
//             return $_SESSION['user'];
//         } else {
//             HTTP::redirect(static::$loginUrl);
//         }
//     }
// }
