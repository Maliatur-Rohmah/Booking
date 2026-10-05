<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Reservasi Futsal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">

    <div class="login-wrapper">
        <div class="card login-card shadow-lg border-0">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <img src="assets/images/logo.png" alt="Futsal Booking Logo" class="login-logo mb-2">
                    <h4 class="fw-bold text-success mb-0">Futsal Booking</h4>
                    <p class="text-muted small">Login Admin untuk mengelola booking</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Username atau password salah!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['logout'])): ?>
                    <div class="alert alert-success py-2 small" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Anda berhasil logout.
                    </div>
                <?php endif; ?>

                <form action="proses_login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </form>

                <p class="text-center text-muted small mt-4 mb-0">
                    &copy; <?php echo date("Y"); ?> Sistem Reservasi Lapangan Futsal
                </p>
            </div>
        </div>
    </div>

</body>
</html>
