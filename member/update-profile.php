<?php
include "../app/init.php";

if (!isset($_SESSION['role'])) {
    header('location:index.php');
}

$email = $_SESSION['email'];
$data = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email' ");
$user = mysqli_fetch_assoc($data);
$id = $user['id'];

// eksekusi
if (isset($_POST['submit'])) {

    $name = $con->real_escape_string($_POST['name']);
    $email = $user['email'];
    $bio      =$con->real_escape_string($_POST['bio']);

    $password = sha1($_POST['password']);
    $konfirpw = sha1($_POST['konfirpw']);
    $img = @$user['img'];

    // jika terjadi kekosongan data maka masukkan data yang di database
    if (isset($_POST['name']) == null & isset($_POST['email']) == null & isset($_POST['password']) == null & isset($_POST['bio']) == null) {
        $name = $user['name'];
        $email = $user['email'];
        $bio      = $user['bio'];
    }
    if ($_POST['password'] == null) {
        $password = $user['password'];
    }

    // cek password
    if ($konfirpw == $user['password']) {
        //jika gambar ada
        if (isset($_FILES['img']) && $_FILES['img']['name']) {
            $img = htmlspecialchars($_FILES['img']['name']);
            $lokasi_s = $_FILES['img']['tmp_name'];
            $format = ['jpg', 'jpng', 'png'];
            $img_type = explode('.', $img);
            $img_type = strtolower(end($img_type));

            // jika yg di upload bukan ambar
            if (!in_array($img_type, $format)) {
                $c_error = "alert alert-danger alert-dismissible fade show text-center";
                $pesan = "Format Gambar valid png/jpg ";
                $hide = "";
            } else {
                $dir = "../assets/uploads/avatars/";
                move_uploaded_file($lokasi_s, $dir . $img);
            }
        }

        $_SESSION['name'] = $name;
        if (isset($_POST['password']) & $_POST['password'] != null) {
            mysqli_query($con, "UPDATE `users` SET `password`='$password' WHERE `id` = '$id'");
        }

        mysqli_query($con, "UPDATE `users` SET `name`='$name',`email`='$email', `avatar`='$img',`bio`='$bio' WHERE `id` = '$id'");
        $c_error = "alert alert-success alert-dismissible fade show text-center";
        $pesan = "Profile Success Di Perbaharui ";
        $hide = "";
        header('location:profile.php');
    } else {
        // kode eror password tidak sama
        $c_error = "alert alert-danger alert-dismissible fade show text-center";
        $pesan = "Password Salah, Masukkan Passwod lama anda ";
        $hide = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Profile </title>
    <?php
    $title = "user";
    include "../template/header.php" ?>
    <style>
        .main-page {
            border-radius: 8px;
            box-shadow: 0px 5px 10px #7a7474;
        }

        .container h4 {
            font-family: "lora";
            font-weight: bold;
        }

        .ket a {
            width: 210px;
            font-family: "lora";
            font-size: 24px;
        }

        .features {
            background: #EAEAEF;
        }

        .features p a {
            margin-right: 5px;
            margin-left: 5px;
        }

        .features p span {
            font-size: 18px;
        }

        .figure-caption {
            position: relative;
            margin-top: 20px;
        }

        h5 {
            font-size: 22px;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
            font-weight: 700;
            color: #171717;
        }

        .img-user img {
            width: 140px;
            height: 140px;
            box-shadow: 0px 1px 8px grey;
            border-radius: 50%;
            border: solid 6px whitesmoke;
        }
    </style>


</head>

<body style="background:#EAEAEF">

    <!-- Navbar  -->
    <?php include "../template/nav.php" ?>
    <!-- akhir Nav -->
    <div class="col-12 mb-2  mt-2 p-3 ">
        <div class="main-page container mt-5 p-4 bg-white p-2">
            <?php if (mysqli_num_rows($data) === 1) { ?>

                <section class="single-product mt-2">
                    <div <?= $hide ?> class="<?= $c_error ?>" role="alert">
                        <?= $pesan; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-5 text-center mb-3">
                                <div class="img-user mb-3">
                                    <img src="../assets/uploads/avatars/<?= $user['avatar'] ?>" alt="">
                                </div>
                                <input hidden class="input-img" type="file" name="img">
                                <p id="btn-img" class="btn-sm btn btn-outline-success  col-lg-3" style="border-radius:50px"> Upload Foto</p>
                                <div class="form-group text-left">
                                    <label for="bio"> Bio</label>
                                    <textarea name="bio" class="form-control" id="bio" rows="4"><?= $user['bio'] ?></textarea>
                                    <small id="bio" class="form-text text-muted">Maksimal 200 karakter, boleh di kosongkan</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name"><b class="text-danger" style="font-size:20px;margin-right:-5px;">* </b> Nama Lengkap</label>
                                    <input required name="name" type="text" class="form-control" id="name" value="<?= ucwords($user['name']); ?>" placeholder="Nama Baru">
                                </div>
                                <div class="form-group">
                                    <label for="email"> email</label>
                                    <input required disabled type="text" class="form-control" value="<?= ucwords($user['email']); ?>" placeholder="Username Baru">
                                </div>
                                <div class="form-group">
                                    <label for="nama"> Password</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Password Baru">
                                    <small id="password" class="form-text text-muted">kosongkan jika tidak ingin mengubah Password</small>
                                </div>
                                <div class="form-group">
                                    <label for="konfirpw"><b class="text-danger" style="font-size:20px;margin-right:-5px;">* </b> Konfirmasi Password Lama</label>
                                    <input required name="konfirpw" type="password" class="form-control" id="konfirpw" placeholder="Password Lama">
                                    <small id="konfirpw" class="form-text text-muted">Konfirmasi Password lama untuk memastikan ini Anda</small>

                                </div>
                                <div class="tom text-center">
                                    <button name="submit" class="btn btn-primary col-lg-5 mt-2" type="submit">Simpan</button>
                                    <a href="./profile.php" class="batal btn btn-danger col-lg-5 mt-2" type="reset">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </section>
            <?php } else { ?>
                <div class="col-12 mb-2  mt-2 p-3 ">
                    <div class="text-center container mt-5 p-4 p-2">
                        <section class="PNF">
                            <h1>404</h1>
                            <h2>Page Not Found</h2>
                            <p class="mt-2 mb-5">Halaman yang anda minta tidak di temukan di server kami </p>
                            <a class="btn btn-warning mt-3" href="./index.php">Back Home</a>
                        </section>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if (mysqli_num_rows($data) === 1) {
        include "../template/footer.php";
    } ?>

    <script>
        $('#btn-img').on('click', function() {
            $('.input-img').click();
        });

        function readFile(input) {
            if (input.files && input.files[0]) { // jika file ada
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.img-user img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".input-img").change(function() {
            readFile(this);
        });
        $('.batal').click(function() {
            $('.img-user img').attr('src', '../assets/uploads/avatars/<?= $user["avatar"] ?>');
        });
    </script>
</body>

</html>