<?php
require "../app/init.php";

if (!isset($_GET['id'])) {
    header('location:../index.php');
}
$id = mysqli_real_escape_string($con, $_GET['id']);

if (!isset($_SESSION['name'])) {
    header('location:../auth/login.php?status=checkout&redirect=' . $id);
}

$sqlCourse = mysqli_query($con, "SELECT * FROM `courses`  WHERE `id`='$id'");
$course = mysqli_fetch_assoc($sqlCourse);

if (isset($_POST['submit'])) {
    $price = $course['price'];

    $voucher_code  = mysqli_real_escape_string($con, $_POST['code_voucher']) ?? null;
    if ($voucher_code) {
        $query = "SELECT * FROM vouchers WHERE code = '$voucherCode' LIMIT 1";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {

            $voucher = mysqli_fetch_assoc($result);

            $discountPercentage = $voucher['discount_percentage'];
            $discountAmount = $coursePrice * ($discountPercentage / 100);
            $price = $coursePrice - $discountAmount;
        }
    }
    // Fetch course details
    $email = $_SESSION['email'];
    $sqluser = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email'");
    $user = mysqli_fetch_assoc($sqluser);

    $user_id = $user['id']; // Assuming the user ID is stored in session
    $course_id = $id;
    $status = 'pending'; // Default status
    $voucher_code = $voucher_code;
    $total_price = $price; // Retrieve price from course info
    $bank = mysqli_real_escape_string($con, $_POST['bank']);
    $bank_account_name = "PT. Indonesia Belajar Online"; // Static account name, can be changed dynamically if needed
    $bank_account_number = ($bank === 'BCA') ? '1234567890' : '0987654321';
    $payment_proof = null; // This would be updated after proof is uploaded

    // Insert data into purchases table
    $sql = "INSERT INTO purchases (user_id, course_id, status, voucher_code, total_price, bank, bank_account_name, bank_account_number, created_at, updated_at)
            VALUES ('$user_id', '$course_id', '$status', '$voucher_code', '$total_price', '$bank', '$bank_account_name', '$bank_account_number', NOW(), NOW())";

    if (mysqli_query($con, $sql)) {
        $purchase_id = mysqli_insert_id($con);

        // Redirect with the purchase ID in the query string
        header("Location: ./transaction-detail.php?trx=" . $purchase_id);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Detail Kelas</title>
    <?php
    $title = "Kelas ";
    include "../template/header.php";
    ?>
    <style>
        /* Your CSS here */
    </style>
</head>

<body style="background:#EAEAEF">

    <!-- Navbar  -->
    <?php include "../template/nav.php";


    if (mysqli_num_rows($sqlCourse) === 1) {
        $bg = "main-page container mt-5 p-4 bg-white p-2";
    } else {
        $bg = "container bg-none";
    }
    ?>

    <div class="col-12 mb-2 mt-2 p-3">
        <div class="container mt-5 p-4 bg-white <?php echo (mysqli_num_rows($sqlCourse) === 1) ? 'main-page' : 'bg-none'; ?>">
            <?php if (mysqli_num_rows($sqlCourse) === 1) { ?>
                <section class="single-product">
                    <h4 class="text-center my-5">Konfirmasi Pembelian</h4>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Informasi Kursus</h2>
                                <div class="d-flex mb-4">
                                    <img src="<?= $course['thumbnail'] ?>" alt="Course Thumbnail" class="img-thumbnail" style="width: 150px; height: 100px; margin-right: 20px;">
                                    <div>
                                        <p><strong>Judul Kursus:</strong> <br> <?= $course['title']; ?></p>
                                        <p><strong>Deskripsi:</strong> <br> <?= $course['description']; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <h4>Metode Pembayaran</h4>

                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label class="form-check-label mb-2"><strong>Pilih Bank:</strong></label><br>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="bankBCA" value="BCA" required>
                                            <label class="form-check-label" for="bankBCA">
                                                Bank BCA<br>
                                                <small class="text-secondary">Atas Nama: PT. Indonesia Belajar Online</small><br>
                                                <small class="text-secondary">Nomor Rekening: 1234567890</small>
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="bankMandiri" value="Mandiri" required>
                                            <label class="form-check-label" for="bankMandiri">
                                                Bank Mandiri<br>
                                                <small class="text-secondary">Atas Nama: PT. Indonesia Belajar Online</small><br>
                                                <small class="text-secondary">Nomor Rekening: 0987654321</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="code_voucher" placeholder="Voucher" id="code_voucher">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="use_voucher">Gunakan</button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h5>Total Pembayaran</h5>
                                        <h5><span class="text-primary" id="total_price">Rp.<?= number_format($course['price'], 0, ',', '.'); ?></span></h5>
                                        <small class="text-secondary" id="discount_info"></small>
                                    </div>

                                    <button name="submit" type="submit" class="btn btn-success col-12">Beli Sekarang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } else { ?>
                <div class="text-center container mt-5 p-4 p-2">
                    <section class="PNF">
                        <h1>404</h1>
                        <h2>Page Not Found</h2>
                        <p class="mt-2 mb-5">Halaman yang anda minta tidak ditemukan di server kami</p>
                        <a class="btn btn-warning mt-3" href="../index.php">Back Home</a>
                    </section>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php if (mysqli_num_rows($sqlCourse) === 1) {
        include "../template/footer.php";
    } ?>

    <script>
        document.getElementById('use_voucher').addEventListener('click', function() {
            const voucherCode = document.getElementById('code_voucher').value;
            const course_id = <?= $course['id'] ?>;
            // Lakukan validasi jika diperlukan, misalnya pastikan kode voucher tidak kosong
            if (!voucherCode) {
                alert("Silakan masukkan kode voucher.");
                return;
            }
            // Buat AJAX request ke server untuk memvalidasi voucher
            $.ajax({
                url: '../api/apply_voucher.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    code_voucher: voucherCode,
                    course_id: course_id
                }),
                success: function(data) {
                    if (data.success) {
                        // Perbarui harga dan informasi diskon
                        $('#total_price').text(`Rp.${data.discounted_price}`);
                        $('#discount_info').text(`Diskon ${data.discount_percentage}% dari harga awal Rp.${data.original_price}`);
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>

</html>