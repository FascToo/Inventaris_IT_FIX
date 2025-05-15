<?php
include_once '../config/koneksi.php';

if (isset($_GET['aksi']) && $_GET['aksi'] === 'baca_semua') {
    mysqli_query($conn, "UPDATE peminjaman SET dibaca_admin = 1 WHERE status IN ('pending', 'disetujui', 'ditolak')");
    mysqli_query($conn, "UPDATE permintaan SET dibaca_admin = 1 WHERE status IN ('pending', 'disetujui', 'ditolak')");

    // Redirect ke halaman utama atau dashboard
    header("Location: ../dashboard/index.php"); // Ganti sesuai halaman utama kamu
    exit;
}

if (isset($_GET['tipe'], $_GET['id'], $_GET['redirect'])) {
    $tipe = $_GET['tipe'];
    $id = intval($_GET['id']);
    $redirect = urldecode($_GET['redirect']);

    if ($tipe === 'peminjaman') {
        mysqli_query($conn, "UPDATE peminjaman SET dibaca_admin = 1 WHERE id = $id");
    } elseif ($tipe === 'permintaan') {
        mysqli_query($conn, "UPDATE permintaan SET dibaca_admin = 1 WHERE id = $id");
    }

    header("Location: $redirect");
    exit;
}

header("Location: ../dashboard/index.php");
exit;
