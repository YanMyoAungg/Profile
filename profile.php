<?php

include("vendor/autoload.php");

use Helpers\Auth;

$auth = Auth::check();

?>

<?php include('header.php');
include('navbar.php');
?>

<div class="container my-5 " style="max-width: 800px;">
    <h1 class="h3 mt-4 mb3">Profile</h1>

    <?php if ($auth->photo) : ?>
        <img class="img-thumbnail mb-3 " src="actions/photos/<?= $auth->photo ?>" alt="Profile Picture" style="width: 200px; height: 200px; object-fit: cover;">
    <?php endif ?>

    <form action="actions/upload.php" method="post" enctype="multipart/form-data" class="input-group my-4">

        <input type="file" name="photo" class="form-control">
        <button class="btn btn-secondary">Upload</button>

    </form>

    <ul class="list-group mb-4">
        <li class="list-group-item">Name: <?= $auth->first_name ?> <?= $auth->last_name ?></li>
        <li class="list-group-item">Username: <?= $auth->username ?></li>
        <li class="list-group-item">Email: <?= $auth->email ?></li>
        <li class="list-group-item">phone: <?= $auth->phone ?></li>
        <li class="list-group-item">address: <?= $auth->address ?></li>
    </ul>
   
    
    <form action="actions/logout.php" method="POST" class="d-inline">
        <button name="logout" class="btn btn-dark">Logout</button>
    </form>
    <?php if (isset($auth->role_id) && $auth->role_id >= 2): ?>
        <a href="admin.php" class="btn btn-primary ms-4">
            <i class="bi bi-shield-lock"></i> Admin Panel
        </a>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>