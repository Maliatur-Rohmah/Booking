<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container-fluid">

        <button class="btn btn-success d-lg-none me-2" type="button" id="btnToggleSidebar">
            <i class="bi bi-list fs-5"></i>
        </button>

        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="dashboard.php">
            <img src="assets/images/logo.png" alt="Futsal Booking Logo" class="logo-img">
            <span>Futsal Booking</span>
        </a>

        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3 d-none d-sm-inline">
                <i class="bi bi-person-circle me-1"></i>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm" onclick="return confirm('Yakin ingin logout?');">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>
