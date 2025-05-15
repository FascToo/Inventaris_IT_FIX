<?php
include '../config/koneksi.php';
include '../layouts/header.php';
include '../layouts/sidebar.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM inventaris WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
  exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Detail Inventaris</h1>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body row">
        <div class="col-md-4">
          <?php if ($data['foto_barang']) : ?>
            <img src="../assets/img/<?= $data['foto_barang'] ?>" alt="<?= $data['nama_barang'] ?>" class="img-fluid rounded shadow" style="max-height: 300px;">
          <?php else : ?>
            <div class="alert alert-secondary">Tidak ada foto</div>
          <?php endif; ?>
        </div>
        <div class="col-md-8">
          <table class="table table-striped">
            <tr>
              <th>Kode</th>
              <td><?= $data['kode_barang'] ?></td>
            </tr>
            <tr>
              <th>Nama</th>
              <td><?= $data['nama_barang'] ?></td>
            </tr>
            <tr>
              <th>Jenis</th>
              <td><?= $data['jenis_barang'] ?></td>
            </tr>
            <tr>
              <th>Merk</th>
              <td><?= $data['merk_barang'] ?></td>
            </tr>
            <tr>
              <th>Kondisi</th>
              <td><?= $data['kondisi_barang'] ?></td>
            </tr>
            <tr>
              <th>Spesifikasi</th>
              <td><?= nl2br($data['spesifikasi_barang']) ?></td>
            </tr>
          </table>
          <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include '../layouts/footer.php'; ?>
