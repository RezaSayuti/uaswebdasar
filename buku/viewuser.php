<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Courses - Mentor Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Mentor
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>


  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php">Perpustakaan UBG</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo me-auto"><img src="../assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../about.php">About</a></li>
          <li><a class="active" href="viewuser.php">Book List</a></li>
          <li><a href="history.php">History</a></li>
          
          <li class="dropdown">
  <?php
  // Cek apakah pengguna adalah admin
  if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo '
    <a href="#" class="nav-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span>Edit</span> <i class="bi bi-chevron-down"></i>
  </a>
  <ul class="dropdown-menu">
    <li class="dropdown"><a href="read.php" class="dropdown-item"><span>Book List</span> <i class="bi bi-chevron-right"></i></a></li>
    <li class="dropdown"><a href="../peminjaman/read.php" class="dropdown-item"><span>Booking</span> <i class="bi bi-chevron-right"></i></a></li>
    <li class="dropdown"><a href="../pengguna/read.php" class="dropdown-item"><span>User</span> <i class="bi bi-chevron-right"></i></a></li>
  </ul>
  
    ';
  }
  ?>
</li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <div class="dropdown">
        <?php

        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
          // If the user is logged in, display their name and a "Log Out" button
          $nama_lengkap = $_SESSION['nama_lengkap'];
          echo '
            <button class="btn get-started-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Hai ' . $nama_lengkap . '!
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="../auth/logout.php">Log Out</a>
            </div>
          ';
        } else {
          // If the user is not logged in, display a "Log In" button
          echo '
            <a class="btn get-started-btn" href="../auth/login.php">Log In</a>
          ';
        }
        ?>
      </div>

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-in">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">
        <h2>Book</h2>
        <p>Menikmati kisah penuh petualangan dan misteri, sebuah buku dapat membawa pembaca ke dunia yang penuh imajinasi. Halaman demi halaman, membaca adalah jendela ke pengetahuan dan hiburan. Setiap buku adalah perjalanan yang unik, mengungkapkan cerita dan pengalaman yang menarik.</p>
      </div>
    </div><!-- End Breadcrumbs -->

<?php
include("../setting.php");
$no = 1;

$result = mysqli_query($link, "SELECT * FROM daftarbuku");
?>

<div class="container mt-5">
    <table class="table table-bordered">
        <thead class="table table-secondary">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Penulis</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        
<tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['genre']; ?></td>
            <td><?php echo $row['penulis']; ?></td>
            <td><?php echo isset($row['keterangan']) ? ($row['keterangan'] ? $row['keterangan'] : 'Tidak Ada') : 'Tidak Ada'; ?></td>
            <td><a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">Detail</a></td>
        </tr>
    <?php } ?>
</tbody>

    </table>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>Mentor</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>