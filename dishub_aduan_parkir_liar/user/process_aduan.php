<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jenis_aduan = $_POST['jenis_aduan'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_aduan = $_POST['tanggal_aduan'];
    $lokasi_aduan = $_POST['lokasi_aduan'];
    $file_pendukung = '';

    // Proses upload file jika ada
    if (isset($_FILES['file_pendukung']) && $_FILES['file_pendukung']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $file_pendukung = $target_dir . basename($_FILES['file_pendukung']['name']);
        move_uploaded_file($_FILES['file_pendukung']['tmp_name'], $file_pendukung);
    }

    // Simpan data ke database
    $stmt = $conn->prepare("INSERT INTO aduan (nama, email, jenis_aduan, deskripsi, tanggal_aduan, lokasi_aduan, file_pendukung) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nama, $email, $jenis_aduan, $deskripsi, $tanggal_aduan, $lokasi_aduan, $file_pendukung);

    if ($stmt->execute()) {
        echo "<script>alert('Aduan berhasil diajukan!'); window.location='terimakasih.php';</script>";
    } else {
        echo "<script>alert('Gagal mengajukan aduan!'); window.location='form_aduan.php';</script>";
    }
}
?>
