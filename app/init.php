<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$con = mysqli_connect('localhost', 'root', 'sandwich', 'project_belajar_online');

session_start();
$host = 'http://localhost/~koji/belajar_online';
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
