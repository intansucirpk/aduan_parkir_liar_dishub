<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM aduan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $aduan = $result->fetch_assoc();

    // Ambil data progres
    $stmt_progress = $conn->prepare("SELECT * FROM aduan_progress WHERE aduan_id = ? ORDER BY tanggal ASC");
    $stmt_progress->bind_param("i", $id);
    $stmt_progress->execute();
    $result_progress = $stmt_progress->get_result();
} else {
    header('Location: kelola_aduan.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aduan - Dishub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
            max-width: 900px;
        }
        h2 {
            color: #0d6efd;
            font-weight: bold;
            text-align: center;
        }
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background: #0d6efd;
            color: white;
            text-align: center;
        }
        .table th, .table td {
            padding: 12px;
        }
        .status-badge {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-custom {
            padding: 10px 20px;
            font-size: 14px;
        }
        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Detail Aduan</h2>
    <hr>
    <p><strong>Nama:</strong> <?= htmlspecialchars($aduan['nama']); ?></p>
    <p><strong>Jenis Aduan:</strong> <?= htmlspecialchars($aduan['jenis_aduan']); ?></p>
    <p><strong>Status:</strong> <span class="badge bg-<?= $aduan['status'] == 'Selesai' ? 'success' : ($aduan['status'] == 'Diproses' ? 'warning' : 'secondary'); ?>">
        <?= htmlspecialchars($aduan['status']); ?></span>
    </p>


    <h4 class="mt-4">Progres Aduan</h4>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal & Waktu</th>
            <th>Progres</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($progress = $result_progress->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($progress['tanggal']); ?></td>
                <td><?= htmlspecialchars($progress['deskripsi_progres']); ?></td>
                <td class="text-center">
                    <a href="edit_progres.php?id=<?= $progress['id']; ?>" 
                    class="btn btn-sm btn-primary" 
                    title="Edit Progres">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="hapus_progres.php?id=<?= $progress['id']; ?>" 
                    onclick="return confirm('Yakin ingin menghapus progres ini?');" 
                    class="btn btn-sm btn-danger" 
                    title="Hapus Progres">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>



    </table>

    <form action="tambah_progres.php" method="post" class="mt-3">
        <input type="hidden" name="aduan_id" value="<?= $aduan['id']; ?>">
        <div class="mb-2">
            <textarea name="deskripsi_progres" class="form-control" required placeholder="Tambahkan progres..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan Progres</button>
    </form>

    <div class="button-group">
        <a href="update_status.php?id=<?= $aduan['id']; ?>&status=Diproses&redirect=progres_aduan.php?id=<?= $aduan['id']; ?>" class="btn btn-warning">Tandai Proses</a>
        <a href="update_status.php?id=<?= $aduan['id']; ?>&status=Selesai&redirect=progres_aduan.php?id=<?= $aduan['id']; ?>" class="btn btn-success">Tandai Selesai</a>
    </div>
</div>
</body>
</html>
