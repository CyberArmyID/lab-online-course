<?php
require "../app/init.php";

if (!isset($_GET['trx'])) {
    header('location:../index.php');
}

if (!isset($_SESSION['name'])) {
    header('location:../auth/login.php?status=checkout&redirect=' . $id);
}
$id = $_GET['trx'];


$email = $_SESSION['email'];
$sqluser = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email'");
$user = mysqli_fetch_assoc($sqluser);
$userId = $user['id'];
if (isset($_POST['submit'])) {
    $targetDir = "../assets/uploads/";
    $fileName = basename($_FILES["bukti_pembayaran"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Upload the file without any validation checks
    if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $targetFilePath)) {
        // Update the database with the file name
        $sqlUpdate = "UPDATE `purchases` SET `payment_proof` = '$fileName' WHERE `id` = '$id' AND `user_id` = '$userId'";
        mysqli_query($con, $sqlUpdate);
        //> redirect 

    } else {

        echo "<script> alert('Terjadi kesalahan upload file') </script>";
    }
}
$sqlTrx = mysqli_query($con, "SELECT * FROM `purchases`  WHERE `id`='$id'");
if (mysqli_num_rows($sqlTrx) === 1) {
    $bg = "main-page container mt-5 p-4 bg-white p-2";
} else {
    $bg = "container bg-none";
}

$transaction = mysqli_fetch_assoc($sqlTrx);

$idCourse = $transaction['course_id'];
$sqlCourse = mysqli_query($con, "SELECT * FROM `courses`  WHERE `id`='$idCourse'");
$course = mysqli_fetch_assoc($sqlCourse);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Konfirmasi pembayaran</title>
    <?php
    $title = "Kelas ";
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
    </style>
</head>

<body style="background:#EAEAEF">

    <!-- Navbar  -->
    <?php include "../template/nav.php" ?>
    <!-- akhir Nav -->

    <div class="col-12 mb-2s  mt-2 p-3 ">
        <div class=" <?= $bg ?> ">

            <?php if (mysqli_num_rows($sqlTrx) === 1) { ?>
                <section class="single-product">
                    <h4 class="text-center my-5">Detail Transaksi</h4>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="d-flex mb-4">
                                    <div>
                                        <p><b>Judul Kursus:</b> <?= $course['title']; ?></p>
                                        <p><b>Bank:</b> <?= $transaction['bank']; ?></p>
                                        <p><b>Atas Nama:</b> <?= $transaction['bank_account_name']; ?></p>
                                        <p><b>No. rek :</b> <?= $transaction['bank_account_number']; ?></p>
                                        <p><b>Total harga:</b> <?= $transaction['total_price']; ?></p>
                                        <p><b>Tanggal transaksi:</b> <?= $transaction['created_at']; ?></p>
                                        <p><b>Status:</b>
                                            <?php if ($transaction['status'] == 'pending') { ?>
                                                <span class="btn btn-sm btn-warning">Menunggu Pembayaran</span>
                                            <?php } elseif ($transaction['status'] == 'confirmed') { ?>
                                                <span class="btn btn-sm btn-success">Pembayaran Berhasil</span>
                                            <?php } else { ?>
                                                <span class="btn btn-sm btn-danger">Transaksi Dibatalkan </span>

                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <?php if (!$transaction['payment_proof']) { ?>
                                    <h4>Konfirmasi pembayaran</h4>

                                    <!-- Radio button untuk Bank Transfer -->
                                    <form action="" method="POST" enctype="multipart/form-data">

                                        <div class="mb-3">
                                            <p>Silahkan upload bukti pembayaran anda</p>
                                        </div>
                                        <!-- Upload Bukti Pembayaran -->
                                        <div class="mb-3">
                                            <label for="buktiPembayaran" class="form-label">Upload Bukti Pembayaran</label>
                                            <input class="form-control" type="file" id="buktiPembayaran" name="bukti_pembayaran" required>
                                        </div>

                                        <!-- Tombol Beli Sekarang -->
                                        <button name="submit" type="submit" class="btn btn-success col-12">Simpan</button>
                                    </form>
                                <?php } else { ?>
                                    <?php
                                    $filePath = "../assets/uploads/" . $transaction['payment_proof'];
                                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

                                    ?>
                                    <h4>Bukti pembayaran</h4>
                                    <img src="<?= $filePath ?>" alt="Bukti Pembayaran" style="max-width: 100%; height: auto;">

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } else { ?>
                <div class="col-12 mb-2  mt-2 p-3 ">
                    <div class="text-center container mt-5 p-4 p-2">
                        <section class="PNF">
                            <h1>404</h1>
                            <h2>Page Not Found</h2>
                            <p class="mt-2 mb-5">Halaman yang anda minta tidak di temukan di server kami </p>
                            <a class="btn btn-warning mt-3" href="../index.php">Back Home</a>
                        </section>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if (mysqli_num_rows($sqlTrx) === 1) {
        include "../template/footer.php";
    } ?>

</body>

</html>