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
    <title>Edit Peminjaman</title>
    <!-- Tambahkan link Bootstrap CSS di sini -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    include("../setting.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $result = mysqli_query($link, "SELECT * FROM peminjaman WHERE id=$id");
        $row = mysqli_fetch_assoc($result);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $pengguna_id = mysqli_real_escape_string($link, $_POST["pengguna_id"]);
        $buku_id = mysqli_real_escape_string($link, $_POST["buku_id"]);
        $tanggal_peminjaman = mysqli_real_escape_string($link, $_POST["tanggal_peminjaman"]);
        $tanggal_pengembalian = mysqli_real_escape_string($link, $_POST["tanggal_pengembalian"]);
        $catatan = mysqli_real_escape_string($link, $_POST["catatan"]);

        $sql = "UPDATE peminjaman SET pengguna_id='$pengguna_id', buku_id='$buku_id', tanggal_peminjaman='$tanggal_peminjaman', tanggal_pengembalian='$tanggal_pengembalian', catatan='$catatan' WHERE id=$id";
        
        if (mysqli_query($link, $sql)) {
            header("Location: read.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($link);
        }
    }
    ?>

    <div class="container mt-5">
        <h2>Edit Peminjaman</h2>

        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="pengguna_id">Nama Lengkap:</label>
                <select class="form-control" name="pengguna_id" required>
                    <?php
                    // Query untuk mendapatkan data pengguna
                    $queryPengguna = "SELECT id, nama_lengkap FROM pengguna";
                    $resultPengguna = mysqli_query($link, $queryPengguna);

                    // Periksa apakah query pengguna berhasil
                    if (!$resultPengguna) {
                        die('Error: ' . mysqli_error($link));
                    }

                    // Pastikan ada data pengguna
                    if (mysqli_num_rows($resultPengguna) > 0) {
                        while ($rowPengguna = mysqli_fetch_assoc($resultPengguna)) {
                            $selected = ($rowPengguna['id'] == $row['pengguna_id']) ? 'selected' : '';
                            echo '<option value="' . $rowPengguna['id'] . '" ' . $selected . '>' . $rowPengguna['nama_lengkap'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>No users available</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="buku_id">Judul:</label>
                <select class="form-control" name="buku_id" required>
                    <?php
                    // Query untuk mendapatkan data buku
                    $queryBuku = "SELECT id, judul FROM daftarbuku";
                    $resultBuku = mysqli_query($link, $queryBuku);

                    // Periksa apakah query buku berhasil
                    if (!$resultBuku) {
                        die('Error: ' . mysqli_error($link));
                    }

                    // Pastikan ada data buku
                    if (mysqli_num_rows($resultBuku) > 0) {
                        while ($rowBuku = mysqli_fetch_assoc($resultBuku)) {
                            $selected = ($rowBuku['id'] == $row['buku_id']) ? 'selected' : '';
                            echo '<option value="' . $rowBuku['id'] . '" ' . $selected . '>' . $rowBuku['judul'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>No books available</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_peminjaman">Tanggal Peminjaman:</label>
                <input type="date" class="form-control" name="tanggal_peminjaman" value="<?php echo isset($row['tanggal_peminjaman']) ? $row['tanggal_peminjaman'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
                <input type="date" class="form-control" name="tanggal_pengembalian" value="<?php echo isset($row['tanggal_pengembalian']) ? $row['tanggal_pengembalian'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="catatan">Catatan:</label>
                <input type="text" class="form-control" name="catatan" value="<?php echo isset($row['catatan']) ? $row['catatan'] : ''; ?>" required>
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
