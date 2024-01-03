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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
include("../setting.php"); // File konfigurasi koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($link, $_POST["judul"]);
    $genre = mysqli_real_escape_string($link, $_POST["genre"]);
    $penulis = mysqli_real_escape_string($link, $_POST["penulis"]);
    $keterangan = mysqli_real_escape_string($link, $_POST["keterangan"]);
    $tanggal = mysqli_real_escape_string($link, $_POST["tanggal"]);

    // Query untuk menambahkan data buku
    $query = "INSERT INTO daftarbuku (judul, genre, penulis, keterangan, tanggal) VALUES ('$judul', '$genre', '$penulis', '$keterangan', '$tanggal')";
    if (mysqli_query($link, $query)) {
        $_SESSION['message'] = "Buku berhasil ditambahkan";
        header("Location: read.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }
}
?>

<div class="container mt-5">
    <h2>Tambah Data Buku</h2>

    <form method="post" action="">
        <div class="form-group">
            <label for="judul">Judul:</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>

        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>

        <div class="form-group">
            <label for="penulis">Penulis:</label>
            <input type="text" class="form-control" id="penulis" name="penulis" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <select class="form-control" id="keterangan" name="keterangan" required>
                <option value="Ada">Ada</option>
                <option value="Tidak Ada">Tidak Ada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Terbit:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah</button>
        <a href="read.php" class="btn btn-danger">Cancel</a>
    </form>

</div>

<!-- Bootstrap JS and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
