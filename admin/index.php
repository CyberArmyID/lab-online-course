<?php
$title = "Dashboard admin";
include "../app/init.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location:../auth/login.php');
}

$sql = mysqli_query($con, "SELECT * FROM admins ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online - <?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap, fontaweso and CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
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
                        <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'user'; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (!isset($_SESSION['name'])) { ?>
                            <a class="dropdown-item" href="../auth/login.php">Masuk</a>
                            <a class="dropdown-item" href="../auth/register.php">Daftar</a>
                        <?php } else { ?>
                            <a class="dropdown-item " href="./transactions.php">Riwayat Transaksi</a>
                            <a class="dropdown-item " href="./index.php">Manage Admin</a>
                            <a class="dropdown-item " href="./logout.php">keluar</a>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <br>

    <div class="col-12 mb-2s  mt-2 p-3 ">
        <div class="main-page container mt-5 p-4 bg-white p-2">

            <a class="btn btn-sm btn-secondary mb-3" href="./admin-create.php">Tambah admin</a>

            <div class="table-responsive-sm">
                <table class="table table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($admin = mysqli_fetch_assoc($sql)) { ?>
                            <tr>
                                <th scope="row"><?=
                                                $i++ ?></th>
                                <td><a class="text-dark" href="./admin-detail.php?id=<?= $admin['id'] ?>"><?= $admin['name']; ?></a></td>
                                <td></i> <?= $admin['email'] ?></td>
                                <td><a class="btn btn-sm btn-primary" href="./admin-edit.php?id=<?= $admin['id'] ?> ">Edit</a> | <a onclick="return confirm('anda yakin')" class="btn btn-sm btn-danger" href="./admin-delete.php?id=<?= $admin['id'] ?> ">Hapus</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- batas  -->
    <div id="res"></div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS,than fontawesome -->
    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/all.js"></script>
</body>

</html>