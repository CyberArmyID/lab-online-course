<?php
$title = "Dashboard Admin";
include "../app/init.php";

// Pastikan pengguna memiliki sesi aktif dengan peran 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header('location:../auth/login.php');
    exit;
}

$email = $_SESSION['email'];

$userQuery = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
$user = mysqli_fetch_assoc($userQuery);

$userId = $user['id'];
$sqlRewardRdeems = "SELECT * 
FROM reward_redemptions 
JOIN rewards ON reward_redemptions.reward_id = rewards.id 
WHERE reward_redemptions.user_id = $userId 
ORDER BY reward_redemptions.id DESC";

$rewardRdeemQuery = mysqli_query($con, $sqlRewardRdeems);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online - <?= htmlspecialchars($title); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    $title = "Transaksi ";
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

<body>
    <?php include "../template/nav.php"; ?>

    <section class="features pb-5 mt-5 mb-4">
        <div class="container mt-5">
            <div class="col-12 mb-2 mt-2 p-3">
                <div class="main-page container mt-5 p-4 bg-white p-2">
                    <div class="row">
                        <div class="col-lg-6">

                            <h2>Riwayat Penukaran</h2>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a class="btn btn-sm btn-secondary" href="./rewards.php">Kembali</a>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Point</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($rewardReedem = mysqli_fetch_assoc($rewardRdeemQuery)) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= htmlspecialchars($rewardReedem['name']); ?></td>
                                        <td><?= htmlspecialchars($rewardReedem['required_points']); ?></td>
                                        <td>
                                            <?= htmlspecialchars($rewardReedem['status']) == 'redeemed' ? 'Berhasil' : 'Diproses'; ?>
                                        </td>
                                        <td>
                                            <?= $rewardReedem['created_at'] ?>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
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

<?php
mysqli_close($con);
?>