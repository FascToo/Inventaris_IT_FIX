<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if (!isset($_GET['id'])) {
    die("ID pengaduan tidak ditemukan.");
}

$id_pengaduan = $_GET['id'];
$id_user = $_SESSION['id'];

// Cek apakah review sudah pernah dibuat
$cek = $conn->prepare("SELECT * FROM review_pengaduan WHERE id_pengaduan = ? AND id_user = ?");
$cek->bind_param("ii", $id_pengaduan, $id_user);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {
    echo "<div class='alert alert-warning'>Review sudah pernah diberikan.</div>";
    include('../layouts/footer.php');
    exit;
}

// Ambil data pengaduan untuk validasi
$cek_pengaduan = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ? AND id_user = ? AND status IN ('Diperbaiki', 'Tidak Bisa Diperbaiki')");
$cek_pengaduan->bind_param("ii", $id_pengaduan, $id_user);
$cek_pengaduan->execute();
$data_pengaduan = $cek_pengaduan->get_result();

if ($data_pengaduan->num_rows === 0) {
    echo "<div class='alert alert-danger'>Pengaduan tidak valid atau belum selesai.</div>";
    include('../layouts/footer.php');
    exit;
}
?>

<div class="container mt-4">
    <h4>Review Kinerja IT</h4>
    <form method="POST" action="review_pengaduan_proses.php">
        <input type="hidden" name="id_pengaduan" value="<?= htmlspecialchars($id_pengaduan) ?>">

        <div class="mb-3">
            <label>Apakah Anda puas dengan layanan IT?</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="puas" id="puas1" value="Ya" required>
                <label class="form-check-label" for="puas1">Ya</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="puas" id="puas2" value="Tidak">
                <label class="form-check-label" for="puas2">Tidak</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="komentar">Komentar Tambahan (opsional)</label>
            <textarea class="form-control" name="komentar" id="komentar" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Review</button>
    </form>
</div>

<?php include('../layouts/footer.php'); ?>
