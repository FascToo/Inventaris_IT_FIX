<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if (!isset($_SESSION['id'])) {
    die("Akses ditolak. Anda belum login.");
}

$id_user = $_SESSION['id'];
$role = $_SESSION['role'];

if (!in_array($role, ['Admin', 'Manajer'])) {
    die("Akses ditolak.");
}

$allowed_status = ['Pending', 'Diproses', 'Diperbaiki', 'Tidak Bisa Diperbaiki'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_pengaduan'], $_POST['action'])) {
        echo "<script>alert('Data tidak lengkap.'); window.location.href='pengaduan_list.php';</script>";
        exit;
    }

    $id_pengaduan = intval($_POST['id_pengaduan']);
    $status_baru = $_POST['action'];

    if (!in_array($status_baru, $allowed_status)) {
        echo "<script>alert('Status tidak valid.'); window.location.href='pengaduan_list.php';</script>";
        exit;
    }

    // Ambil status lama dari database
    $get = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ?");
    $get->bind_param("i", $id_pengaduan);
    $get->execute();
    $data = $get->get_result()->fetch_assoc();
    $get->close();

    if (!$data) {
        echo "<script>alert('Pengaduan tidak ditemukan.'); window.location.href='pengaduan_list.php';</script>";
        exit;
    }

    $status_lama = $data['status'];

    // Validasi alur status yang diperbolehkan
    $transisi_valid = [
        'Pending' => ['Diproses'],
        'Diproses' => ['Diperbaiki', 'Tidak Bisa Diperbaiki'],
    ];

    if (!isset($transisi_valid[$status_lama]) || !in_array($status_baru, $transisi_valid[$status_lama])) {
        echo "<script>alert('Transisi status tidak diizinkan.'); window.location.href='pengaduan_list.php';</script>";
        exit;
    }

    // Update status
    $stmt = $conn->prepare("UPDATE pengaduan SET status = ? WHERE id_pengaduan = ?");
    $stmt->bind_param("si", $status_baru, $id_pengaduan);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        // Jika status menjadi "Diperbaiki", insert ke maintenance
        if ($status_baru === 'Diperbaiki') {
            $get = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ?");
            $get->bind_param("i", $id_pengaduan);
            $get->execute();
            $data = $get->get_result()->fetch_assoc();

            if ($data && !empty($data['kode_barang'])) {
                // Cek apakah sudah masuk maintenance
                $cek = $conn->prepare("SELECT id FROM maintenance WHERE id_pengaduan = ?");
                $cek->bind_param("i", $id_pengaduan);
                $cek->execute();
                $has = $cek->get_result()->num_rows;

                if ($has === 0) {
                    $insert = $conn->prepare("INSERT INTO maintenance (id_pengaduan, kode_barang, masalah, solusi, teknisi) VALUES (?, ?, ?, ?, ?)");
                    $insert->bind_param(
                        "issss",
                        $data['id_pengaduan'],
                        $data['kode_barang'],
                        $data['deskripsi_masalah'],
                        $data['tindakan_perbaikan'],
                        $data['pic_it']
                    );
                    $insert->execute();
                }
            }
        }

        echo "<script>alert('Status berhasil diperbarui.'); window.location.href='pengaduan_list.php?pesan=status_updated';</script>";
    } else {
        echo "<script>alert('Status tidak berubah atau gagal diperbarui.'); window.location.href='pengaduan_list.php';</script>";
    }

    $stmt->close();
    exit;
}

// GET method = tampilkan form ubah status
if (!isset($_GET['id'])) {
    echo "<script>alert('ID pengaduan tidak ditemukan.'); window.location.href='pengaduan_list.php';</script>";
    exit;
}

$id_pengaduan = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ?");
$stmt->bind_param("i", $id_pengaduan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Data pengaduan tidak ditemukan.'); window.location.href='pengaduan_list.php';</script>";
    exit;
}

$data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ubah Status Pengaduan</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Ubah Status Pengaduan #<?= htmlspecialchars($data['id_pengaduan']) ?></h3>
        <form method="POST" action="pengaduan_ubah_status.php">
            <input type="hidden" name="id_pengaduan" value="<?= htmlspecialchars($data['id_pengaduan']) ?>">
            <div class="mb-3">
                <label for="status" class="form-label">Status Baru</label>
                <select name="action" id="status" class="form-select" required>
                    <?php foreach ($allowed_status as $status): ?>
                        <option value="<?= $status ?>" <?= $data['status'] === $status ? 'selected' : '' ?>><?= $status ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="pengaduan_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>