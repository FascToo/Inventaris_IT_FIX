<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pengaduan'];
    $nama_pt = $_POST['nama_pt'];
    $divisi = $_POST['divisi'];
    $lantai = $_POST['lantai'];
    $jenis_perangkat = $_POST['jenis_perangkat'];
    $deskripsi = $_POST['deskripsi_masalah'];
    $kode_barang = $_POST['kode_barang'];

    $stmt = $conn->prepare("UPDATE pengaduan SET nama_pt=?, divisi=?, lantai=?, jenis_perangkat=?, deskripsi_masalah=?, kode_barang=? WHERE id_pengaduan=?");
    $stmt->bind_param("ssssssi", $nama_pt, $divisi, $lantai, $jenis_perangkat, $deskripsi, $kode_barang, $id);

    if ($stmt->execute()) {
        header("Location: pengaduan_list.php?pesan=berhasil");
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Akses tidak valid.";
}
