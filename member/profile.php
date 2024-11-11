<?php
// Check user session
include "../app/init.php";

if (!isset($_SESSION['role']) && $_SESSION['role'] == 'member') {
    header('location:../index.php');
    exit;
}

// Get user profile data

$email = $_SESSION['email'];
$data = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");
$user = mysqli_fetch_assoc($data);

if ($user) {
    $bg = "main-page container mt-5 p-4 bg-white p-2";
} else {
    $bg = "container bg-none";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <?php include "../template/header.php"; ?>
    <style>
        /* Style adjustments */
        .main-page {
            border-radius: 8px;
            box-shadow: 0px 5px 10px #7a7474;
        }

        .img-user img {
            width: 140px;
            height: 140px;
            box-shadow: 0px 1px 8px grey;
            border-radius: 50%;
            border: solid 6px whitesmoke;
        }

        /* Additional styles... */
    </style>
</head>

<body style="background:#EAEAEF">

    <!-- Navbar -->
    <?php include "../template/nav.php"; ?>

    <div class="col-12 mb-2 mt-2 p-3">
        <div class="<?= $bg ?>">
            <?php if ($user) { ?>

                <section class="single-product mt-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-5 text-center mb-3">
                                <div class="img-user mb-3">
                                    <img src="../assets/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" alt="User Avatar">
                                </div>
                                <a href="./update-profile.php" class="btn-sm btn btn-outline-success col-lg-3" style="border-radius:50px">Edit Profile</a>
                            </div>
                            <div class="col-sm-6 text-center">
                                <h4 class="nama-user"><?= ucwords(htmlspecialchars($user['name'])); ?></h4>
                                <h6 class="mt-"><?= htmlspecialchars($user['email']); ?></h6>
                                <div class="info mt-4">
                                    <div class="row">
                                        <div class="deskripsi col-12">
                                            <hr>
                                            <p><?= ucfirst(htmlspecialchars($user['bio'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } else { ?>
                <div class="text-center container mt-5 p-4 p-2">
                    <section class="PNF">
                        <h1>404</h1>
                        <h2>Page Not Found</h2>
                        <p class="mt-2 mb-5">Halaman yang anda minta tidak di temukan di server kami</p>
                        <a class="btn btn-warning mt-3" href="./index.php">Back Home</a>
                    </section>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if ($user) include "../template/footer.php"; ?>
</body>

</html>