<?php
session_start();
include 'connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}

// Ambil statistik aduan
$total_aduan = $conn->query("SELECT COUNT(*) as total FROM aduan")->fetch_assoc()['total'];
$aduan_selesai = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Selesai'")->fetch_assoc()['total'];
$aduan_diproses = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diproses'")->fetch_assoc()['total'];
$aduan_diajukan = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diajukan'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #004085; /* Biru Dishub */
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
            background-color: #007bff; /* Biru terang untuk hover */
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .card .card-body {
            color: white;
        }
        .card-primary { background: #007bff; }
        .card-success { background: #28a745; }
        .card-warning { background: #ffc107; }
        .card-danger { background: #dc3545; }
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

    <!-- Konten Utama -->
    <div class="content-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- <a class="navbar-brand" href="#">Dashboard</a> -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <h2 class="text-center mb-4">Dashboard Admin</h2>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-body">
                        <h5>Total Aduan</h5>
                        <h3><?= $total_aduan; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-success">
                    <div class="card-body">
                        <h5>Aduan Selesai</h5>
                        <h3><?= $aduan_selesai; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-warning">
                    <div class="card-body">
                        <h5>Aduan Diproses</h5>
                        <h3><?= $aduan_diproses; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-danger">
                    <div class="card-body">
                        <h5>Aduan Diajukan</h5>
                        <h3><?= $aduan_diajukan; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <h3>Grafik Statistik Aduan</h3>
        <div class="chart-container mb-4">
            <canvas id="aduanChart"></canvas>
        </div>

        <script>
        var ctx = document.getElementById('aduanChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Diajukan', 'Diproses', 'Selesai'],
                datasets: [{
                    label: 'Jumlah Aduan',
                    data: [<?= $aduan_diajukan; ?>, <?= $aduan_diproses; ?>, <?= $aduan_selesai; ?>],
                    backgroundColor: ['#FF6347', '#FFA500', '#32CD32'],
                    borderColor: ['#FFF', '#FFF', '#FFF'],
                    borderWidth: 2
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var label = tooltipItem.label;
                                var value = tooltipItem.raw;
                                return label + ': ' + value + ' Aduan';
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                },
                cutout: '40%', // Menambahkan space di tengah untuk membuat grafik lebih menarik
            }
        });
    </script>

        <h3>Aduan Terbaru</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Aduan</th>
                    <th>Jenis Aduan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = $conn->query("SELECT * FROM aduan ORDER BY tanggal_aduan DESC LIMIT 10");
                    $no = 1; // Inisialisasi nomor urut
                    while ($row = $query->fetch_assoc()) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['id']}</td>
                            <td>{$row['jenis_aduan']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['tanggal_aduan']}</td>
                        </tr>";
                        $no++; 
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
