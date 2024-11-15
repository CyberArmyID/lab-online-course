<!-- Navbar  -->
<nav class="position-fixed navbar navbar-expand-lg navbar-dark">
    <div class="container ">
        <a class="navbar-brand mr-5" href="../index.php">
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
                    <?php
                    if (!isset($_SESSION['name'])) {
                        echo "user";
                    } else {
                        echo $user['name'];
                    }
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if (!isset($_SESSION['name'])) { ?>
                        <a class="dropdown-item" href="../auth/login.php">Masuk</a>
                        <a class="dropdown-item" href="../auth/register.php">Daftar</a>
                    <?php } else { ?>
                        <a class="dropdown-item " href="../member/profile.php">Profil</a>
                        <a class="dropdown-item " href="../member/courses.php">Kursus Saya</a>
                        <a class="dropdown-item " href="../member/rewards.php">Penukaran Poin</a>
                        <a class="dropdown-item " href="../member/transactions.php">Riwayat Transaksi</a>
                        <a class="dropdown-item " href="../auth/logout.php">keluar</a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</nav>
<!-- akhir Nav -->