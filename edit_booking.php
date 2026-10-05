<?php
include "includes/cek_session.php";
include "config/koneksi.php";

$halaman_aktif = 'booking';
$error = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: booking.php");
    exit;
}
$id = (int) $_GET['id'];

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

    if (empty($nama_pelanggan) || empty($no_hp) || empty($lapangan) || empty($tanggal_booking) || empty($jam_mulai) || empty($jam_selesai) || empty($harga_per_jam) || $total_bayar === '' || empty($status_booking)) {
        $error = "Semua field wajib diisi!";
    } elseif ($jam_selesai <= $jam_mulai) {
        $error = "Jam selesai harus lebih besar dari jam mulai!";
    } elseif (!is_numeric($harga_per_jam) || $harga_per_jam <= 0) {
        $error = "Harga per jam harus berupa angka lebih dari 0!";
    } elseif (!is_numeric($total_bayar) || $total_bayar < 0) {
        $error = "Total bayar harus berupa angka!";
    } else {
        $query = "UPDATE booking SET
                    nama_pelanggan = '$nama_pelanggan',
                    no_hp = '$no_hp',
                    lapangan = '$lapangan',
                    tanggal_booking = '$tanggal_booking',
                    jam_mulai = '$jam_mulai',
                    jam_selesai = '$jam_selesai',
                    harga_per_jam = '$harga_per_jam',
                    total_bayar = '$total_bayar',
                    status_booking = '$status_booking'
                  WHERE id_booking = $id";

        if (mysqli_query($koneksi, $query)) {
            header("Location: booking.php?pesan=edit_sukses");
            exit;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    }
}

$query_data = mysqli_query($koneksi, "SELECT * FROM booking WHERE id_booking = $id");

if (mysqli_num_rows($query_data) == 0) {
    header("Location: booking.php");
    exit;
}
$data = mysqli_fetch_assoc($query_data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - Sistem Reservasi Futsal</title>
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
                    <h4 class="fw-bold mb-1">Edit Booking</h4>
                    <p class="text-muted mb-0">Perbarui data reservasi #<?php echo $data['id_booking']; ?></p>
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
                    <form action="edit_booking.php?id=<?php echo $id; ?>" method="POST" id="formBooking">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control"
                                       value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control"
                                       value="<?php echo htmlspecialchars($data['no_hp']); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pilihan Lapangan</label>
                                <select name="lapangan" class="form-select" required>
                                    <?php foreach (['Lapangan A', 'Lapangan B', 'Lapangan C'] as $opsi): ?>
                                        <option value="<?php echo $opsi; ?>" <?php echo ($data['lapangan'] == $opsi) ? 'selected' : ''; ?>>
                                            <?php echo $opsi; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tanggal Booking</label>
                                <input type="date" name="tanggal_booking" class="form-control"
                                       value="<?php echo $data['tanggal_booking']; ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status Booking</label>
                                <select name="status_booking" class="form-select" required>
                                    <?php foreach (['Belum Lunas', 'Lunas', 'Dibatalkan'] as $opsi): ?>
                                        <option value="<?php echo $opsi; ?>" <?php echo ($data['status_booking'] == $opsi) ? 'selected' : ''; ?>>
                                            <?php echo $opsi; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control"
                                       value="<?php echo substr($data['jam_mulai'],0,5); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                                       value="<?php echo substr($data['jam_selesai'],0,5); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Harga per Jam (Rp)</label>
                                <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" min="0" step="1000"
                                       value="<?php echo $data['harga_per_jam']; ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Bayar (Rp)</label>
                                <input type="number" name="total_bayar" id="total_bayar" class="form-control" min="0"
                                       value="<?php echo $data['total_bayar']; ?>" required>
                                <small class="text-muted">Otomatis terhitung, tapi bisa diubah manual bila perlu</small>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="booking.php" class="btn btn-outline-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

    <?php include "includes/footer.php"; ?>
