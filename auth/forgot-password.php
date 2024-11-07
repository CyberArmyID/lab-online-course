<?php
include "../app/init.php";

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;


if (isset($_SESSION['name'])) {
    header('location:../index.php');
}

if (isset($_POST['submit'])) {
    $email = strtolower($_POST['email']);
    $sql = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");

    if (mysqli_num_rows($sql) === 0) {
        $c_error = "alert alert-danger alert-dismissible fade show";
        $pesan = "Email belum terdaftar";
        $hide = " ";
    } else {

        $token = bin2hex(random_bytes(16));
        // insert token dan kirim email
        $sqlInsertToken = mysqli_query($con, "INSERT INTO `user_tokens` (`email`, `token`) VALUES ('$email', '$token')");

        if ($sqlInsertToken) {
            $request = mysqli_fetch_assoc($sql);
            // Send the email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '296458e6d762df';
            $mail->Password = '53399a46203004';

            // Email sender and recipient settings
            $mail->setFrom('info@belajaronline.com', 'Belajar online');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Permintaan Reset Password';
            $mail->Body = '
                <html>
                <head>
                    <title>Reset Password</title>
                </head>
                <body>
                    <h1>Reset Password</h1>
                    <p>Klik <a href="' . $host . '/auth/reset.php?token=' . $token . '">di sini</a> untuk mereset password.</p>
                    <p>Salin dan tempel link ini di browser Anda untuk mereset password: <br>
                    ' . $host . '/auth/reset.php?token=' . $token . '</p>
                </body>
                </html>
            ';

            $mail->AltBody = 'Salin dan tempel link ini di browser Anda untuk mereset kata sandi Anda: ' . $host . '/auth/reset.php?token=' . $token;


            if ($mail->send()) {
                $c_error = "alert alert-success alert-dismissible fade show";
                $pesan = "Email telah dikirim. Silakan cek inbox Anda untuk melanjutkan proses reset password.";
                $hide = " ";
                header("location: ./login.php");
            } else {
                $c_error = "alert alert-danger alert-dismissible fade show";
                $pesan = "Gagal mengirim email. Silakan coba lagi. 1";
                $hide = " ";
            }
        } else {
            $c_error = "alert alert-danger alert-dismissible fade show";
            $pesan = "Email Atau Password Salah!";
            $hide = " ";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lupa password</title>
    <?php require "../template/header.php" ?>
</head>

<body style="background:#EAEAEF">
    <?php require "../template/nav.php" ?>
    <div class="mt-3"></div>

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
                    <h2 class="mb-5">Lupa password</h2>
                    <form action="" method="post">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"> <i class="fa fa-envelope"></i></span>
                            </div>
                            <input name="email" required type="text" class="form-control col-lg-12" placeholder="Email">
                        </div>

                        <button name="submit" class="mt-5 btn btn-primary col-6" type="submit">Submit</button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- batas  -->

    <?php require "../template/footer.php" ?>
</body>

</html>