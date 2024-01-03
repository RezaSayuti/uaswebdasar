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
    <title>Edit Buku</title>
    <!-- Tambahkan link Bootstrap CSS di sini -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
include("../setting.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $result = mysqli_query($link, "SELECT * FROM daftarbuku WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $judul = mysqli_real_escape_string($link, $_POST["judul"]);
    $genre = mysqli_real_escape_string($link, $_POST["genre"]);
    $penulis = mysqli_real_escape_string($link, $_POST["penulis"]);
    $keterangan = mysqli_real_escape_string($link, $_POST["keterangan"]);
    $tanggal = mysqli_real_escape_string($link, $_POST["tanggal"]);

    $sql = "UPDATE daftarbuku SET judul='$judul', genre='$genre', penulis='$penulis', keterangan='$keterangan', tanggal='$tanggal' WHERE id=$id";
    mysqli_query($link, $sql);
    header("Location: read.php");
    exit();
}
?>

<div class="container mt-5">
    <h2>Edit Buku</h2>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label for="judul">Judul:</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $row['judul']; ?>">
        </div>
        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $row['genre']; ?>">
        </div>
        <div class="form-group">
            <label for="penulis">Penulis:</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $row['penulis']; ?>">
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <select class="form-control" id="keterangan" name="keterangan">
                <option value="Ada" <?php echo ($row['keterangan'] == 'Ada') ? 'selected' : ''; ?>>Ada</option>
                <option value="Tidak Ada" <?php echo ($row['keterangan'] == 'Tidak Ada') ? 'selected' : ''; ?>>Tidak Ada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Terbit:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="read.php" class="btn btn-danger">Cancel</a>
    </form>

</div>

<!-- Tambahkan link Bootstrap JS dan jQuery di sini -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
