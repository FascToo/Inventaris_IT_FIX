<?php
include '../config/koneksi.php';

$kode = $_GET['kode_barang'] ?? '';

$response = ['spesifikasi_barang' => ''];

if (!empty($kode)) {
    $stmt = $conn->prepare("SELECT spesifikasi_barang FROM inventaris WHERE kode_barang = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $stmt->bind_result($spesifikasi);
    if ($stmt->fetch()) {
        $response['spesifikasi_barang'] = $spesifikasi;
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
