<?php
session_start();
include 'connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search setup
$search = "";
$where = " WHERE 1=1 ";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND (nama LIKE '%$search%' OR jenis_aduan LIKE '%$search%' 
    OR tanggal_aduan LIKE '%$search%' OR lokasi_aduan 
    LIKE '%$search%' OR status LIKE '%$search%')";
}

// Ambil total data
$total_result = $conn->query("SELECT COUNT(*) AS total FROM aduan $where");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
$pages = ceil($total / $limit);

// Ambil data dengan limit
$result = $conn->query("SELECT * FROM aduan $where LIMIT $start, $limit");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Dishub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .sidebar {
            background-color: #004085;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #007bff;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: black;
        }
        .table thead {
            background-color: #FFC107;
            color: black;
        }
        .table tbody td {
            text-align: left;
        }
        .table tbody td.text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-center text-white">Dishub Admin</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="laporan_statistik.php">Laporan dan Statistik</a>
        <a href="kelola_aduan.php">Kelola Aduan</a>
        <a href="logout.php" class="text-danger">Logout</a>
    </div>
    
    <div class="content-wrapper">
        <div class="container">
            <div class="dashboard-card">
                <h2 class="mb-3">Kelola Aduan</h2>
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($search); ?>" autofocus>
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jenis Aduan</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-center"><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['jenis_aduan']); ?></td>
                                    <td class="text-center"><?= $row['tanggal_aduan']; ?></td>
                                    <td><?= htmlspecialchars($row['lokasi_aduan']); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $row['status'] == 'Selesai' ? 'success' : 
                                        ($row['status'] == 'Diproses' ? 'warning' : 'secondary'); ?>">
                                            <?= $row['status']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['file_pendukung']) { ?>
                                            <a href="../user/<?= $row['file_pendukung']; ?>" target="_blank" 
                                            class="btn btn-info btn-sm btn-custom">Lihat Foto</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="detail_aduan.php?id=<?= $row['id']; ?>&page=<?= $page; ?>&search=<?= urlencode($search); ?>" 
                                        class="btn btn-primary btn-sm">Detail</a>
                                        <a href="update_status.php?id=<?= $row['id']; ?>&status=Diproses&page=<?= $page; ?>&search=<?= urlencode($search); ?>" 
                                        class="btn btn-warning btn-sm">Proses</a>
                                        <a href="update_status.php?id=<?= $row['id']; ?>&status=Selesai&page=<?= $page; ?>&search=<?= urlencode($search); ?>" 
                                        class="btn btn-success btn-sm">Selesai</a>
                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $page - 1; ?>">Sebelumnya</a>
                            </li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $pages; $i++) { ?>
                            <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($page < $pages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $page + 1; ?>">Selanjutnya</a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</body>
</html>