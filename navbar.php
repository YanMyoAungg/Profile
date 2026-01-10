<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">FoodFusion</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : '' ?>" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'recipes.php') ? 'active' : '' ?>"
                        href="recipes.php">Recipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'community.php') ? 'active' : '' ?>"
                        href="community.php">Community</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($current_page == 'culinary_resources.php' || $current_page == 'educational_resources.php') ? 'active' : '' ?>"
                        href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Resources
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item <?= ($current_page == 'culinary_resources.php') ? 'active' : '' ?>"
                                href="culinary_resources.php">Culinary Resources</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'educational_resources.php') ? 'active' : '' ?>"
                                href="educational_resources.php">Educational Resources</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : '' ?>"
                        href="contact.php">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php $user = $_SESSION['user']; ?>
                    <?php $userInitial = strtoupper(substr($user->username, 0, 1)); ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center <?= ($current_page == 'profile.php') ? 'active' : '' ?>"
                            href="profile.php">
                            <span class="profile-icon me-2 <?= $user->photo ? 'has-photo' : '' ?>">
                                <?php if ($user->photo): ?>
                                    <img src="actions/photos/<?= $user->photo ?>" alt="Profile" class="rounded-circle"
                                        style="width: 28px; height: 28px; object-fit: cover;">
                                <?php else: ?>
                                    <span class="avatar-placeholder rounded-circle"><?= $userInitial ?></span>
                                <?php endif; ?>
                            </span>
                            <span class="d-none d-lg-inline">My Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actions/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'register.php') ? 'active' : '' ?>"
                            href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>