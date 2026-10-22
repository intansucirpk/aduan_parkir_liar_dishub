<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aduan_id = $_POST['aduan_id'];
    $deskripsi_progres = $_POST['deskripsi_progres'];
    
    $stmt = $conn->prepare("INSERT INTO aduan_progress (aduan_id, deskripsi_progres) VALUES (?, ?)");
    $stmt->bind_param("is", $aduan_id, $deskripsi_progres);
    $stmt->execute();
    
    header("Location: detail_aduan.php?id=" . $aduan_id);
    exit();
}
?>