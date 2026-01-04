<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
$lockoutRemaining = 0;
if (isset($_SESSION['lockout_until'])) {
    $lockoutRemaining = max(0, $_SESSION['lockout_until'] - time());
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
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <h2 class="card-title text-center mb-4 text-primary fw-bold">Welcome Back</h2>

                    <?php if (isset($_GET['suspended'])): ?>
                        <div class="alert alert-danger" role="alert">
                            Account suspended
                        </div>
                    <?php endif ?>

                    <?php if (isset($_GET["register"])): ?>
                        <div class="alert alert-info" role="alert">
                            Registration successful! Please login.
                        </div>
                    <?php endif ?>

                    <?php if (isset($_GET['auth']) && $_GET['auth'] === 'fail'): ?>
                        <div class="alert alert-warning" role="alert">
                            Incorrect email or password
                        </div>
                    <?php endif ?>

                    <?php if (isset($_GET['auth']) && $_GET['auth'] === 'locked'): ?>
                        <div class="alert alert-danger" role="alert">
                            Too many failed attempts. Login disabled temporarily.
                        </div>
                    <?php endif ?>

                    <form action="actions/login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="email" class="form-control" id="emailInput"
                                placeholder="name@example.com" required>
                            <label for="emailInput">Email or Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="passwordInput"
                                placeholder="Password" required>
                            <label for="passwordInput">Password</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button id="loginBtn" name="button" class="btn btn-primary btn-lg"
                                type="submit">Login</button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted">Don't have an account? <a href="register.php"
                                    class="text-decoration-none">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var remaining = <?php echo (int) $lockoutRemaining; ?>;
        var btn = document.getElementById('loginBtn');
        if (remaining > 0 && btn) {
            btn.disabled = true;
            var update = function () {
                if (remaining <= 0) {
                    btn.disabled = false;
                    btn.textContent = 'Login';
                    clearInterval(interval);
                    return;
                }
                var mins = Math.floor(remaining / 60);
                var secs = remaining % 60;
                btn.textContent = 'Locked (' + String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0') + ')';
                remaining--;
            };
            update();
            var interval = setInterval(update, 1000);
        }
    })();
</script>

<?php include('footer.php'); ?>