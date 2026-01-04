<?php
session_start();
include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Contact Us</h1>
            <p class="text-center text-muted mb-5">Have a question or feedback? We'd love to hear from you!</p>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Thank you! Your message has been sent successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Please fill in all fields.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="actions/contact_submit.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message to send..." required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-geo-alt fs-2 text-primary"></i>
                        <h5>Our Office</h5>
                        <p class="text-muted">123 Culinary Ave, Food City</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-envelope fs-2 text-primary"></i>
                        <h5>Email Us</h5>
                        <p class="text-muted">support@foodfusion.com</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-telephone fs-2 text-primary"></i>
                        <h5>Call Us</h5>
                        <p class="text-muted">+1 234 567 890</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
