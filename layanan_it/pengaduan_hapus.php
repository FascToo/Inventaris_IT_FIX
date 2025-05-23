<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pengaduan'];
    $role = $_SESSION['role'];
    $id_user = $_SESSION['id'];

    // Pastikan hanya pemilik atau admin/manajer yang bisa hapus
    if ($role === 'Karyawan') {
        $cek = $conn->prepare("SELECT id_pengaduan FROM pengaduan WHERE id_pengaduan = ? AND id_user = ?");
        $cek->bind_param("ii", $id, $id_user);
    } else {
        $cek = $conn->prepare("SELECT id_pengaduan FROM pengaduan WHERE id_pengaduan = ?");
        $cek->bind_param("i", $id);
    }

    $cek->execute();
    $result = $cek->get_result();
    if ($result->num_rows === 0) {
        echo "<script>alert('Data tidak ditemukan atau akses ditolak'); window.location.href='pengaduan_list.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM pengaduan WHERE id_pengaduan = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: pengaduan_list.php?pesan=hapus_berhasil");
    } else {
        echo "Gagal menghapus data.";
    }
}
?>
