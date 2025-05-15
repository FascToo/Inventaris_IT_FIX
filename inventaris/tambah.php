<?php
include('../config/koneksi.php');
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Proses simpan data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode = $_POST['kode_barang'];
  $nama = $_POST['nama_barang'];
  $jenis = $_POST['jenis_barang'];
  $merk = $_POST['merk_barang'];
  $kondisi = $_POST['kondisi_barang'];
  $spesifikasi = $_POST['spesifikasi_barang'];

  // Upload foto
  $foto = $_FILES['foto_barang']['name'];
  $tmp = $_FILES['foto_barang']['tmp_name'];
  $upload_dir = '../assets/img/';
  $target = $upload_dir . basename($foto);

  if ($foto != '') {
    move_uploaded_file($tmp, $target);
  }

  // Simpan ke database
  $insert = mysqli_query($conn, "INSERT INTO inventaris (kode_barang, foto_barang, nama_barang, jenis_barang, merk_barang, kondisi_barang, spesifikasi_barang)
    VALUES ('$kode', '$foto', '$nama', '$jenis', '$merk', '$kondisi', '$spesifikasi')");

  if ($insert) {
    echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data');</script>";
  }
}
?>

<div class="content">
  <div class="container mt-4">
    <h4>Tambah Inventaris</h4>
    <form method="post" enctype="multipart/form-data" class="mt-3">
      <div class="mb-3">
        <label>Kode Inventaris</label>
        <input type="text" name="kode_barang" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Nama Inventaris</label>
        <input type="text" name="nama_barang" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Jenis Inventaris</label>
        <input type="text" name="jenis_inv" class="form-control">
      </div>
      <div class="mb-3">
        <label>Merk Inventaris</label>
        <input type="text" name="merk_barang" class="form-control">
      </div>
      <div class="mb-3">
        <label>Kondisi</label>
        <select name="kondisi_inv" class="form-control" required>
          <option value="">-- Pilih --</option>
          <option value="Baik">Baik</option>
          <option value="Rusak Ringan">Rusak Ringan</option>
          <option value="Rusak Berat">Rusak Berat</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Spesifikasi</label>
        <textarea name="spesifikasi_barang" rows="4" class="form-control"></textarea>
      </div>
      <div class="mb-3">
        <label>Upload Foto (optional)</label>
        <input type="file" name="foto_barang" class="form-control">
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
