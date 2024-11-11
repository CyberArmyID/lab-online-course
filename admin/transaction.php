<?php
$title = "Dashboard admin";
include "../app/init.php";

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location:../auth/login.php');
    exit;
}
$trxId = $_GET['id'] ?? null;

// Fetch transaction details
$sql = mysqli_query($con, "
    SELECT 
        purchases.id,
        users.id AS user_id,
        users.point AS user_point,
        courses.id AS course_id,
        courses.point AS course_point
    FROM 
        purchases
    JOIN 
        users ON purchases.user_id = users.id
    JOIN 
        courses ON purchases.course_id = courses.id
    WHERE 
        purchases.id = '$trxId'
");

$trx = mysqli_fetch_assoc($sql); // Fetch data as an associative array

if (isset($_POST['submit'])) {
    $trxId = $_POST['id'];
    //> update status pembayaran
    $query = "UPDATE purchases SET `status` = 'confirmed' WHERE `id` = '$trxId'";
    $sqlTransactionConfirmation = mysqli_query($con, $query);

    //> insert user course
    $userId = $trx['user_id'];
    $courseId = $trx['course_id'];
    $query = "INSERT INTO user_courses (user_id, course_id) VALUES ($userId,$courseId)";
    $sqlTransactionConfirmation = mysqli_query($con, $query);

    $point = $trx['user_point'] +  $trx['course_point'];
    //> update point user 
    $query = "UPDATE users SET `point` = $point WHERE `id` = '$userId'";
    $sqlTransactionConfirmation = mysqli_query($con, $query);
    $c_error = "alert alert-success alert-dismissible fade show";
    $pesan = "Transaksi berhasil dikonfirmasi";
    $hide = " ";
}


// Fetch transaction details
$sql = mysqli_query($con, "
    SELECT 
        purchases.id,
        purchases.status,
        purchases.voucher_code,
        purchases.total_price,
        purchases.bank,
        purchases.bank_account_name,
        purchases.bank_account_number,
        purchases.payment_proof,
        purchases.created_at,
        purchases.updated_at,
        users.id AS user_id,
        users.name AS user_name,
        users.email AS user_email,
        courses.id AS course_id,
        courses.title AS course_title
    FROM 
        purchases
    JOIN 
        users ON purchases.user_id = users.id
    JOIN 
        courses ON purchases.course_id = courses.id
    WHERE 
        purchases.id = $trxId
    ORDER BY 
        purchases.id DESC
");

$row = mysqli_fetch_assoc($sql); // Fetch data as an associative array

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online - <?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <div class="container">
            <a class="navbar-brand mr-5" href="./index.php">Belajar Online</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-uppercase mx-auto col-10"></ul>
                <div class="nav-item dropdown col-lg-3 col-md-6">
                    <a class="nav-link dropdown-toggle user cart text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'user'; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (!isset($_SESSION['name'])) { ?>
                            <a class="dropdown-item" href="../auth/login.php">Masuk</a>
                            <a class="dropdown-item" href="../auth/register.php">Daftar</a>
                        <?php } else { ?>
                            <a class="dropdown-item" href="./transactions.php">Riwayat Transaksi</a>
                            <a class="dropdown-item" href="./index.php">Manage Admin</a>
                            <a class="dropdown-item" href="./logout.php">Keluar</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="features pb-5 mt-5 mb-4">
        <div class="container mt-5">
            <div class="col-12 mb-2 mt-2 p-3">
                <div class="main-page container mt-5 p-4 bg-white p-2">
                    <div class="row">
                        <div class="col-lg-6">

                            <h4>Detail Transaksi</h4>
                        </div>
                        <div class="col-lg-6 text-right">

                            <a class="btn btn-sm btn-secondary mb-3" href="./transactions.php">
                                < Kembali</a>
                        </div>
                    </div>
                    <div <?= $hide ?> class="<?= $c_error ?> text-center" role="alert">
                        <?= $pesan; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal tranasksi</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['user_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email Pengguna</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['user_email']); ?></td>
                            </tr>
                            <tr>
                                <th>Judul Kursus</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['course_title']); ?></td>
                            </tr>
                            <tr>
                                <th>Kode Voucher</th>
                                <th>:</th>
                                <td><?= htmlspecialchars($row['voucher_code']); ?></td>
                            </tr>
                            <tr>
                                <th>Harga Total</th>
                                <th>:</th>
                                <td>Rp. <?= number_format($row['total_price'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Bank</th>
                                <th>:</th>
                                <td><?= $row['bank']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pemilik Rekening</th>
                                <th>:</th>
                                <td><?= $row['bank_account_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Nomor Rekening</th>
                                <th>:</th>
                                <td><?= $row['bank_account_number']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <th>:</th>
                                <td>
                                    <?php if ($row['status'] == 'pending') { ?>
                                        <span class="btn btn-sm btn-warning">Menunggu Pembayaran</span>
                                    <?php } elseif ($row['status'] == 'confirmed') { ?>
                                        <span class="btn btn-sm btn-success">Pembayaran Berhasil</span>
                                    <?php } else { ?>
                                        <span class="btn btn-sm btn-danger">Transaksi Dibatalkan </span>

                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <th>:</th>
                                <td>
                                    <?php if ($row['payment_proof']) { ?>
                                        <img src="../assets/uploads/<?= htmlspecialchars($row['payment_proof']); ?>" alt="Bukti Pembayaran" width="150">
                                    <?php } else { ?>
                                        Belum ada bukti pembayaran
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <?php if ($row['status'] == 'pending') { ?>
                        <form action="" method="post">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                            <button name="submit" class="mt-5 btn btn-primary col-6" type="submit">Konfirmasi pembayaran</button>
                            <br><br>
                        </form>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </section>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/all.js"></script>
</body>

</html>