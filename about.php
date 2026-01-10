<?php
session_start();
include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">About FoodFusion</h1>
            <p class="lead">FoodFusion is more than just a recipe site; it's a global community for culinary exploration
                and education.</p>
            <p>Our mission is to empower home cooks and professional chefs alike by providing high-quality recipes,
                educational resources, and a platform to share their own culinary creations.</p>
        </div>
        <div class="col-md-6">
            <img src="./resources/kitchen.png" class="img-fluid rounded shadow" alt="About Us">
        </div>
    </div>

    <div class="row text-center mt-5">
        <div class="col-md-4">
            <div class="p-3">
                <i class="bi bi-people fs-1 text-dark"></i>
                <h3 class="mt-3">Community</h3>
                <p>Join thousands of food lovers sharing their best family secrets and modern twists.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3">
                <i class="bi bi-book fs-1 text-dark"></i>
                <h3 class="mt-3">Education</h3>
                <p>Access professional-grade resources to master techniques and understand nutrition.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3">
                <i class="bi bi-egg-fried fs-1 text-dark"></i>
                <h3 class="mt-3">Inspiration</h3>
                <p>Find your next favorite meal with our curated collection of verified recipes.</p>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>