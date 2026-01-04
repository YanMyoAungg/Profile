<?php
session_start();
?>
<?php include('header.php'); ?>
<?php include('navbar.php'); ?>

<!-- Hero Section -->
<?php if (!isset($_SESSION['user'])): ?>
<div id="heroSection" class="mb-4 bg-light hero-section text-center position-relative d-flex align-items-center justify-content-center" style="min-height: 500px;">
    <div id="welcome_modal" class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.3); z-index: 10;">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2" aria-label="Close" onclick="document.getElementById('welcome_modal').remove()" style="z-index: 11;"></button>
    
        <div class="container py-5 px-4" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 15px; max-width: 800px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
            <h1 class="display-4 fw-bold text-dark mb-3">Welcome to FoodFusion</h1>
            <p class="lead text-dark mb-4">
                Our mission is to empower home cooks and professional chefs alike by providing high-quality recipes, 
                educational resources, and a platform to share their own culinary creations.
            </p>
            <button type="button" class="btn btn-primary btn-lg px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#joinUsModal">
                Join Us Today
            </button>
        </div>
    </div>
</div>

<!-- Join Us Modal -->
<div class="modal fade" id="joinUsModal" tabindex="-1" aria-labelledby="joinUsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="joinUsModalLabel">Join FoodFusion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/create.php" method="POST">
                    <div class="row g-2 mb-3">
                        <div class="col-md me-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" required>
                                <label for="firstName">First Name</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" required>
                                <label for="lastName">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <!-- Hidden fields for optional data to avoid SQL errors if strict -->
                    <input type="hidden" name="phone" value="">
                    <input type="hidden" name="address" value="">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="text-muted small mb-0">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="container mt-4">
    <!-- Event Carousel -->
    <h2 class="text-center mb-4">Upcoming Events</h2>
    <div id="carouselExampleControls" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./resources/summber_festival.png" class="d-block w-100" alt="Event 1" style="height: 400px; object-fit: contain; background-color: #333;">
            </div>
            <div class="carousel-item">
                <img src="./resources/culinary_workshops.png" class="d-block w-100" alt="Event 2" style="height: 400px; object-fit: contain; background-color: #333;">
            </div>
            <div class="carousel-item">
                <img src="./resources/masterchef_meetup.png" class="d-block w-100" alt="Event 3" style="height: 400px; object-fit: contain; background-color: #333;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Recent Recipes Feed (Placeholder) -->
    <h2 class="text-center mb-4">Featured Recipes & Culinary Trends</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="./resources/spaghetti.png" class="card-img-top" alt="Recipe 1">
                <div class="card-body">
                    <h5 class="card-title">Classic Spaghetti</h5>
                    <p class="card-text">A delicious and easy to make classic Italian dish.</p>
                    <a href="recipes.php" class="btn btn-outline-primary">View Recipe</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="./resources/salad.png" class="card-img-top" alt="Recipe 2">
                <div class="card-body">
                    <h5 class="card-title">Fresh Garden Salad</h5>
                    <p class="card-text">Healthy and refreshing salad with seasonal vegetables.</p>
                    <a href="recipes.php" class="btn btn-outline-primary">View Recipe</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="./resources/cake.png" class="card-img-top" alt="Recipe 3">
                <div class="card-body">
                    <h5 class="card-title">Chocolate Cake</h5>
                    <p class="card-text">Rich and moist chocolate cake for dessert lovers.</p>
                    <a href="recipes.php" class="btn btn-outline-primary">View Recipe</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
