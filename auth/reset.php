<?php
include "../app/init.php";

if (isset($_SESSION['name'])) {
    header('location:../index.php');
}

if (!isset($_GET['token']) || !isset($_GET['email'])) {
    header('location:../index.php');
}
$token = $_GET['token'];
$sqlToken = mysqli_query($con, "SELECT * FROM `user_tokens` WHERE `token` = '$token'");
if (mysqli_num_rows($sqlToken) < 1) {
    header('location:../index.php');
}

if (isset($_POST['submit'])) {
    $email = strtolower(htmlspecialchars($_GET['email']));

    $sql = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");

    if (mysqli_num_rows($sql) === 1) {
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        if ($password === $password_confirmation) {
            // Enkripsi password dengan SHA1
            $hashed_password = sha1($password);

            // Update password pada tabel users
            $query = "UPDATE `users` SET `password` = '$hashed_password' WHERE `email` = '$email'";
            mysqli_query($con, $query);

            $sqlDeleteToken = mysqli_query($con, "DELETE FROM `user_tokens` WHERE `token` = '$token'");

            // Redirect setelah password berhasil direset
            header('Location: ./login.php?status=reset-password-success');
            exit(); // Menghentikan eksekusi script setelah redirect
        } else {
            // Jika password tidak sesuai
            $c_error = "alert alert-danger alert-dismissible fade show";
            $pesan = "Konfirmasi password tidak cocok. Silakan coba lagi.";
            $hide = " ";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online</title>
    <?php require "../template/header.php" ?>
</head>

<body style="background:#EAEAEF">
    <!-- Navbar  -->
    <?php require "../template/nav.php" ?>
    <!-- akhir Nav -->
    <div class="mt-3">.</div>
    <!-- product -->
    <section class="features   mt-5 mb-4">
        <div class="container  mt-5">
            <div <?= $hide ?> class="<?= $c_error ?> text-center" role="alert">
                <?= $pesan; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row mt-4 text-center justify-content-center">
                <div class="pagelog  p-5 bg-white">
                    <h2 class="mb-5">Password baru</h2>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></i></span>
                            </div>
                            <input required name="password" type="password" class="form-control" placeholder="password">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></i></span>
                            </div>
                            <input required name="password_confirmation" type="password" class="form-control" placeholder="Konfirmasi password">
                        </div>
                        <button name="submit" class="mt-5 btn btn-primary col-6" type="submit"> Update password</button>
                        <br><br>
                        <div class="daftar text-right">
                            <small>
                                <a href="./login.php"> Login Sekarang !</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- batas  -->

    <?php include "../template/footer.php" ?>
</body>

</html>