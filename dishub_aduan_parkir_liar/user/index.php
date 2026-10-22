<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Dinas Perhubungan Bangkalan</title>
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
            background: linear-gradient(rgba(30, 58, 138, 0.8), rgba(30, 58, 138, 0.8));
            background-size: cover;
            height: 65vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            text-align: center;
            padding: 0 15px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.3rem;
            margin-top: 1rem;
        }

        .btn-primary {
            background-color: #FFD700;
            border: none;
            color: #1E3A8A;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #FFC107;
        }

        .features {
            padding: 4rem 0;
            background-color: #ffffff;
        }

        .features h2 {
            color: #1E3A8A;
            margin-bottom: 2rem;
            text-align: center;
        }

        .card {
            border-radius: 10px;
        }

        footer {
            background-color: #1E3A8A;
            padding: 3rem 0;
            color: white;
        }
        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .footer-left img {
            width: 100px;
            margin-bottom: 15px;
        }
        .footer-right p, .footer-bottom {
            font-size: 14px;
            color: #f8f9fa;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Toggle navigation">
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

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Selamat Datang di Dinas Perhubungan Bangkalan</h1>
            <p>Sistem Aduan Online untuk Pelayanan yang Lebih Baik</p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container features text-center">
        <h2>Pelayanan Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-4x mb-3 text-primary"></i>
                        <h5 class="card-title">Ajukan Aduan</h5>
                        <p class="card-text">Kami menyediakan kemudahan untuk Anda mengajukan keluhan secara online.</p>
                        <a href="form_aduan.php" class="btn btn-primary">Ajukan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-search fa-4x mb-3 text-primary"></i>
                        <h5 class="card-title">Lacak Aduan</h5>
                        <p class="card-text">Lacak status aduan Anda kapan saja dan di mana saja dengan sistem kami.</p>
                        <a href="status_aduan.php" class="btn btn-primary">Lacak Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
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