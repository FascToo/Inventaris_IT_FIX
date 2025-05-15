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

// Ambil data berdasarkan role
if ($role === 'Karyawan') {
    $sql = "SELECT p.*, u.username 
            FROM permintaan p 
            JOIN users u ON p.id_user = u.id 
            WHERE p.id_user = '$id_user' 
            ORDER BY p.created_at DESC";
} elseif ($role === 'Manajer' || $role === 'Admin') {
    $sql = "SELECT p.*, u.username 
            FROM permintaan p 
            JOIN users u ON p.id_user = u.id 
            ORDER BY p.created_at DESC";
} else {
    die("Akses ditolak.");
}

$result = mysqli_query($conn, $sql);
?>

<div class="content">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Pengajuan Permintaan</h4>
            <?php if ($role === 'Karyawan'): ?>
                <a href="permintaan_tambah.php" class="btn btn-primary">+ Ajukan Permintaan</a>
            <?php endif; ?>
        </div>

        <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Karyawan</th>
                    <th>Tanggal Permintaan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Kondisi Sekarang</th>
                    <th>Tanggal Cek</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_permintaan'])) ?></td>
                        <td>
                            <?php
                                $status = strtolower($row['status']);
                                switch ($status) {
                                    case 'pending':
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                        break;
                                    case 'disetujui':
                                        echo '<span class="badge bg-success">Disetujui</span>';
                                        break;
                                    case 'ditolak':
                                        echo '<span class="badge bg-danger">Ditolak</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">' . htmlspecialchars($row['status']) . '</span>';
                                }
                            ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['keterangan'])) ?></td>
                        <td><?= htmlspecialchars($row['kondisi_sekarang']) ?: '-' ?></td>
                        <td><?= !empty($row['tanggal_cek']) ? date('d-m-Y', strtotime($row['tanggal_cek'])) : '-' ?></td>
                        <td>
                            <a href="permintaan_detail.php?id=<?= urlencode($row['id']) ?>" class="btn btn-info btn-sm mb-1">Detail</a>
                            <a href="permintaan_update_kondisi.php?id=<?= urlencode($row['id']) ?>" class="btn btn-secondary btn-sm mb-1">Update Kondisi</a>
                            
                            <?php if ($role === 'Admin' || $role === 'Manajer'): ?>
                                <?php if ($status === 'pending'): ?>
                                    <a href="permintaan_acc.php?id=<?= urlencode($row['id']) ?>&action=approve"
                                       class="btn btn-success btn-sm mb-1"
                                       onclick="return confirm('Setujui permintaan?')">Setujui</a>
                                    <a href="permintaan_acc.php?id=<?= urlencode($row['id']) ?>&action=reject"
                                       class="btn btn-danger btn-sm mb-1"
                                       onclick="return confirm('Tolak permintaan?')">Tolak</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
