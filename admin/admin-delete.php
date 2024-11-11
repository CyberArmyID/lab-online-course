<?php
include "../app/init.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location:../auth/login.php');
}

if (isset($_GET['id'])) {
    $id = mysqli_escape_string($con, $_GET['id']);
    mysqli_query($con, "DELETE FROM `admins` WHERE `id`='$id'");
}
echo "<script>alert('Berhasil menghapus admin!'); window.location.href='index.php';</script>";
