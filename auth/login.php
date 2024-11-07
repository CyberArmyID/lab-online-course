<?php
include "../app/init.php";

if (isset($_SESSION['name'])) {
    header('location:../index.php');
}
if ($_GET['success'] == true) {
    // pesan account sudah di buat 
    $c_error = "alert alert-success alert-dismissible fade show";
    $pesan = "Akun berhasil terdaftar, Silahkan login";
    $hide = " ";
}

if (isset($_POST['submit'])) {
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    $sql = mysqli_query($con, "SELECT * FROM `users` where `email`='$email'");

    if (mysqli_num_rows($sql) === 1) {
        $request = mysqli_fetch_assoc($sql);

        $hashedInputPassword = sha1($password);

        if (hash_equals($hashedInputPassword, $request['password'])) {
            $_SESSION['name'] = $request['name'];
            $_SESSION['email'] = $request['email'];
            header("location: ../index.php");
        } else {
            $c_error = "alert alert-danger alert-dismissible fade show";
            $pesan = "Email Atau Password Salah!";
            $hide = " ";
        }
    } else {
        $c_error = "alert alert-danger alert-dismissible fade show";
        $pesan = "Email Atau Password Salah!";
        $hide = " ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php require "../template/header.php" ?>
</head>

<body style="background:#EAEAEF">
    <?php require "../template/nav.php" ?>
    <div class="mt-3">.</div>

    <!-- product -->
    <section class="features  pb-5 mt-5 mb-4">
        <div class="container  mt-5">
            <div <?= $hide ?> class="<?= $c_error ?> text-center" role="alert">
                <?= $pesan; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row  pt-1 text-center justify-content-center">
                <div class="pagelog  p-5 bg-white">
                    <h2 class="mb-5">Login</h2>
                    <form action="" method="post">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"> <i class="fa fa-envelope"></i></span>
                            </div>
                            <input name="email" required type="text" class="form-control col-lg-12" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></i></span>
                            </div>
                            <input name="password" required type="password" class="form-control" placeholder="password">
                        </div>
                        <div class="daftar text-right">
                            <small>
                                <a href="../auth/forgot-password.php">Lupa password!</a>
                            </small>
                        </div>
                        <button name="submit" class="mt-5 btn btn-primary col-6" type="submit">Login</button>
                        <br><br>
                        <div class="daftar text-right">
                            <small>
                                <a href="../auth/register.php">Belum Punya Akun, Daftar Sekarang !</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- batas  -->

    <?php require "../template/footer.php" ?>
</body>

</html>