<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Jika belum login, redirect ke halaman login
    header('location: login.php');
    exit();
}

// Periksa apakah pengguna memiliki role "admin"
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak memiliki role "admin," redirect ke halaman lain atau tampilkan pesan akses ditolak
    header('location: ../index.php');
    exit();
}

include("../setting.php");

// Query untuk mendapatkan data judul dan nama lengkap dari tabel yang direlasikan
$query = "SELECT peminjaman.*, daftarbuku.judul, pengguna.nama_lengkap 
          FROM peminjaman
          INNER JOIN daftarbuku ON peminjaman.buku_id = daftarbuku.id
          INNER JOIN pengguna ON peminjaman.pengguna_id = pengguna.id
          ORDER BY peminjaman.tanggal_peminjaman";

$result = $link->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Data Peminjaman Buku</h2>
    <a href="create.php" class="btn btn-primary mb-3">Tambah</a>
    <a href="../buku/viewuser.php" class="btn btn-success mb-3">Tampilan Utama</a>
    <a href="../buku/read.php" class="btn btn-warning mb-3">Daftar Buku</a>
    <a href="../pengguna/read.php" class="btn btn-danger mb-3">Pengguna</a>

    <?php
    if ($result) {
        echo '<table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>';

        $no = 1;
        while ($row = $result->fetch_assoc()) {
            // Simpan nama lengkap ke dalam session
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];

            $tanggalPeminjaman = date('d/m/Y', strtotime($row['tanggal_peminjaman']));
            $tanggalPengembalian = date('d/m/Y', strtotime($row['tanggal_pengembalian']));

            echo '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $row['nama_lengkap'] . '</td>
                    <td>' . $row['judul'] . '</td>
                    <td>' . $tanggalPeminjaman . '</td>
                    <td>' . $tanggalPengembalian . '</td>
                    <td>' . $row['catatan'] . '</td>
                    <td>
                        <a href="update.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "Error: " . $query . "<br>" . $link->error;
    }

    $link->close();
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
