<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if (!isset($_SESSION['id'])) {
    die("Akses ditolak. Anda belum login.");
}

$role = $_SESSION['role'];
if ($role !== 'Admin' && $role !== 'Manajer') {
    die("Akses ditolak.");
}

if (!isset($_GET['id'])) {
    die("ID peminjaman tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil data peminjaman
$sql = "SELECT * FROM peminjaman WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data peminjaman tidak ditemukan.");
}

// Proses update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kondisi_sekarang = $_POST['kondisi_sekarang'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';
    $tanggal_cek = $_POST['tanggal_cek'] ?? null;

    // Upload formulir
    $formulir_name = $_FILES['file_formulir']['name'] ?? '';
    $formulir_tmp = $_FILES['file_formulir']['tmp_name'] ?? '';
    $formulir_error = $_FILES['file_formulir']['error'] ?? 4; // 4 = no file uploaded
    $upload_dir = "../uploads/";
    $path_formulir = $data['file_formulir'] ?? ""; // ambil file sebelumnya jika ada

    if ($formulir_error === UPLOAD_ERR_OK && !empty($formulir_name)) {
        // Validasi ekstensi file (boleh dikembangkan)
        $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($formulir_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            $error = "Format file tidak diperbolehkan. Hanya PDF, JPG, JPEG, PNG.";
        } else {
            // Hapus file lama jika ada
            if (!empty($path_formulir) && file_exists($path_formulir)) {
                unlink($path_formulir);
            }

            $new_name = uniqid('formulir_') . '.' . $ext;
            $path_formulir = $upload_dir . $new_name;

            if (!move_uploaded_file($formulir_tmp, $path_formulir)) {
                $error = "Gagal upload formulir.";
                $path_formulir = $data['file_formulir'] ?? "";
            }
        }
    }

    if (empty($error)) {
        // Update database dengan data baru termasuk path formulir jika ada
        $sql_update = "UPDATE peminjaman SET kondisi_sekarang = ?, keterangan = ?, tanggal_cek = ?, file_formulir = ? WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ssssi", $kondisi_sekarang, $keterangan, $tanggal_cek, $path_formulir, $id);
        $success = mysqli_stmt_execute($stmt_update);

        if ($success) {
            header("Location: peminjaman_list.php");
            exit;
        } else {
            $error = "Gagal memperbarui data.";
        }
    }
}

include('../layouts/header.php');
include('../layouts/sidebar.php');
?>

<div class="content">
    <div class="container mt-4">
        <h4>Edit Peminjaman ID #<?= htmlspecialchars($id) ?></h4>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="kondisi_sekarang" class="form-label">Kondisi Sekarang</label>
                <input type="text" class="form-control" id="kondisi_sekarang" name="kondisi_sekarang" required
                       value="<?= htmlspecialchars($data['kondisi_sekarang']) ?>">
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_cek" class="form-label">Tanggal Cek</label>
                <input type="date" class="form-control" id="tanggal_cek" name="tanggal_cek"
                       value="<?= !empty($data['tanggal_cek']) ? date('Y-m-d', strtotime($data['tanggal_cek'])) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="file_formulir" class="form-label">Upload Formulir Peminjaman (PDF/JPG/PNG)</label>
                <input type="file" class="form-control" name="file_formulir" accept=".pdf,.jpg,.jpeg,.png">
                <?php if (!empty($data['file_formulir']) && file_exists($data['file_formulir'])): ?>
                    <small>File formulir saat ini: <a href="<?= htmlspecialchars($data['file_formulir']) ?>" target="_blank">Lihat</a></small>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="peminjaman_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
