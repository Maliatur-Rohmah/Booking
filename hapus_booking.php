<?php
include "includes/cek_session.php";
include "config/koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: booking.php");
    exit;
}
$id = (int) $_GET['id'];

$query = "DELETE FROM booking WHERE id_booking = $id";

if (mysqli_query($koneksi, $query)) {
    header("Location: booking.php?pesan=hapus_sukses");
    exit;
} else {
    header("Location: booking.php?pesan=gagal");
    exit;
}
?>
