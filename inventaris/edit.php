<?php
include('../config/koneksi.php');
include('../layouts/header.php');
include('../layouts/sidebar.php');

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM inventaris WHERE id='$id'");
$inv = mysqli_fetch_assoc($data);

if (!$inv) {
  echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
  exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode = $_POST['kode_barang'];
  $nama = $_POST['nama_barang'];
  $jenis = $_POST['jenis_barang'];
  $merk = $_POST['merk_barang'];
  $kondisi = $_POST['kondisi_barang'];
  $spesifikasi = $_POST['spesifikasi_barang'];

  // Cek apakah upload foto baru
  if ($_FILES['foto_barang']['name'] != '') {
    $foto = $_FILES['foto_barang']['name'];
    $tmp = $_FILES['foto_barang']['tmp_name'];
    $upload_dir = '../assets/img/';
    $target = $upload_dir . basename($foto);

    move_uploaded_file($tmp, $target);

    $update = mysqli_query($conn, "UPDATE inventaris SET 
      kode_barang='$kode',
      nama_barang='$nama',
      jenis_barang='$jenis',
      merk_barang='$merk',
      kondisi_barang='$kondisi',
      spesifikasi_barang='$spesifikasi',
      foto_barang='$foto'
      WHERE id='$id'");
  } else {
    // Tanpa ubah foto
    $update = mysqli_query($conn, "UPDATE inventaris SET 
      kode_barang='$kode',
      nama_barang='$nama',
      jenis_barang='$jenis',
      merk_barang='$merk',
      kondisi_barang='$kondisi',
      spesifikasi_barang='$spesifikasi'
      WHERE id='$id'");
  }

  if ($update) {
    echo "<script>alert('Data berhasil diupdate'); window.location='index.php';</script>";
  } else {
    echo "<script>alert('Gagal update data');</script>";
  }
}
?>

<div class="content">
  <div class="container mt-4">
    <h4>Edit Inventaris</h4>
    <form method="post" enctype="multipart/form-data" class="mt-3">
      <div class="mb-3">
        <label>Kode Inventaris</label>
        <input type="text" name="kode_barang" value="<?= $inv['kode_barang'] ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Nama Inventaris</label>
        <input type="text" name="nama_barang" value="<?= $inv['nama_barang'] ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Jenis Inventaris</label>
        <input type="text" name="jenis_barang" value="<?= $inv['jenis_barang'] ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Merk Inventaris</label>
        <input type="text" name="merk_barang" value="<?= $inv['merk_barang'] ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Kondisi</label>
        <select name="kondisi_barang" class="form-control" required>
          <option value="Baik" <?= $inv['kondisi_barang'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
          <option value="Rusak Ringan" <?= $inv['kondisi_barang'] == 'Rusak Ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
          <option value="Rusak Berat" <?= $inv['kondisi_barang'] == 'Rusak Berat' ? 'selected' : '' ?>>Rusak Berat</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Spesifikasi</label>
        <textarea name="spesifikasi_barang" rows="4" class="form-control"><?= $inv['spesifikasi_barang'] ?></textarea>
      </div>
      <div class="mb-3">
        <label>Ganti Foto (Opsional)</label>
        <input type="file" name="foto_barang" class="form-control">
        <?php if ($inv['foto_barang']) : ?>
          <small class="text-muted">Foto sekarang: <?= $inv['foto_barang'] ?></small>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
