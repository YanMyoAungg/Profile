<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include('header.php'); ?>
<style>
    body {
        background-color: #f8f9fa;
    }
</style>
<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <h2 class="card-title text-center mb-4 text-dark fw-bold">Create Account</h2>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-warning" role="alert">
                            Cannot create account. Please try again.
                        </div>
                    <?php endif ?>

                    <form action="actions/create.php" method="post">
                        <div class="row g-2 mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" name="first_name" class="form-control" id="firstNameInput"
                                        placeholder="First Name" required>
                                    <label for="firstNameInput">First Name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" name="last_name" class="form-control" id="lastNameInput"
                                        placeholder="Last Name" required>
                                    <label for="lastNameInput">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="usernameInput"
                                placeholder="Username" required>
                            <label for="usernameInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="emailInput"
                                placeholder="name@example.com" required>
                            <label for="emailInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="phone" class="form-control" id="phoneInput"
                                placeholder="Phone Number" required>
                            <label for="phoneInput">Phone Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="address" class="form-control" id="addressInput"
                                placeholder="Address" required>
                            <label for="addressInput">Address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="passwordInput"
                                placeholder="Password" required>
                            <label for="passwordInput">Password</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted">Already have an account? <a href="login.php"
                                    class="text-decoration-none text-dark">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>