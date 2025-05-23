<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

$id_pengaduan = $_GET['id'] ?? null;
if (!$id_pengaduan) {
    echo "<script>alert('ID tidak ditemukan'); window.location.href='pengaduan_list.php';</script>";
    exit;
}

$id_user = $_SESSION['id'];
$role = $_SESSION['role'];

$stmt = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ?");
$stmt->bind_param("i", $id_pengaduan);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location.href='pengaduan_list.php';</script>";
    exit;
}

if ($role === 'Karyawan' && $data['id_user'] != $id_user) {
    die("Akses ditolak.");
}

$inventaris = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM inventaris ORDER BY nama_barang ASC");
?>

<div class="content">
    <div class="container mt-4">
        <h4>Edit Pengaduan</h4>
        <form action="pengaduan_update.php" method="POST">
            <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan'] ?>">

            <div class="mb-3">
                <label for="nama_pt" class="form-label">Nama PT</label>
                <input type="text" name="nama_pt" class="form-control" value="<?= htmlspecialchars($data['nama_pt']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="divisi" class="form-label">Divisi</label>
                <input type="text" name="divisi" class="form-control" value="<?= htmlspecialchars($data['divisi']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="lantai" class="form-label">Lantai</label>
                <input type="text" name="lantai" class="form-control" value="<?= htmlspecialchars($data['lantai']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="jenis_perangkat" class="form-label">Jenis Perangkat</label>
                <input type="text" name="jenis_perangkat" class="form-control" value="<?= htmlspecialchars($data['jenis_perangkat']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi_masalah" class="form-label">Deskripsi Masalah</label>
                <textarea name="deskripsi_masalah" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi_masalah']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="kode_barang" class="form-label">Kode Barang</label>
                <select name="kode_barang" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php while ($inv = mysqli_fetch_assoc($inventaris)): ?>
                        <option value="<?= $inv['kode_barang'] ?>" <?= $inv['kode_barang'] == $data['kode_barang'] ? 'selected' : '' ?>>
                            <?= $inv['kode_barang'] ?> - <?= $inv['nama_barang'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="pengaduan_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
