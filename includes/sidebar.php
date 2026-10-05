<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center py-4 border-bottom border-light border-opacity-25">
        <img src="assets/images/logo.png" alt="Futsal Booking Logo" style="width: 56px; height: 56px; object-fit: contain;">
        <p class="text-white small mt-1 mb-0">Admin Panel</p>
    </div>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($halaman_aktif == 'dashboard') ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="booking.php" class="nav-link <?php echo ($halaman_aktif == 'booking') ? 'active' : ''; ?>">
                <i class="bi bi-calendar-check me-2"></i> Data Booking
            </a>
        </li>
        <li class="nav-item">
            <a href="tambah_booking.php" class="nav-link <?php echo ($halaman_aktif == 'tambah') ? 'active' : ''; ?>">
                <i class="bi bi-plus-circle me-2"></i> Tambah Booking
            </a>
        </li>
    </ul>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
