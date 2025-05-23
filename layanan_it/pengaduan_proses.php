<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id'];
    $nama_pt = $_POST['nama_pt'];
    $divisi = $_POST['divisi'];
    $lantai = $_POST['lantai'];
    $jenis_perangkat = $_POST['jenis_perangkat'];
    $deskripsi_masalah = $_POST['deskripsi_masalah'];

    // Validasi sederhana
    if (empty($nama_pt) || empty($divisi) || empty($lantai) || empty($jenis_perangkat) || empty($deskripsi_masalah)) {
        die("Semua kolom wajib diisi.");
    }

    // Simpan pengaduan
    $stmt = $conn->prepare("INSERT INTO pengaduan 
        (id_user, nama_pt, divisi, lantai, jenis_perangkat, deskripsi_masalah, status, tanggal_pengaduan)
        VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");

    $stmt->bind_param("isssss", $id_user, $nama_pt, $divisi, $lantai, $jenis_perangkat, $deskripsi_masalah);

    if ($stmt->execute()) {
        header("Location: pengaduan_list.php?pesan=berhasil");
        exit;
    } else {
        echo "Gagal menyimpan pengaduan: " . $conn->error;
    }

    $stmt->close();
} else {
    die("Akses tidak valid.");
}
?>
