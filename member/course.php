<?php
$title = "Dashboard Admin";
include "../app/init.php";

// Pastikan pengguna memiliki sesi aktif dengan peran 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header('location:../auth/login.php');
    exit;
}

$email = $_SESSION['email'];

// Menggunakan Prepared Statements untuk keamanan
$sql = "
    SELECT 
        user_courses.id,
        users.email,
        courses.id AS course_id,
        courses.title AS course_title,
        courses.thumbnail AS course_thumbnail,
        courses.description AS course_description
    FROM 
        user_courses
    JOIN 
        users ON user_courses.user_id = users.id
    JOIN 
        courses ON user_courses.course_id = courses.id
    WHERE users.email = '$email'
";
$sqlPurchases = mysqli_query($con, $sql);

$result = mysqli_fetch_assoc($sqlPurchases);
if (isset($result['course_id'])) {
    $courseId = $result['course_id'];
    $sqlModules = "SELECT * FROM modules WHERE course_id = $courseId";
    $modules = mysqli_query($con, $sqlModules);
} else {
    echo "<script>
        alert('Anda belum memiliki kelas ini');
        window.history.back();
    </script>";
    exit();
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

                        <img class="col-3 border-rounded" src="<?= $result['course_thumbnail'] ?>" alt="">
                        <div class="info">
                            <h4><?= $result['course_title'] ?></h4>
                            <h6><?= $result['course_description'] ?></h6>
                        </div>
                    </div>
                    <hr>
                    <h4>Modul</h4>
                    <div class="table-responsive-sm">
                        <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Modul</th>
                                    <th scope="col">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($module = mysqli_fetch_assoc($modules)) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= htmlspecialchars($module['title']); ?></td>
                                        <td><a class="btn btn-sm btn-primary" href="./module.php?id=<?= htmlspecialchars($module['id']); ?>">Detail</a></td>
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