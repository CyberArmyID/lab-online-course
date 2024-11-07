<?php
include "../app/init.php";

if (isset($_SESSION['name'])) {
    header('location:../index.php');
}

if (isset($_POST['submit'])) {
    $email = strtolower(htmlspecialchars($_POST['email']));

    $sql = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password = sha1($password);
    $img = "https://static.vecteezy.com/system/resources/previews/036/280/650/large_2x/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg";
    if (mysqli_num_rows($sql) === 1) {
        $c_error = "alert alert-danger alert-dismissible fade show";
        $pesan = "Email <b class='text-primary' >" . $email .  "</b> Sudah Terdaftar";
        $hide = " ";
    } else {
        if ($name != null & $password != null & $email != null) {
            $query = "INSERT INTO `users` (`name`, `email`, `password`, `avatar`) VALUES ('$name', '$email', '$password', '$img')";
            mysqli_query($con, $query);
            header('Location:./login.php?success=true');
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
                    <h2 class="mb-5">Register</h2>
                    <form action="" method="post">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-alt"></i></i></span>
                            </div>
                            <input required name="name" type="text" class="form-control" placeholder="name">
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input required name="email" type="text" class="form-control" placeholder="Email">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></i></span>
                            </div>
                            <input required name="password" type="password" class="form-control" placeholder="password">
                        </div>
                        <button name="submit" class="mt-5 btn btn-primary col-6" type="submit"> Register</button>
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