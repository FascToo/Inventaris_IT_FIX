<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Ambil data pengeluaran stok dengan join ke stok_barang dan pengaduan
$query = "
    SELECT ps.*, sb.nama_barang, sb.kategori, p.jenis_perangkat, p.divisi, p.id_pengaduan 
    FROM pengeluaran_stok ps
    LEFT JOIN stok_barang sb ON ps.id_barang = sb.id_barang
    LEFT JOIN pengaduan p ON ps.id_pengaduan = p.id_pengaduan
    ORDER BY ps.tanggal_keluar DESC
";

$result = mysqli_query($conn, $query);
?>

<div class="content">
  <div class="container mt-4">
    <h4>Riwayat Pengeluaran Stok</h4>

    <table class="table table-bordered mt-3">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Tanggal Keluar</th>
          <th>Nama Barang</th>
          <th>Kategori</th>
          <th>Jumlah</th>
          <th>Divisi Tujuan</th>
          <th>Jenis Perangkat</th>
          <th>Pengaduan ID</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= date('d-m-Y H:i', strtotime($row['tanggal_keluar'])) ?></td>
              <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['kategori'] ?? '-') ?></td>
              <td><?= (int)$row['jumlah'] ?></td>
              <td><?= htmlspecialchars($row['divisi'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['jenis_perangkat'] ?? '-') ?></td>
              <td>#<?= htmlspecialchars($row['id_pengaduan']) ?></td>
              <td><?= htmlspecialchars($row['keterangan']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">Belum ada data pengeluaran stok.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
