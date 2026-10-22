<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $catatan_admin = $_POST['catatan_admin'];

    // Update catatan admin
    $stmt = $conn->prepare("UPDATE aduan SET catatan_admin = ? WHERE id = ?");
    $stmt->bind_param("si", $catatan_admin, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Catatan berhasil diperbarui!'); window.location='kelola_aduan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location='kelola_aduan.php';</script>";
    }
}
?>
