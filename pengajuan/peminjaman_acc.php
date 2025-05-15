<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if (!isset($_SESSION['id'])) {
    die("Akses ditolak. Anda belum login.");
}

$role = $_SESSION['role'];
if ($role !== 'Admin' && $role !== 'Manajer') {
    die("Akses ditolak.");
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Parameter tidak lengkap.");
}

$id = intval($_GET['id']);
$action = $_GET['action'];

if ($action === 'approve') {
    $status_baru = 'DIsetujui'; // sesuai ENUM di DB
} elseif ($action === 'reject') {
    $status_baru = 'Ditolak';
} else {
    die("Action tidak valid.");
}

$sql = "UPDATE peminjaman SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Gagal prepare statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "si", $status_baru, $id);
$exec = mysqli_stmt_execute($stmt);

if ($exec) {
    header("Location: peminjaman_list.php"); // sesuaikan dengan nama file list kamu
    exit;
} else {
    echo "Gagal update status: " . mysqli_error($conn);
}
