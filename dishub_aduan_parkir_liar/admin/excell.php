<?php
session_start();
require 'connect.php';

// Set Header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Aduan_Dishub.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data statistik aduan
$total_aduan = $conn->query("SELECT COUNT(*) as total FROM aduan")->fetch_assoc()['total'];
$aduan_selesai = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Selesai'")->fetch_assoc()['total'];
$aduan_diproses = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diproses'")->fetch_assoc()['total'];
$aduan_diajukan = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status = 'Diajukan'")->fetch_assoc()['total'];

echo "<h2 style='text-align:center;'>Laporan Aduan Dishub</h2>";

// Bagian Statistik
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Total Aduan</th><th>Aduan Selesai</th><th>Aduan Diproses</th><th>Aduan Diajukan</th></tr>";
echo "<tr>
        <td align='center'>$total_aduan</td>
        <td align='center'>$aduan_selesai</td>
        <td align='center'>$aduan_diproses</td>
        <td align='center'>$aduan_diajukan</td>
      </tr>";
echo "</table><br>";

// Ambil data jenis aduan
echo "<h3>Data Jenis Aduan</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>No</th><th>Jenis Aduan</th><th>Jumlah</th></tr>";

$no = 1;
$result = $conn->query("SELECT jenis_aduan, COUNT(*) as jumlah FROM aduan GROUP BY jenis_aduan");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td align='center'>$no</td>
            <td>{$row['jenis_aduan']}</td>
            <td align='center'>{$row['jumlah']}</td>
          </tr>";
    $no++;
}
echo "</table><br>";

// Ambil data lokasi aduan
echo "<h3>Data Lokasi Aduan</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>No</th><th>Lokasi Aduan</th><th>Jumlah</th></tr>";

$no = 1;
$result = $conn->query("SELECT lokasi_aduan, COUNT(*) as jumlah FROM aduan GROUP BY lokasi_aduan");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td align='center'>$no</td>
            <td>{$row['lokasi_aduan']}</td>
            <td align='center'>{$row['jumlah']}</td>
          </tr>";
    $no++;
}
echo "</table><br>";

// Ambil semua data aduan
echo "<h3>Detail Semua Aduan</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>No</th><th>Jenis Aduan</th><th>Lokasi</th><th>Status</th><th>Tanggal</th></tr>";

$no = 1;
$result = $conn->query("SELECT * FROM aduan");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td align='center'>$no</td>
            <td>{$row['jenis_aduan']}</td>
            <td>{$row['lokasi_aduan']}</td>
            <td align='center'>{$row['status']}</td>
            <td align='center'>{$row['tanggal_aduan']}</td>
          </tr>";
    $no++;
}
echo "</table>";

?>
