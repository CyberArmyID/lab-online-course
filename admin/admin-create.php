<?php
$title = "Admin baru";
include "../app/init.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location:../auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Hash the password
    $hashed_password = sha1($password);

    // Insert the new admin record into the database
    $sql = "INSERT INTO admins (name, email, password, created_at, updated_at) VALUES ('$name', '$email', '$hashed_password', NOW(), NOW())";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Berhasil menambahkan admin!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error creating admin. Please try again.');</script>";
    }
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
        <h2>Admin</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>