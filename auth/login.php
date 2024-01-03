<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/parsley.css">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <br><br><br><br>
                <div class="card card-body mt-4">
                    <h3 class="text-center">Login</h3>
                    <hr>

                    <?php
                        require('../setting.php');

                        if (isset($_POST["btnLogin"])) {
                            $inputemail = htmlspecialchars($_POST["txtemail"]);
                            $inputpassword = htmlspecialchars($_POST["txtpassword"]);

                            $query = "SELECT * FROM pengguna WHERE email=?";
                            $stmt = mysqli_prepare($link, $query);

                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "s", $inputemail);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result) {
                                    if (mysqli_num_rows($result) == 1) {
                                        $dataUser = mysqli_fetch_object($result);

                                        // Periksa kata sandi dengan password_verify
                                        if (password_verify($inputpassword, $dataUser->password)) {
                                            $_SESSION['login'] = true;
                                            $_SESSION['nama_lengkap'] = $dataUser->nama_lengkap;
                                            $_SESSION['role'] = $dataUser->role;

                                            header('location: ../index.php');
                                            exit();
                                        } else {
                                            echo '<div class="alert alert-danger">Gagal Login, Password tidak sesuai.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger">Gagal Login, Email tidak ditemukan.</div>';
                                    }
                                } else {
                                    die(mysqli_error($link));
                                }
                            } else {
                                die(mysqli_error($link));
                            }
                        }
                    ?>

                    <form action="" method="post" data-parsley-validate="">

                        <input type="email" class="form-control" required name="txtemail" placeholder="Masukkan email">
                        <br>

                        <input type="password" class="form-control mb-2" required name="txtpassword"
                            placeholder="Masukkan password">

                        <a href="../index.php">Log in as guest</a>
                        <br>
                        <input type="submit" class="btn btn-primary mt-2" value="Login" name="btnLogin">

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-mQhYlnJSKZd9Pz+0iYbC8x1vA3ZKLMb2qZ+oQ7RcaZCIMO/JJuAd/Eaa1GC1L+WB"
        crossorigin="anonymous"></script>

</body>

</html>
