<?php
include("vendor/autoload.php");

use Helpers\Auth;

$auth = Auth::check();

if ($auth->role_id < 2) {
    Helpers\HTTP::redirect('/login.php', 'auth=fail');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resource - Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="admin.php">Admin Panel</a>
            <a href="actions/logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Add New Resource</h1>

        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger">
                Error adding resource. Please check your input.
            </div>
        <?php endif ?>

        <form action="actions/add_resource.php" method="post" enctype="multipart/form-data" class="mb-5">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="culinary">Culinary</option>
                    <option value="educational">Educational</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File (PDF/Image)</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Resource</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>