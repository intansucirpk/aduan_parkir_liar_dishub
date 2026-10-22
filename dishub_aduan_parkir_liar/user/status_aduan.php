<?php
include 'connect.php';

$status_message = '';
$aduan_list = [];
$aduan_progress = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Ambil data aduan berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM aduan WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $aduan_list = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $status_message = "Tidak ada aduan yang ditemukan untuk email ini.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Aduan - Dinas Perhubungan Bangkalan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .navbar {
            background-color: #2E3192;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #FFFFFF;
            font-weight: bold;
            font-size: 18px;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            text-decoration: underline;
        }
        .navbar-brand img {
            width: 300px;
        }
        .hero {
            background: linear-gradient(rgba(0, 79, 113, 0.8), rgba(0, 79, 113, 0.8)), url('https://via.placeholder.com/1920x600') no-repeat center center/cover;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }
        .container2 {
            max-width: 800px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            margin: 50px auto; 
            text-align: center; 
            margin-bottom: 22rem;
        }
        h2 {
            color: #004F71;
            text-align: center;
        }
        .btn-primary {
            background-color: #004F71;
            border: none;
        }
        .btn-primary:hover {
            background-color: #002F47;
        }
        .table th {
            background-color: #004F71;
            color: #ffffff;
        }
        footer {
            background-color: #1E3A8A;
            padding: 2rem 0;
        }
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
            padding: 0 2rem;
        }
        .footer-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 300px;
        }
        .footer-left img {
            width: 80px;
            margin-bottom: 10px;
        }
        .footer-left p {
            font-size: 14px;
            line-height: 1.5;
            color: white;
        }
        .footer-middle {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .footer-middle iframe {
            width: 320px;
            height: 220px;
            border: none;
        }
        .footer-right {
            max-width: 300px;
            text-align: left;
        }
        .footer-right p {
            margin: 5px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            color: white;
        }
        .footer-right i {
            color: #FFD700;
            margin-right: 10px;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid white;
            font-size: 14px;
            margin-top: 10px;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="gambar/LOGODISHUB2.png" alt="Dishub Logo" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form_aduan.php">Ajukan Aduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="status_aduan.php">Lihat Status Aduan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- STATUS ADUAN -->
    <div class="container2">
        <h2>Status Aduan</h2>
        <form method="post" action="status_aduan.php">
            <div class="mb-3">
                <label for="email" class="form-label">Masukkan Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Anda" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cek Status</button>
        </form>

        <?php if (!empty($status_message)): ?>
            <div class="alert alert-warning mt-3 text-center"> <?= $status_message; ?> </div>
        <?php endif; ?>

        <?php if (!empty($aduan_list)): ?>
            <table class="table table-bordered mt-3 text-center">
                <thead>
                    <tr>
                        <th>Nomor Aduan</th>
                        <th>Jenis Aduan</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal Aduan</th>
                        <th>Lihat Progres</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aduan_list as $aduan): ?>
                        <tr>
                            <td><?= htmlspecialchars($aduan['id']); ?></td>
                            <td><?= htmlspecialchars($aduan['jenis_aduan']); ?></td>
                            <td><?= htmlspecialchars($aduan['deskripsi']); ?></td>
                            <td><span class="badge bg-<?= ($aduan['status'] == 'Diproses') ? 'warning' : (($aduan['status'] == 'Selesai') ? 'success' : 'secondary'); ?>">
                                <?= htmlspecialchars($aduan['status']); ?></span>
                            </td>
                            <td><?= htmlspecialchars($aduan['tanggal_aduan']); ?></td>
                            <td>
                                <a href="progres_aduan.php?id=<?= $aduan['id']; ?>" class="btn btn-info btn-sm">Progres</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

        <!-- Footer -->
        <footer>
        <div class="footer-container">
            <div class="footer-left">
                <img src="gambar/logo-dishub.png" alt="Logo Dishub">

                <p>Website Resmi Dinas Perhubungan Kabupaten Bangkalan, Provinsi Jawa Timur</p>
            </div>
            <div class="footer-middle">
                <iframe src="https://maps.google.com/maps?q=Dinas%20Perhubungan%20Bangkalan&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            </div>
            <div class="footer-right">
                <p><i class="fas fa-map-marker-alt"></i> Jalan R.E. Marthadinata No.7, Wr 05, Mlajah, Kec. Bangkalan, Kabupaten Bangkalan, Jawa Timur 69116</p>
                <p><i class="fas fa-phone-alt"></i> 031 3094951</p>
                <p><i class="fas fa-envelope"></i> dishub@bangkalankab.go.id</p>
            </div>
        </div>
        <div class="footer-bottom">
            Copyright 2025 &copy; All rights reserved | Dinas Perhubungan Kabupaten Bangkalan
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

