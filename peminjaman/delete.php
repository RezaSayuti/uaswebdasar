<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Jika belum login, redirect ke halaman login
    header('location: login.php');
    exit();
}

include("../setting.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM peminjaman WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if ($result) {
        header("Location: read.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($link);
    }
}

$link->close();
?>
