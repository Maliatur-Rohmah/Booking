<?php
include "includes/cek_session.php";
include "config/koneksi.php";

$halaman_aktif = 'booking';

$cari   = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($koneksi, $_GET['status']) : '';

$query = "SELECT * FROM booking WHERE 1=1";

if ($cari != '') {
    $query .= " AND nama_pelanggan LIKE '%$cari%'";
}
if ($status != '') {
    $query .= " AND status_booking = '$status'";
}

$query .= " ORDER BY id_booking DESC";
$data_booking = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking - Sistem Reservasi Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include "includes/navbar.php"; ?>

    <div class="d-flex">
        <?php include "includes/sidebar.php"; ?>

        <div class="main-content p-4">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1">Data Booking</h4>
                    <p class="text-muted mb-0">Kelola seluruh data reservasi lapangan futsal</p>
                </div>
                <a href="tambah_booking.php" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Booking
                </a>
            </div>

            <?php if (isset($_GET['pesan'])): ?>
                <?php
                    $jenis = "success";
                    $isi   = "";
                    switch ($_GET['pesan']) {
                        case 'tambah_sukses': $isi = "Data booking berhasil ditambahkan."; break;
                        case 'edit_sukses': $isi = "Data booking berhasil diperbarui."; break;
                        case 'hapus_sukses': $isi = "Data booking berhasil dihapus."; break;
                        case 'gagal': $jenis = "danger"; $isi = "Terjadi kesalahan, silakan coba lagi."; break;
                    }
                ?>
                <?php if ($isi != ''): ?>
                <div class="alert alert-<?php echo $jenis; ?> alert-dismissible fade show py-2" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> <?php echo $isi; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form action="booking.php" method="GET" class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label small text-muted mb-1">Cari Nama Pelanggan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="cari" class="form-control" placeholder="Ketik nama pelanggan..." value="<?php echo htmlspecialchars($cari); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Filter Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Semua Status --</option>
                                <option value="Belum Lunas" <?php echo ($status == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                                <option value="Lunas" <?php echo ($status == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                                <option value="Dibatalkan" <?php echo ($status == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-funnel me-1"></i> Terapkan
                            </button>
                            <a href="booking.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No. HP</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Harga per Jam</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($data_booking) > 0): ?>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($data_booking)): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                            <td><?php echo htmlspecialchars($row['lapangan']); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_booking'])); ?></td>
                                            <td><?php echo substr($row['jam_mulai'],0,5) . ' - ' . substr($row['jam_selesai'],0,5); ?></td>
                                            <td>Rp <?php echo number_format($row['harga_per_jam'], 0, ',', '.'); ?></td>
                                            <td class="fw-semibold">Rp <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                    $badge = 'bg-warning text-dark';
                                                    if ($row['status_booking'] == 'Lunas') $badge = 'bg-success';
                                                    if ($row['status_booking'] == 'Dibatalkan') $badge = 'bg-danger';
                                                ?>
                                                <span class="badge <?php echo $badge; ?>"><?php echo $row['status_booking']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="edit_booking.php?id=<?php echo $row['id_booking']; ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="hapus_booking.php?id=<?php echo $row['id_booking']; ?>" class="btn btn-sm btn-outline-danger btn-hapus" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="10" class="text-center text-muted py-3">Data booking tidak ditemukan</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <?php include "includes/footer.php"; ?>
