<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Jika belum login, redirect ke halaman login
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengguna</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <?php
    include("../setting.php"); // File konfigurasi koneksi database

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_lengkap = mysqli_real_escape_string($link, $_POST["nama_lengkap"]);
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $password = mysqli_real_escape_string($link, $_POST["password"]);
        $nohp = mysqli_real_escape_string($link, $_POST["nohp"]);
        $nik = mysqli_real_escape_string($link, $_POST["nik"]);
        $role = mysqli_real_escape_string($link, $_POST["role"]);

        // Menggunakan password_hash untuk mengenkripsi kata sandi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query menggunakan parameter untuk mencegah SQL Injection
        $query = "INSERT INTO pengguna (nama_lengkap, email, password, nohp, nik, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $nama_lengkap, $email, $hashed_password, $nohp, $nik, $role);
            mysqli_stmt_execute($stmt);

            $_SESSION['message'] = "Pengguna berhasil ditambahkan";
            header("Location: read.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
    ?>

    <div class="container mt-5">
        <h2>Tambah Data Pengguna</h2>

        <form method="post" action="">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="nohp">Nomor HP:</label>
                <input type="text" class="form-control" id="nohp" name="nohp" required>
            </div>

            <div class="form-group">
                <label for="nik">NIK:</label>
                <input type="text" class="form-control" id="nik" name="nik" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
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
