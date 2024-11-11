<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Detail kelas</title>
    <?php require "../app/init.php";
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
    <?php
    $id = mysqli_real_escape_string($con, $_GET['id']);

    $sqlCourse = mysqli_query($con, "SELECT * FROM `courses`  WHERE `id`='$id' AND `status` ='publish'");
    $course = mysqli_fetch_assoc($sqlCourse);
    $sqlModules = mysqli_query($con, "SELECT * FROM `modules`  WHERE `course_id`='$id'");
    if (mysqli_num_rows($sqlCourse) === 1) {
        $bg = "main-page container mt-5 p-4 bg-white p-2";
    } else {
        $bg = "container bg-none";
    }
    ?>
    <div class="col-12 mb-2s  mt-2 p-3 ">
        <div class=" <?= $bg ?> ">

            <?php if (mysqli_num_rows($sqlCourse) === 1) { ?>
                <section class="single-product mt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-5">
                                <figure class="figure">
                                    <img src="<?= $course['thumbnail'] ?>" class="figure-img img-fluid rounded">
                                </figure>
                                <a href="./checkout.php?id=<?= $course['id'] ?>" class="btn btn-primary col-12">Beli Sekarang</a>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="nama-course"><?= $course['title']; ?></h4>
                                <p class="harga">Rp <?= number_format($course['price'], 0, ',', '.'); ?></p>
                                <div class="info">
                                    <div class="row">
                                        <div class="deskripsi col-12">
                                            <hr>
                                            <h5>Deskripsi</h5>
                                            <P><?= $course['description']; ?></P>
                                            <h5>Module</h5>
                                            <div class="accordion" id="accordionExample">

                                                <?php
                                                while ($module = mysqli_fetch_assoc($sqlModules)) { ?>


                                                    <div class="card mb-1">
                                                        <div class="card-header" id="heading<?= $module['id'] ?>">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne<?= $module['id'] ?>" aria-expanded="true" aria-controls="collapseOne<?= $module['id'] ?>">
                                                                    <?= $module['title'] ?>
                                                                </button>
                                                            </h2>
                                                        </div>

                                                        <div id="collapseOne<?= $module['id'] ?>" class="collapse" aria-labelledby="heading<?= $module['id'] ?>" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <?php
                                                                $moduleId = $module['id'];
                                                                $sqlMaterial = mysqli_query($con, "SELECT * FROM `materials`  WHERE `module_id`='$moduleId'");

                                                                while ($material = mysqli_fetch_assoc($sqlMaterial)) { ?>

                                                                    <ul>
                                                                        <li><?= $material['title'] ?></li>
                                                                    </ul>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <?php if (mysqli_num_rows($sqlCourse) === 1) {
        include "../template/footer.php";
    } ?>

</body>

</html>