<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengaduan = $_POST['id_pengaduan'];
    $id_user = $_SESSION['id'];
    $puas = $_POST['puas'];
    $komentar = $_POST['komentar'];

    $stmt = $conn->prepare("INSERT INTO review_pengaduan (id_pengaduan, id_user, puas, komentar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_pengaduan, $id_user, $puas, $komentar);

    if ($stmt->execute()) {
        header("Location: pengaduan_detail.php?id=$id_pengaduan&msg=review_success");
        exit;
    } else {
        echo "Gagal menyimpan review: " . $conn->error;
    }
} else {
    echo "Akses tidak valid.";
}
?>
