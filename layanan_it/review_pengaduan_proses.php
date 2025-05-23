<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id'];
    $id_pengaduan = $_POST['id_pengaduan'];
    $puas = $_POST['puas'];
    $komentar = isset($_POST['komentar']) ? trim($_POST['komentar']) : '';

    // Cek apakah review sudah ada
    $cek = $conn->prepare("SELECT * FROM review_pengaduan WHERE id_pengaduan = ? AND id_user = ?");
    $cek->bind_param("ii", $id_pengaduan, $id_user);
    $cek->execute();
    $res = $cek->get_result();

    if ($res->num_rows > 0) {
        echo "<script>alert('Review sudah pernah dikirim.'); window.location.href = 'pengaduan_list.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO review_pengaduan (id_pengaduan, id_user, puas, komentar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_pengaduan, $id_user, $puas, $komentar);

    if ($stmt->execute()) {
        echo "<script>alert('Terima kasih atas review Anda.'); window.location.href = 'pengaduan_list.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan review.'); window.history.back();</script>";
    }
} else {
    header("Location: pengaduan_list.php");
    exit;
}
