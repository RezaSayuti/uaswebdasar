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
    <title>CRUD Pengguna</title>
    <!-- Tambahkan link Bootstrap CSS di sini -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
include("../setting.php"); // File konfigurasi koneksi database
$no = 1;

// Menampilkan pesan setelah operasi CRUD
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
            ' . $_SESSION['message'] . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    unset($_SESSION['message']);
}

// Menampilkan data pengguna
$query = "SELECT * FROM pengguna";
$result = mysqli_query($link, $query);
?>

<div class="container mt-5">
    <h2 class="mb-4">Daftar Pengguna</h2>

    <a href="create.php" class="btn btn-primary mb-3">Tambah Pengguna</a>
    <a href="../buku/viewuser.php" class="btn btn-success mb-3">Tampilan Utama</a>
    <a href="../buku/read.php" class="btn btn-warning mb-3">Daftar Buku</a>
    <a href="../peminjaman/read.php" class="btn btn-danger mb-3">Peminjaman</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Nomer Hp</th>
                <th>Nik</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_lengkap']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nohp']; ?></td>
                    <td><?php echo $row['nik']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Ubah</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Tambahkan link Bootstrap JS dan jQuery di sini -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
