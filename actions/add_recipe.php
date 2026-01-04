<?php
include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\Mysql;
use Libs\Database\RecipesTable;

$auth = Auth::check();

if ($auth->role_id < 2) {
    HTTP::redirect('/login.php', 'auth=fail');
}

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$difficulty = $_POST['difficulty'] ?? 'Medium';
$prep_time = $_POST['prep_time'] ?? 0;
$ingredients = $_POST['ingredients'] ?? '';
$instructions = $_POST['instructions'] ?? '';

// File upload handling
$imagePath = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $name = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $type = $_FILES['image']['type'];
    
    // Simple validation
    if (strpos($type, 'image/') === 0) {
        $uploadDir = '../resources/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique name to avoid overwrite
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $fileName = 'recipe_' . time() . '.' . $extension;
        $destination = $uploadDir . $fileName;
        
        if (move_uploaded_file($tmp, $destination)) {
            $imagePath = 'resources/' . $fileName;
        } else {
            HTTP::redirect('/admin_add_recipe.php', 'error=upload_failed');
        }
    } else {
        HTTP::redirect('/admin_add_recipe.php', 'error=invalid_type');
    }
}

if ($title && $ingredients && $instructions) {
    $table = new RecipesTable(new Mysql());
    $data = [
        'title' => $title,
        'description' => $description,
        'image' => $imagePath,
        'difficulty' => $difficulty,
        'prep_time' => $prep_time,
        'ingredients' => $ingredients,
        'instructions' => $instructions
    ];
    
    $table->insert($data);
    HTTP::redirect('/admin.php', 'success=recipe_added');
} else {
    HTTP::redirect('/admin_add_recipe.php', 'error=missing_fields');
}
