<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengaduan = intval($_POST['id_pengaduan']);
    $tindakan = trim($_POST['tindakan']);
    $pic_it = trim($_POST['pic_it']);
    $id_barang = isset($_POST['id_barang']) && $_POST['id_barang'] !== '' ? intval($_POST['id_barang']) : null;
    $jumlah = isset($_POST['jumlah']) && is_numeric($_POST['jumlah']) ? intval($_POST['jumlah']) : 0;

    if (empty($tindakan) || empty($pic_it)) {
        die("Tindakan dan PIC IT harus diisi.");
    }

    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Update tindakan, PIC IT, dan status
        $stmt = $conn->prepare("UPDATE pengaduan SET tindakan_perbaikan = ?, pic_it = ?, status = 'Diperbaiki' WHERE id_pengaduan = ?");
        $stmt->bind_param("ssi", $tindakan, $pic_it, $id_pengaduan);
        $stmt->execute();
        $stmt->close();

        // Jika menggunakan stok
        if ($id_barang && $jumlah > 0) {
            // Cek stok tersedia
            $cek_stok = $conn->prepare("SELECT jumlah FROM stok_barang WHERE id_barang = ?");
            $cek_stok->bind_param("i", $id_barang);
            $cek_stok->execute();
            $result = $cek_stok->get_result();
            $cek_stok->close();

            if ($result->num_rows === 0) {
                throw new Exception("Barang tidak ditemukan.");
            }

            $row = $result->fetch_assoc();
            if ($row['jumlah'] < $jumlah) {
                throw new Exception("Stok tidak mencukupi.");
            }

            // Kurangi stok
            $update_stok = $conn->prepare("UPDATE stok_barang SET jumlah = jumlah - ? WHERE id_barang = ?");
            $update_stok->bind_param("ii", $jumlah, $id_barang);
            $update_stok->execute();
            $update_stok->close();

            // Catat ke pengeluaran stok
            $insert_keluar = $conn->prepare("INSERT INTO pengeluaran_stok (id_pengaduan, id_barang, jumlah, keterangan) VALUES (?, ?, ?, ?)");
            $ket = "Digunakan dalam penanganan pengaduan ID $id_pengaduan";
            $insert_keluar->bind_param("iiis", $id_pengaduan, $id_barang, $jumlah, $ket);
            $insert_keluar->execute();
            $insert_keluar->close();
        }

        // Commit transaksi
        mysqli_commit($conn);

        header("Location: pengaduan_list.php?pesan=status_updated");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
    }
} else {
    die("Akses tidak sah.");
}
?>
