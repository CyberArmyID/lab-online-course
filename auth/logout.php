<?php
session_start();
if ($_SESSION['name']) {

    session_unset();
    session_destroy();
    header("location: ../index.php");
} else {
    header("location: ../index.php");
}
