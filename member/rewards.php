<?php
$title = "Dashboard Admin";
include "../app/init.php";

// Pastikan pengguna memiliki sesi aktif dengan peran 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header('location:../auth/login.php');
    exit;
}

$email = $_SESSION['email'];

$sqlRewards = "SELECT * FROM rewards ORDER BY id DESC";
$rewardQuery = mysqli_query($con, $sqlRewards);

$userQuery = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
$user = mysqli_fetch_assoc($userQuery);

if (isset($_POST['submit'])) {
    $pointId = $_POST['point_id'];
    $points = $_POST['point'];
    $userId = $user['id'];

    if ($user['point'] > $points) {

        $sqlInsert = "
        INSERT INTO reward_redemptions (user_id, reward_id, points_used, status)
        VALUES ('$userId', '$pointId', '$points', 'redeemed')
        ";

        //> kurangi stock
        $sqlUpdateStock = "
            UPDATE rewards 
            SET stock = stock - 1 
            WHERE id = '$pointId' AND stock > 0
        ";
        if (mysqli_query($con, $sqlInsert) && mysqli_query($con, $sqlUpdateStock)) {
            //> kurangi point user
            $sqlUpdateStock = "
                UPDATE users 
                SET point = point - $points
                WHERE id = '$userId'
            ";
            mysqli_query($con, $sqlUpdateStock);

            echo "<script>
                alert('Penukaran poin berhasil!');
                window.location.href = './redeems.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Penukaran gagal, silakan coba lagi.')</script>";
        }
    } else {
        echo "<script>alert('Point Anda tidak mencukupi')</script>";
    }
}
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

                            <h2>Penukaran poin</h2>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a class="btn btn-secondary" href="./redeems.php">Riwayat Penukaran</a>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Point</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($reward = mysqli_fetch_assoc($rewardQuery)) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= htmlspecialchars($reward['name']); ?></td>
                                        <td><?= htmlspecialchars($reward['required_points']); ?></td>
                                        <td><?= htmlspecialchars($reward['stock']); ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="point_id" value="<?= $reward['id'] ?>">
                                                <input type="hidden" name="point" value="<?= $reward['required_points'] ?>">
                                                <button name="submit" class="btn btn-sm btn-primary">Tukarkan</button>
                                            </form>
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