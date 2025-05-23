<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Ambil data stok dari database
$query = "SELECT * FROM stok_barang ORDER BY tanggal_input DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Data Stok Barang</h4>
      <div>
        <a href="stok_tambah.php" class="btn btn-primary">+ Tambah Barang</a>
        <a href="stok_tambah_stok.php" class="btn btn-success">+ Tambahkan Stok</a>
      </div>
    </div>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'hapus_berhasil'): ?>
      <div class="alert alert-success">Data berhasil dihapus.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Kategori</th>
          <th>Satuan</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Tanggal Input</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_barang']) ?></td>
              <td><?= htmlspecialchars($row['kategori']) ?></td>
              <td><?= htmlspecialchars($row['satuan']) ?></td>
              <td><?= (int)$row['jumlah'] ?></td>
              <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
              <td><?= date('d-m-Y', strtotime($row['tanggal_input'])) ?></td>
              <td>
                <a href="stok_edit.php?id=<?= $row['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="stok_hapus.php?id=<?= $row['id_barang'] ?>"
                   onclick="return confirm('Yakin ingin menghapus data ini?')"
                   class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">Belum ada data stok.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
