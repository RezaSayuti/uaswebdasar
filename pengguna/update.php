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
    <title>Edit Pengguna</title>
    <!-- Tambahkan link Bootstrap CSS di sini -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
    include("../setting.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $result = mysqli_query($link, "SELECT * FROM pengguna WHERE id=$id");
        $row = mysqli_fetch_assoc($result);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $nama_lengkap = mysqli_real_escape_string($link, $_POST["nama_lengkap"]);
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        // Periksa apakah password diubah
        $password = empty($_POST["password"]) ? $row['password'] : password_hash($_POST["password"], PASSWORD_DEFAULT);
        $nohp = mysqli_real_escape_string($link, $_POST["nohp"]);
        $nik = mysqli_real_escape_string($link, $_POST["nik"]);
        $role = mysqli_real_escape_string($link, $_POST["role"]);

        $sql = "UPDATE pengguna SET nama_lengkap='$nama_lengkap', email='$email', password='$password', nohp='$nohp', nik='$nik', role='$role' WHERE id=$id";
        mysqli_query($link, $sql);
        header("Location: read.php");
        exit();
    }
    ?>

    <div class="container mt-5">
        <h2>Edit Pengguna</h2>

        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan password baru">
            </div>
            <div class="form-group">
                <label for="nohp">Nomer Hp:</label>
                <input type="text" class="form-control" name="nohp" value="<?php echo $row['nohp']; ?>" required>
            </div>
            <div class="form-group">
                <label for="nik">Nik:</label>
                <input type="text" class="form-control" name="nik" value="<?php echo $row['nik']; ?>" required>
            </div>
            <div class="form-group">
    <label for="role">Role:</label>
    <select class="form-control" name="role" required>
        <option value="admin" <?php echo ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="user" <?php echo ($row['role'] == 'user') ? 'selected' : ''; ?>>User</option>
    </select>
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
