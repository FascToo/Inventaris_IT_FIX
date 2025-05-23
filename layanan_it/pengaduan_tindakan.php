<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if (!isset($_SESSION['id'])) {
    die("Akses ditolak. Anda belum login.");
}

$id_user = $_SESSION['id'];
$role = $_SESSION['role'];

if (!isset($_GET['id'])) {
    die("ID pengaduan tidak ditemukan.");
}

$id_pengaduan = intval($_GET['id']);

// Ambil data pengaduan
$sql = "SELECT p.*, u.username 
        FROM pengaduan p 
        JOIN users u ON p.id_user = u.id 
        WHERE p.id_pengaduan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pengaduan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data pengaduan tidak ditemukan.");
}

$data = $result->fetch_assoc();

// Cek akses: karyawan hanya bisa akses datanya sendiri
if ($role === 'Karyawan' && $data['id_user'] != $id_user) {
    die("Akses ditolak.");
}

// Ambil data stok untuk opsi penggunaan
$stok_result = mysqli_query($conn, "SELECT id_barang, nama_barang, satuan FROM stok_barang ORDER BY nama_barang ASC");
?>

<div class="content">
    <div class="container mt-4">
        <h4>Detail Pengaduan & Tindakan</h4>
        <table class="table table-bordered mt-3">
            <tr>
                <th>ID Pengaduan</th>
                <td><?= htmlspecialchars($data['id_pengaduan']) ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= htmlspecialchars($data['username']) ?></td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td><?= htmlspecialchars($data['divisi']) ?></td>
            </tr>
            <tr>
                <th>Jenis Perangkat</th>
                <td><?= htmlspecialchars($data['jenis_perangkat']) ?></td>
            </tr>
            <tr>
                <th>Deskripsi Kerusakan</th>
                <td><?= nl2br(htmlspecialchars($data['deskripsi_masalah'])) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= htmlspecialchars($data['status']) ?></td>
            </tr>
            <tr>
                <th>Tanggal Pengaduan</th>
                <td><?= date('d-m-Y H:i', strtotime($data['tanggal_pengaduan'])) ?></td>
            </tr>
        </table>

        <!-- Form tindakan -->
        <div class="mt-4">
            <h5>Input Tindakan Perbaikan</h5>
            <form action="proses_tindakan.php" method="POST">
                <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan'] ?>">

                <div class="mb-3">
                    <label for="tindakan" class="form-label">Tindakan yang Dilakukan</label>
                    <textarea name="tindakan" class="form-control" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="pic_it" class="form-label">PIC IT</label>
                    <input type="text" name="pic_it" class="form-control" required placeholder="Masukkan nama teknisi IT">
                </div>

                <div class="mb-3">
                    <label for="id_barang" class="form-label">Barang yang Digunakan (Opsional)</label>
                    <select name="id_barang" class="form-select">
                        <option value="">-- Tidak menggunakan stok --</option>
                        <?php while ($stok = mysqli_fetch_assoc($stok_result)): ?>
                            <option value="<?= $stok['id_barang'] ?>">
                                <?= htmlspecialchars($stok['nama_barang']) ?> (<?= $stok['satuan'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah yang Digunakan (jika ada)</label>
                    <input type="number" name="jumlah" class="form-control" min="1">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Tindakan</button>
                <a href="pengaduan_list.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
