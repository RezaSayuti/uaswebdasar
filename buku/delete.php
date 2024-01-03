<?php
include("../setting.php");

if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM daftarbuku WHERE id=$id";
    mysqli_query($link, $sql);

    // Setelah menghapus, alihkan ke halaman utama atau halaman lain yang diinginkan
    header("Location: read.php");
    exit();
}

?>
