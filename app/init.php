<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$con = mysqli_connect('mysql_db_lab_belajar_oline', 'root', 'root', 'lab_belajar_online', 3306);

session_start();
$host = 'http://localhost:8005';
//default pesan
$c_error = " ";
$pesan = " ";
$hide = "hidden";

if (isset($_SESSION['name'])) {
    $email = $_SESSION['email'];
    if ($_SESSION['role'] == 'admin') {
        $user = mysqli_query($con, "SELECT * FROM `admins` WHERE `email`='$email'");
        $user = mysqli_fetch_assoc($user);
    } else {
        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email'");
        $user = mysqli_fetch_assoc($user);
    }

    // if ($user['is_active'] == 0) {
    //     header("location:../auth/logout.php");
    // }
}
