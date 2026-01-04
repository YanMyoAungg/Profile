<?php
include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\Mysql;
use Libs\Database\ResourcesTable;

$auth = Auth::check();

if ($auth->role_id < 2) {
    HTTP::redirect('/login.php', 'auth=fail');
}

$title = $_POST['title'] ?? '';
$type = $_POST['type'] ?? 'culinary';
$description = $_POST['description'] ?? '';

// File upload handling
$filePath = '';
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $name = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    
    // Validate type (images or pdf)
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    // You might want to be more loose or strict depending on requirements
    
    // For now, accept PDF and images
    // if (in_array($fileType, $allowedTypes) || strpos($fileType, 'image/') === 0) {
        $uploadDir = '../resources/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $fileName = 'resource_' . time() . '.' . $extension;
        $destination = $uploadDir . $fileName;
        
        if (move_uploaded_file($tmp, $destination)) {
            $filePath = 'resources/' . $fileName;
        } else {
            HTTP::redirect('/admin_add_resource.php', 'error=upload_failed');
        }
    // } else {
    //     HTTP::redirect('/admin_add_resource.php', 'error=invalid_type');
    // }
}

if ($title && $filePath) {
    $table = new ResourcesTable(new Mysql());
    $data = [
        'title' => $title,
        'type' => $type,
        'file_path' => $filePath,
        'description' => $description
    ];
    
    $table->insert($data);
    HTTP::redirect('/admin.php', 'success=resource_added');
} else {
    HTTP::redirect('/admin_add_resource.php', 'error=missing_fields');
}
