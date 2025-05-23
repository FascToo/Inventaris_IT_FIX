<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengaduan = intval($_POST['id_pengaduan']);
    $id_user = $_SESSION['id'];
    $role = $_SESSION['role'];

    $divisi = $_POST['divisi'];
    $jenis_perangkat = $_POST['jenis_perangkat'];
    $kode_barang = $_POST['kode_barang'];
    $spesifikasi = $_POST['spesifikasi'];
    $deskripsi_masalah = $_POST['deskripsi_masalah'];

    // Validasi
    if (empty($divisi) || empty($jenis_perangkat) || empty($kode_barang) || empty($deskripsi_masalah)) {
        echo "<script>alert('Semua data wajib diisi.'); window.location.href='pengaduan_edit.php?id=$id_pengaduan';</script>";
        exit;
    }

    // Batasi akses untuk Karyawan: hanya boleh edit pengaduan miliknya yang masih Pending
    if ($role === 'Karyawan') {
        $cek = $conn->prepare("SELECT id_pengaduan FROM pengaduan WHERE id_pengaduan = ? AND id_user = ? AND status = 'Pending'");
        $cek->bind_param("ii", $id_pengaduan, $id_user);
        $cek->execute();
        $result = $cek->get_result();
        if ($result->num_rows === 0) {
            echo "<script>alert('Akses ditolak atau data tidak bisa diedit.'); window.location.href='pengaduan_list.php';</script>";
            exit;
        }
    }

    // Update data
    $stmt = $conn->prepare("UPDATE pengaduan SET divisi = ?, jenis_perangkat = ?, kode_barang = ?, spesifikasi = ?, deskripsi_masalah = ? WHERE id_pengaduan = ?");
    $stmt->bind_param("sssssi", $divisi, $jenis_perangkat, $kode_barang, $spesifikasi, $deskripsi_masalah, $id_pengaduan);

    if ($stmt->execute()) {
        echo "<script>alert('Data pengaduan berhasil diperbarui.'); window.location.href='pengaduan_list.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan perubahan: {$conn->error}'); window.location.href='pengaduan_edit.php?id=$id_pengaduan';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Akses tidak valid.'); window.location.href='pengaduan_list.php';</script>";
}
?>
