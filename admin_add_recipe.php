<?php
include("vendor/autoload.php");

use Helpers\Auth;

$auth = Auth::check();

// Only admin/manager should access (assuming role_id 2 or 3)
if ($auth->role_id < 2) {
    Helpers\HTTP::redirect('/login.php', 'auth=fail');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe - Admin</title>
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
        <h1 class="mb-4">Add New Recipe</h1>
        
        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger">
                Error adding recipe. Please check your input.
            </div>
        <?php endif ?>

        <form action="actions/add_recipe.php" method="post" enctype="multipart/form-data" class="mb-5">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="difficulty" class="form-label">Difficulty</label>
                <select name="difficulty" id="difficulty" class="form-select">
                    <option value="Easy">Easy</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="Hard">Hard</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="prep_time" class="form-label">Prep Time (minutes)</label>
                <input type="number" name="prep_time" id="prep_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <textarea name="ingredients" id="ingredients" class="form-control" rows="5" required placeholder="One ingredient per line"></textarea>
            </div>

            <div class="mb-3">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea name="instructions" id="instructions" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Recipe</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>