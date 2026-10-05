<?php
include "includes/cek_session.php";
include "config/koneksi.php";

$halaman_aktif = 'dashboard';

$total_booking = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking"))['jumlah'];

$booking_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE tanggal_booking = CURDATE()"))['jumlah'];

$booking_belum_lunas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE status_booking = 'Belum Lunas'"))['jumlah'];

$booking_lunas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE status_booking = 'Lunas'"))['jumlah'];

$booking_batal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE status_booking = 'Dibatalkan'"))['jumlah'];

$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT IFNULL(SUM(total_bayar), 0) AS jumlah FROM booking WHERE status_booking = 'Lunas'"))['jumlah'];

$booking_terbaru = mysqli_query($koneksi, "SELECT * FROM booking ORDER BY id_booking DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Reservasi Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include "includes/navbar.php"; ?>

    <div class="d-flex">
        <?php include "includes/sidebar.php"; ?>

        <div class="main-content p-4">

            <h4 class="fw-bold mb-1">Dashboard</h4>
            <p class="text-muted mb-4">Ringkasan data reservasi lapangan futsal</p>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon icon-navy">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Total Booking</p>
                                <h4 class="fw-bold mb-0"><?php echo $total_booking; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon icon-emas">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Booking Hari Ini</p>
                                <h4 class="fw-bold mb-0"><?php echo $booking_hari_ini; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-warning-subtle text-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Booking Belum Lunas</p>
                                <h4 class="fw-bold mb-0"><?php echo $booking_belum_lunas; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon icon-navy">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Booking Lunas</p>
                                <h4 class="fw-bold mb-0"><?php echo $booking_lunas; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-danger-subtle text-danger">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Booking Dibatalkan</p>
                                <h4 class="fw-bold mb-0"><?php echo $booking_batal; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-stat border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon icon-emas">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted small mb-0">Total Pendapatan</p>
                                <h4 class="fw-bold mb-0">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-clock-history me-1"></i> Booking Terbaru</span>
                    <a href="booking.php" class="btn btn-sm btn-success">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($booking_terbaru) > 0): ?>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($booking_terbaru)): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['lapangan']); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_booking'])); ?></td>
                                            <td><?php echo substr($row['jam_mulai'],0,5) . ' - ' . substr($row['jam_selesai'],0,5); ?></td>
                                            <td>Rp <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                    $badge = 'bg-warning text-dark';
                                                    if ($row['status_booking'] == 'Lunas') $badge = 'bg-success';
                                                    if ($row['status_booking'] == 'Dibatalkan') $badge = 'bg-danger';
                                                ?>
                                                <span class="badge <?php echo $badge; ?>"><?php echo $row['status_booking']; ?></span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data booking</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <?php include "includes/footer.php"; ?>
