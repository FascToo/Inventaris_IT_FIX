<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if (!isset($_GET['id'])) {
    die("ID pengaduan tidak ditemukan.");
}

$id_pengaduan = intval($_GET['id']);

// Ambil data utama pengaduan + user
$query = $conn->prepare("SELECT p.*, u.username 
                         FROM pengaduan p 
                         JOIN users u ON p.id_user = u.id 
                         WHERE p.id_pengaduan = ?");
$query->bind_param("i", $id_pengaduan);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Data pengaduan tidak ditemukan.");
}

$data = $result->fetch_assoc();
$query->close();
?>

<div class="content">
    <div class="container mt-4">
        <h4>Detail Pengaduan</h4>
        <table class="table table-bordered">
            <tr>
                <th>ID Pengaduan</th>
                <td><?= htmlspecialchars($data['id_pengaduan']) ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= htmlspecialchars($data['username']) ?></td>
            </tr>
            <tr>
                <th>Nama PT</th>
                <td><?= htmlspecialchars($data['nama_pt']) ?></td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td><?= htmlspecialchars($data['divisi']) ?></td>
            </tr>
            <tr>
                <th>Lantai</th>
                <td><?= htmlspecialchars($data['lantai']) ?></td>
            </tr>
            <tr>
                <th>Jenis Perangkat</th>
                <td><?= htmlspecialchars($data['jenis_perangkat']) ?></td>
            </tr>
            <tr>
                <th>Deskripsi Masalah</th>
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

        <!-- Tindakan Perbaikan -->
        <?php if (!empty($data['tindakan_perbaikan'])): ?>
            <h5 class="mt-4">Tindakan Perbaikan</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Tindakan yang Dilakukan</th>
                    <td><?= nl2br(htmlspecialchars($data['tindakan_perbaikan'])) ?></td>
                </tr>
                <tr>
                    <th>PIC IT</th>
                    <td><?= htmlspecialchars($data['pic_it'] ?? '-') ?></td>
                </tr>
            </table>
        <?php endif; ?>

        <!-- Pengeluaran Stok -->
        <h5 class="mt-4">Barang yang Digunakan (Stok)</h5>
        <?php
        $sql_stok = $conn->prepare("SELECT ps.jumlah, sb.nama_barang, sb.satuan
                            FROM pengeluaran_stok ps
                            JOIN stok_barang sb ON ps.id_barang = sb.id_barang
                            WHERE ps.id_pengaduan = ?");
        $sql_stok->bind_param("i", $id_pengaduan);
        $sql_stok->execute();
        $stok_result = $sql_stok->get_result();
        ?>

        <?php if ($stok_result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($stok = $stok_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($stok['nama_barang']) ?></td>
                            <td><?= (int) $stok['jumlah'] ?></td>
                            <td><?= htmlspecialchars($stok['satuan']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-muted">Tidak ada stok yang dikeluarkan.</div>
        <?php endif; ?>
        <?php $sql_stok->close(); ?>

        <a href="pengaduan_list.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>