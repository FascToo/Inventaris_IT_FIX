<?php
include('../config/koneksi.php');

$id = $_GET['id'];

// Cek apakah data ada
$cek = mysqli_query($conn, "SELECT * FROM inventaris WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if (!$data) {
  echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
  exit;
}

// Hapus foto jika ada
if (!empty($data['foto_barang'])) {
  $fotoPath = '../assets/img/' . $data['foto_barang'];
  if (file_exists($fotoPath)) {
    unlink($fotoPath); // hapus file dari folder
  }
}

// Hapus dari database
$hapus = mysqli_query($conn, "DELETE FROM inventaris WHERE id='$id'");

if ($hapus) {
  echo "<script>alert('Data berhasil dihapus'); window.location='index.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus data'); window.location='index.php';</script>";
}
?>
