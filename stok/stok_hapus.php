<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if (!isset($_GET['id'])) {
    die("ID barang tidak ditemukan.");
}

$id_barang = intval($_GET['id']);

$hapus = $conn->prepare("DELETE FROM stok_barang WHERE id_barang = ?");
$hapus->bind_param("i", $id_barang);
if ($hapus->execute()) {
    header("Location: stok_list.php?pesan=hapus_berhasil");
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
