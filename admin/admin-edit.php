<?php
$title = "Edit Admin";
include "../app/init.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location:../auth/login.php');
}

// Ambil ID admin dari URL
$admin_id = $_GET['id'] ?? null;

if ($admin_id) {
    // Ambil data admin berdasarkan ID
    $sql = "SELECT * FROM admins WHERE id = '$admin_id'";
    $result = mysqli_query($con, $sql);
    $admin = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate input
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = !empty($_POST['password']) ? sha1(mysqli_real_escape_string($con, $_POST['password'])) : $admin['password'];

        // Update record in database
        $update_sql = "UPDATE admins SET name = '$name', email = '$email', password = '$password', updated_at = NOW() WHERE id = '$admin_id'";
        if (mysqli_query($con, $update_sql)) {
            echo "<script>alert('Admin berhasil diperbarui!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui admin. Coba lagi.');</script>";
        }
    }
} else {
    echo "<script>alert('Admin tidak ditemukan'); window.location.href='index.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Belajar Online - <?= $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Admin</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="<?= $admin['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $admin['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password (leave blank to keep current password)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>