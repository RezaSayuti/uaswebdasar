<?php
session_start();

include("../setting.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data buku
    $resultBuku = mysqli_query($link, "SELECT * FROM daftarbuku WHERE id = $id");
    $rowBuku = mysqli_fetch_assoc($resultBuku);

    // Query untuk mendapatkan data peminjaman
    $resultPeminjaman = mysqli_query($link, "SELECT peminjaman.*, pengguna.nama_lengkap 
                                            FROM peminjaman
                                            INNER JOIN pengguna ON peminjaman.pengguna_id = pengguna.id
                                            WHERE peminjaman.buku_id = $id
                                            ORDER BY peminjaman.tanggal_peminjaman DESC
                                            LIMIT 1");
    $rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

    // Simpan nama lengkap ke dalam session
    $namaLengkap = isset($rowPeminjaman['nama_lengkap']) ? $rowPeminjaman['nama_lengkap'] : 'Tidak Ada';

    // Format tanggal peminjaman dan pengembalian
    $tanggalPeminjaman = isset($rowPeminjaman['tanggal_peminjaman']) ? date('d/m/Y', strtotime($rowPeminjaman['tanggal_peminjaman'])) : 'Tidak Ada';
    $tanggalPengembalian = isset($rowPeminjaman['tanggal_pengembalian']) ? date('d/m/Y', strtotime($rowPeminjaman['tanggal_pengembalian'])) : 'Tidak Ada';

} else {
    // Redirect to read.php jika ID tidak diberikan
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Detail Buku</h2>

    <form>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Judul</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $rowBuku['judul']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Genre</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $rowBuku['genre']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Penulis</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $rowBuku['penulis']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
    <label class="col-sm-3 col-form-label">Tanggal Terbit</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" value="<?php echo isset($rowBuku['tanggal']) ? date('d/m/Y', strtotime($rowBuku['tanggal'])) : 'Tidak Ada'; ?>" readonly>
    </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Nama Peminjam</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $namaLengkap; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tanggal Peminjaman</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $tanggalPeminjaman; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tanggal Pengembalian</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $tanggalPengembalian; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Keterangan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo isset($rowBuku['keterangan']) ? ($rowBuku['keterangan'] ? $rowBuku['keterangan'] : 'Tidak Ada') : 'Tidak Ada'; ?>" readonly>
            </div>
        </div>

        <a href="viewuser.php" class="btn btn-secondary mt-3">Kembali ke Daftar Buku</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


