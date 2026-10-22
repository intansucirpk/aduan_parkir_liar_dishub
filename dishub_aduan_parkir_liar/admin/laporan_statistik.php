<?php
session_start();
include 'connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

// Ambil data statistik
$total_aduan = $conn->query("SELECT COUNT(*) as total FROM aduan")->fetch_assoc()['total'];
$aduan_selesai = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Selesai'")->fetch_assoc()['total'];
$aduan_diproses = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diproses'")->fetch_assoc()['total'];
$aduan_diajukan = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diajukan'")->fetch_assoc()['total'];

$jenis_aduan = $conn->query("SELECT jenis_aduan, COUNT(*) as jumlah FROM aduan GROUP BY jenis_aduan");
$lokasi_aduan = $conn->query("SELECT lokasi_aduan, COUNT(*) as jumlah FROM aduan GROUP BY lokasi_aduan");

// Simpan hasil query jenis aduan dalam array
$jenis_aduan_data = [];
$result = $conn->query("SELECT jenis_aduan, COUNT(*) as jumlah FROM aduan GROUP BY jenis_aduan");
while ($row = $result->fetch_assoc()) {
    $jenis_aduan_data[] = $row;
}

// Ambil data untuk grafik batang
$labels = array_column($jenis_aduan_data, 'jenis_aduan');
$data = array_column($jenis_aduan_data, 'jumlah');

// Simpan hasil query lokasi aduan dalam array
$lokasi_aduan_data = [];
$result_lokasi = $conn->query("SELECT lokasi_aduan, COUNT(*) as jumlah FROM aduan GROUP BY lokasi_aduan");
while ($row = $result_lokasi->fetch_assoc()) {
    $lokasi_aduan_data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan dan Statistik Aduan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #002752;
        }
        .navbar-brand {
            font-weight: bold;
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
            margin-bottom: 20px;
        }
        .table thead {
            background-color: #FFC107;
            color: black;
            text-align: center;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:nth-child(even) {
            background-color: #e6e6e6;
        }
        .card {
            border: none;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            color: white;
            margin-bottom: 15px;
        }
        .card-primary { background: #007bff; }
        .card-success { background: #28a745; }
        .card-warning { background: #ff9800; }
        .card-danger { background: #dc3545; }
        .chart-container {
            max-width: 900px;
            margin: 20px auto;
        }
        canvas {
            width: 100% !important; 
            height: 400px !important;
        }
        .table thead th {
            text-align: center;
        }
        .table tbody td:first-child, .table tbody td:last-child {
            text-align: center;
        }
        .table tbody td:nth-child(2) {
            text-align: left;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .mb-4 {
            margin-bottom: 30px !important;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Dishub Admin</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="laporan_statistik.php">Laporan dan Statistik</a>
        <a href="kelola_aduan.php">Kelola Aduan</a>
        <a href="logout.php" class="text-danger">Logout</a>
    </div>

    <!-- Konten utama -->
    <div class="content-wrapper">
        <h2 class="text-center mb-4">Laporan dan Statistik Aduan</h2>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-primary">
                    <h5>Total Aduan</h5>
                    <h3><?= $total_aduan; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-success">
                    <h5>Aduan Selesai</h5>
                    <h3><?= $aduan_selesai; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-warning">
                    <h5>Aduan Diproses</h5>
                    <h3><?= $aduan_diproses; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-danger">
                    <h5>Aduan Diajukan</h5>
                    <h3><?= $aduan_diajukan; ?></h3>
                </div>
            </div>
        </div>

        <h3 class="mb-4">Diagram Batang Jenis Aduan</h3>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>

        <h3 class="mb-4">Tabel Jenis Aduan</h3>
        <table class="table table-bordered" id="tableJenisAduan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Aduan</th>
                    <th class="text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; // Inisialisasi nomor
                foreach ($jenis_aduan_data as $row) { ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td> 
                        <td><?= $row['jenis_aduan']; ?></td>
                        <td class="text-center"><?= $row['jumlah']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3 class="mb-4">Tabel Lokasi Aduan</h3>
        <table class="table table-bordered" id="tableLokasiAduan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th class="text-center">Jumlah Aduan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                foreach ($lokasi_aduan_data as $row) { ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td> 
                        <td><?= $row['lokasi_aduan']; ?></td>
                        <td class="text-center"><?= $row['jumlah']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <div class="text-end mb-3">
            <a href="excell.php" class="btn btn-success">Export Excel</a>
            <!-- <a href="pdf.php" class="btn btn-danger">Export PDF</a> -->
        </div>
    </div>

    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels); ?>, 
                datasets: [{
                    label: 'Jumlah Aduan per Jenis',
                    data: <?= json_encode($data); ?>, 
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', 
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $(document).ready(function() {
            $('#tableJenisAduan').DataTable();
            $('#tableLokasiAduan').DataTable();
        });
    </script>

</body>
</html>
