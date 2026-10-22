<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM aduan_progress WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $progress = $result->fetch_assoc();
} else {
    header('Location: kelola_aduan.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deskripsi_progres = $_POST['deskripsi_progres'];

    $stmt = $conn->prepare("UPDATE aduan_progress SET deskripsi_progres = ? WHERE id = ?");
    $stmt->bind_param("si", $deskripsi_progres, $id);
    if ($stmt->execute()) {
        header("Location: detail_aduan.php?id=" . $progress['aduan_id']);
        exit();
    } else {
        echo "Gagal mengupdate progres.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Progres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Progres</h2>
    <form method="post">
        <div class="mb-3">
            <label for="deskripsi_progres" class="form-label">Deskripsi Progres</label>
            <textarea name="deskripsi_progres" class="form-control" required><?= htmlspecialchars($progress['deskripsi_progres']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="detail_aduan.php?id=<?= $progress['aduan_id']; ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
