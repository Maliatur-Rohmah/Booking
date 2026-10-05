<?php
include "includes/cek_session.php";
include "config/koneksi.php";

$halaman_aktif = 'tambah';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_pelanggan   = mysqli_real_escape_string($koneksi, trim($_POST['nama_pelanggan']));
    $no_hp            = mysqli_real_escape_string($koneksi, trim($_POST['no_hp']));
    $lapangan         = mysqli_real_escape_string($koneksi, $_POST['lapangan']);
    $tanggal_booking  = mysqli_real_escape_string($koneksi, $_POST['tanggal_booking']);
    $jam_mulai        = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai      = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $harga_per_jam    = mysqli_real_escape_string($koneksi, $_POST['harga_per_jam']);
    $total_bayar      = mysqli_real_escape_string($koneksi, $_POST['total_bayar']);
    $status_booking   = mysqli_real_escape_string($koneksi, $_POST['status_booking']);
    $id_admin         = $_SESSION['id_admin'];

    if (empty($nama_pelanggan) || empty($no_hp) || empty($lapangan) || empty($tanggal_booking) || empty($jam_mulai) || empty($jam_selesai) || empty($harga_per_jam) || empty($status_booking)) {
        $error = "Semua field wajib diisi!";
    } elseif ($jam_selesai <= $jam_mulai) {
        $error = "Jam selesai harus lebih besar dari jam mulai!";
    } elseif (!is_numeric($harga_per_jam) || $harga_per_jam <= 0) {
        $error = "Harga per jam harus berupa angka lebih dari 0!";
    } else {
        $waktu_mulai   = strtotime($jam_mulai);
        $waktu_selesai = strtotime($jam_selesai);
        $lama_jam      = ($waktu_selesai - $waktu_mulai) / 3600;
        $total_bayar   = $lama_jam * $harga_per_jam;

        $query = "INSERT INTO booking (id_admin, nama_pelanggan, no_hp, lapangan, tanggal_booking, jam_mulai, jam_selesai, harga_per_jam, total_bayar, status_booking)
                  VALUES ('$id_admin', '$nama_pelanggan', '$no_hp', '$lapangan', '$tanggal_booking', '$jam_mulai', '$jam_selesai', '$harga_per_jam', '$total_bayar', '$status_booking')";

        if (mysqli_query($koneksi, $query)) {
            header("Location: booking.php?pesan=tambah_sukses");
            exit;
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Booking - Sistem Reservasi Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include "includes/navbar.php"; ?>

    <div class="d-flex">
        <?php include "includes/sidebar.php"; ?>

        <div class="main-content p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Tambah Booking</h4>
                    <p class="text-muted mb-0">Masukkan data reservasi lapangan baru</p>
                </div>
                <a href="booking.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <?php if ($error != ''): ?>
                <div class="alert alert-danger py-2">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="tambah_booking.php" method="POST" id="formBooking" class="needs-validation" novalidate>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control" placeholder="Contoh: Ahmad Fauzi"
                                       value="<?php echo isset($_POST['nama_pelanggan']) ? htmlspecialchars($_POST['nama_pelanggan']) : ''; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890"
                                       value="<?php echo isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pilihan Lapangan</label>
                                <select name="lapangan" class="form-select" required>
                                    <option value="">-- Pilih Lapangan --</option>
                                    <option value="Lapangan A">Lapangan A</option>
                                    <option value="Lapangan B">Lapangan B</option>
                                    <option value="Lapangan C">Lapangan C</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tanggal Booking</label>
                                <input type="date" name="tanggal_booking" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status Booking</label>
                                <select name="status_booking" class="form-select" required>
                                    <option value="Belum Lunas" selected>Belum Lunas</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Harga per Jam (Rp)</label>
                                <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" placeholder="Contoh: 100000" min="0" step="1000" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Bayar (Rp)</label>
                                <input type="number" name="total_bayar" id="total_bayar" class="form-control" value="0" readonly>
                                <small class="text-muted">Otomatis terhitung dari jam &amp; harga</small>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="booking.php" class="btn btn-outline-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

    <?php include "includes/footer.php"; ?>
