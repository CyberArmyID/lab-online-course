<?php
$title = "Beranda";
include "./app/init.php";


if (isset($_GET['q'])) {
    $s = mysqli_real_escape_string($con, $_GET['q']);
    $sql = mysqli_query($con, "SELECT * FROM `courses`  WHERE `status` ='publish' AND `title` LIKE '%$s%'  ORDER BY `id` DESC");
} else {

    $sql = mysqli_query($con, "SELECT * FROM `courses` WHERE `status` ='publish' ORDER BY `id` DESC");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online - <?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap, fontaweso and CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <style>
        body {
            background: #EAEAEF;
        }

        .info img {
            width: 130px;
            height: 130px;
            margin: auto;
            margin-top: 10%;
            transition: 0.8s ease;
        }

        .info img:hover {
            width: 147px;
            height: 147px;
        }

        .pagelog {
            width: 500px;
            max-width: 100%;
            border-radius: 4px;
            box-shadow: 2px 5px 10px #7a7474;
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

        .features p a {
            margin-right: 5px;
            margin-left: 5px;
        }

        .features p span {
            font-size: 18px;
        }


        h5 {
            font-size: 22px;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
            font-weight: 700;
            color: #171717;
        }

        .sale .har {
            font-size: 16px;
            font-family: Arial;
            color: #FA591D;
            font-weight: 600;
        }

        .sale {
            height: 280px;

        }

        /* tambahan */
        .navbar {
            background: #171717;
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            margin: auto;
            z-index: 10;
            box-shadow: -15px 0px 30px #4e4e4e;
        }

        .nav-item {
            margin-right: 24px;
            font-weight: 400;
        }

        .nav-item.active a {
            color: #f9B234 !important;
            font-weight: 600;
        }

        .navbar-brand a {
            font-weight: 600;
        }

        .navbar-brand span {
            font-size: 24px;
        }

        .nav-link span {
            color: #f9B234;
            font-weight: 600;
        }

        .nav-link.user {
            font-size: 16px;
        }

        /* akhir navigasi */

        .logo-bawah {
            width: 240px;
        }

        /* Responsive */
        @media (max-width: 769px) {
            .sale {
                height: 470px;

            }

            .nama-user {
                font-size: 18px
            }

            .logo-bawah {
                width: 100%;
            }
        }

        /* akhir responsive */
        /* single */

        .main-page {
            border-radius: 8px;
            /* box-shadow: 0px 5px 10px #7a7474; */
        }

        /* single */
        .harga {
            font-size: 18px;
            font-family: Arial;
            color: #FA591D;
            font-weight: 600;
        }

        h4.nama-produk {
            font-family: "montserrat";
        }

        .colorinput {
            margin: 0;
            position: relative;
            cursor: pointer
        }

        .colorinput-color {
            display: inline-block;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 3px;
            border: 1px solid rgba(0, 40, 100, .12);
            color: #fff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05)
        }

        .PNF {
            margin-top: 80px;
            height: 300px;
            margin: auto;
        }

        .PNF h1 {
            margin-top: 10px;
            margin-bottom: -7px;
            margin-left: -20px;
            font-size: 150px;
            font-weight: 800;
            color: #201f1f;
        }

        .PNF h2 {
            font-size: 40px;
            font-weight: 600;
        }

        .PNF p {
            font-size: 18px;
        }

        .PNF a {
            font-size: 18px;
            font-weight: 600;
        }

        a {
            text-decoration: none;
            color: #201f1f;
        }
    </style>
</head>

<body>
    <nav class="position-fixed navbar navbar-expand-lg navbar-dark">
        <div class="container ">
            <a class="navbar-brand mr-5" href="./index.php">
                Belajar Online
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-uppercase mx-auto col-10">


                </ul>

                <div class="nav-item dropdown col-lg-3 col-md-6 ">
                    <a class="nav-link dropdown-toggle user cart text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        if (!isset($_SESSION['name'])) {
                            echo "user";
                        } else {
                            echo $user['name'];
                        }
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (!isset($_SESSION['name'])) { ?>
                            <a class="dropdown-item" href="./auth/login.php">Masuk</a>
                            <a class="dropdown-item" href="./auth/register.php">Daftar</a>
                        <?php } else { ?>
                            <a class="dropdown-item " href="./member/profile.php">Profil</a>
                            <a class="dropdown-item " href="./member/courses.php">Kursus Saya</a>
                            <a class="dropdown-item " href="./member/rewards.php">Penukaran Poin</a>
                            <a class="dropdown-item " href="./member/transactions.php">Riwayat Transaksi</a>
                            <a class="dropdown-item " href="./auth/logout.php">keluar</a>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!-- product -->
    <section class="features pt-5">
        <div class="container pt-5">

            <div class="row justify-content-end mt-4">
                <div class="col-lg-9">
                    <?php if (isset($s) && $s != '') { ?>
                        <h4>Pencarian : <?= $_GET['q'] ?></h4>
                    <?php } else { ?>
                        <h4>Kelas terbaru</h4>
                    <?php } ?>

                </div>
                <div class="col-lg-3">
                    <form action="">
                        <div class="form-group">
                            <input type="search" class="form-control" name="q" placeholder="Search..." value="<?= isset($s) ? $s : "" ?>" id="search">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row  text-center ">

                <?php if (mysqli_num_rows($sql) > 0) {

                    while ($course = mysqli_fetch_assoc($sql)) { ?>
                        <div class="col-lg-3 col-sm-6 col-sm-6 pr-2 pt-3  ">
                            <div class="sale p-3 bg-white bg-white" style="border-radius:4px;">
                                <figure class="figure">
                                    <a href="./page/course-detail.php?id=<?= $course['id']; ?>">
                                        <img class="figure-img img-fluid " style="border-radius:4px;width:100%;" src="<?= $course['thumbnail'] ?>" alt="img">
                                    </a>
                                    <figcaption class="text-left figure-caption ">
                                        <h5>
                                            <a href="./page/course-detail.php?id=<?= $course['id']; ?>"><?= $course['title']; ?></a>
                                        </h5>
                                        <p class="har mt-2">Rp. <?= number_format($course['price'], 0, ',', '.'); ?> </p>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 bg-white text-center" style="height:400px;border-radius:8px">
                                <div>
                                    <img class="mt-5 pt-2" style="width:110px;height:110px" src="./assets/icon/error.svg">
                                    <h1 class="mt-4">oupss.!</h1>
                                    <h5>Data Belum Tersedia</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- batas  -->
    <div id="res"></div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS,than fontawesome -->
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/all.js"></script>
</body>

</html>