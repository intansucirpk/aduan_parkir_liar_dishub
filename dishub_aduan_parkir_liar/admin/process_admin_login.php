<?php
session_start();
include 'connect.php'; // Sesuaikan dengan lokasi file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username ada di database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verifikasi password
        if (hash('sha256', $password) === $admin['password']) {
            // Simpan session login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php'); // Redirect ke dashboard jika login berhasil
            exit();
        } else {
            // Username benar, tapi password salah
            header('Location: index.php?error=password');
            exit();
        }
    } else {
        // Username salah, cek apakah password juga salah
        $stmt = $conn->prepare("SELECT * FROM admin WHERE password = ?");
        $stmt->bind_param("s", hash('sha256', $password));
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Password benar, tapi username salah
            header('Location: index.php?error=username');
        } else {
            // Username dan password salah
            header('Location: index.php?error=both');
        }
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
