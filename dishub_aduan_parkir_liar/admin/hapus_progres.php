<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM aduan_progress WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Gagal menghapus progres.";
    }
} else {
    header('Location: kelola_aduan.php');
    exit();
}
?>
