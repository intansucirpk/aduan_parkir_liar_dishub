<?php
include 'connect.php';

if (!isset($_GET['id'])) {
    header('Location: status_aduan.php');
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM aduan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$aduan = $result->fetch_assoc();

if (!$aduan) {
    echo "<div class='alert alert-danger'>Aduan tidak ditemukan.</div>";
    exit();
}

$stmt_progress = $conn->prepare("SELECT * FROM aduan_progress WHERE aduan_id = ? ORDER BY tanggal ASC");
$stmt_progress->bind_param("i", $id);
$stmt_progress->execute();
$result_progress = $stmt_progress->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progres Aduan - Dishub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 90%;
            margin: auto;
            padding: 20px;
        }
        .header {
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #0d6efd;
    
        }
        .badge {
            font-size: 1rem;
            padding: 8px 12px;
        }
        .table {
            margin-top: 20px;
            background-color: white;
        }
        .table th {
            background: #0d6efd;
            color: white;
            text-align: center;
        }
        .table th, .table td {
            padding: 12px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .back-btn {
            margin-top: 20px;
        }
        .table td:first-child {
            width: 200px;
            text-align: center;
        }
        .table td:last-child {
            text-align: justify;
        }

    </style>
</head>
<body>
    <div class="header">Progres Aduan - Dinas Perhubungan</div>
    <div class="container">
        <p><strong>Nomor Aduan:</strong> <?= htmlspecialchars($aduan['id']); ?></p>
        <p><strong>Nama:</strong> <?= htmlspecialchars($aduan['nama']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($aduan['email']); ?></p>
        <p><strong>Jenis Aduan:</strong> <?= htmlspecialchars($aduan['jenis_aduan']); ?></p>
        <p><strong>Status:</strong> <span class="badge bg-<?= $aduan['status'] == 'Selesai' ? 'success' : ($aduan['status'] == 'Diproses' ? 'warning' : 'secondary'); ?>">
            <?= htmlspecialchars($aduan['status']); ?></span></p>
        
        <h4 class="mt-4">Riwayat Progres</h4>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal & Waktu</th>
                    <th>Progres</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($progress = $result_progress->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($progress['tanggal']); ?></td>
                        <td><?= htmlspecialchars($progress['deskripsi_progres']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="javascript:history.back()" class="btn btn-secondary back-btn">Kembali</a>
    </div>
</body>
</html>