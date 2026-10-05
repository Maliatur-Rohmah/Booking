<?php
session_start();
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=1");
        exit;
    }

    $query  = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);

        if ($password == $data['password']) {
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['username'] = $data['username'];

            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    } else {
        header("Location: login.php?error=1");
        exit;
    }
}
?>
