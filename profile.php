<?php
include("vendor/autoload.php");

use Helpers\Auth;

$auth = Auth::check();
?>
<?php include('header.php');
include('navbar.php');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">

                    <!-- Header Section with Background (Optional: could add a cover photo here) -->
                    <div class="bg-secondary bg-gradient p-5 text-center text-white position-relative"
                        style="min-height: 200px;">
                        <div class="position-absolute top-50 start-50 translate-middle" style="margin-top: 50px;">
                            <!-- Profile Photo -->
                            <div class="position-relative d-inline-block" data-bs-toggle="modal"
                                data-bs-target="#uploadModal" title="Change Photo" style="cursor: pointer;">
                                <?php if ($auth->photo): ?>
                                    <img src="actions/photos/<?= $auth->photo ?>" alt="Profile"
                                        class="rounded-circle shadow"
                                        style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #fff;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-white text-secondary d-flex align-items-center justify-content-center shadow"
                                        style="width: 140px; height: 140px; font-size: 3rem; border: 4px solid #e1e1e1;">
                                        <?= strtoupper(substr($auth->username, 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 pt-5 pb-5 mt-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-1"><?= htmlspecialchars($auth->username) ?></h2>
                            <p class="text-muted mb-3"><?= htmlspecialchars($auth->email) ?></p>
                            <?php if (isset($auth->role_id) && $auth->role_id >= 2): ?>
                                <a href="admin.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                    <i class="bi bi-person-bounding-box"></i> Admin Panel
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Alert Messages -->
                        <?php if (isset($_GET['updated'])): ?>
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> Profile updated successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif ?>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $_GET['error'] === 'missing' ? 'All fields are required.' : 'An error occurred while updating profile.' ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif ?>

                        <form action="actions/update_profile.php" method="post" class="mt-4">
                            <div class="row g-4">
                                <!-- Editable Fields -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">First
                                        Name</label>
                                    <div class="input-group">

                                        <input type="text" name="first_name" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->first_name) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Last
                                        Name</label>
                                    <div class="input-group">
                                        <input type="text" name="last_name" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->last_name) ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->email) ?>" required>
                                    </div>
                                </div>

                                <!-- Other Details -->
                                <div class="col-12">
                                    <hr class="my-2 border-light">
                                </div>

                                <div class="col-12">
                                    <label
                                        class="form-label fw-bold text-secondary small text-uppercase">Username</label>
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->username) ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Phone</label>
                                    <div class="input-group">
                                        <input type="text" name="phone" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->phone) ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label
                                        class="form-label fw-bold text-secondary small text-uppercase">Address</label>
                                    <div class="input-group">
                                        <input type="text" name="address" class="form-control  ps-3"
                                            value="<?= htmlspecialchars($auth->address) ?>" required>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn btn-outline-dark  text-decoration-none rounded-pill">
                                        <i class="bi bi-check-lg me-1"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <form action="actions/logout.php" method="POST" class="d-inline">
                                <button name="logout"
                                    class="btn btn-link text-danger text-decoration-none opacity-75 hover-opacity-100">
                                    <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Update Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-3">
                <form action="actions/upload.php" method="post" enctype="multipart/form-data">
                    <p class="text-muted small mb-3">Upload a new photo to update your profile picture. Recommended
                        size: 500x500px.</p>
                    <div class="mb-4">
                        <input type="file" name="photo" class="form-control" required accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary py-2 fw-bold">Upload Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>