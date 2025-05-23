<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Ambil data maintenance dan nama barang
$query = "SELECT m.*, i.nama_barang 
          FROM maintenance m 
          LEFT JOIN inventaris i ON m.kode_barang = i.kode_barang 
          ORDER BY m.tanggal_maintenance DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Data Maintenance Perangkat</h4>
      <a href="maintenance_tambah.php" class="btn btn-primary">+ Tambah Maintenance</a>
    </div>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'hapus_berhasil'): ?>
      <div class="alert alert-success">Data maintenance berhasil dihapus.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Masalah</th>
          <th>Solusi</th>
          <th>Teknisi</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['kode_barang']) ?></td>
              <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
              <td><?= nl2br(htmlspecialchars($row['masalah'])) ?></td>
              <td><?= nl2br(htmlspecialchars($row['solusi'])) ?></td>
              <td><?= htmlspecialchars($row['teknisi']) ?></td>
              <td><?= date('d-m-Y', strtotime($row['tanggal_maintenance'])) ?></td>
              <td>
                <a href="maintenance_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="maintenance_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">Belum ada data maintenance.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
