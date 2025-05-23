<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], ['Admin', 'Manajer'])) {
    die("Akses ditolak.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        echo "<script>alert('ID tidak ditemukan.'); window.location='maintenance_list.php';</script>";
        exit;
    }

    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM maintenance WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.'); window.location='maintenance_list.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location='maintenance_list.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Metode tidak diizinkan.'); window.location='maintenance_list.php';</script>";
}
?>
