<?php
session_start();
// cek apakah sudah login, misal:
if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}
?>