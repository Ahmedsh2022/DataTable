<?php
session_start();
if (isset($_SESSION['id'])) {
    $_SESSION = array();
    session_unset();
    session_destroy();
    header('location:login.php');
    exit();
}
