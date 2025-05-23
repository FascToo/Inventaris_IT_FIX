<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');
?>

<div class="content">
  <div class="container mt-4">
    <h4 class="mb-4">Form Pengaduan Perangkat</h4>

    <form method="POST" action="pengaduan_proses.php">

      <div class="mb-3">
        <label for="nama_pt" class="form-label">Nama PT</label>
        <input type="text" name="nama_pt" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="divisi" class="form-label">Divisi</label>
        <input type="text" name="divisi" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="lantai" class="form-label">Lantai</label>
        <input type="text" name="lantai" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="jenis_perangkat" class="form-label">Jenis Perangkat</label>
        <input type="text" name="jenis_perangkat" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi_masalah" class="form-label">Deskripsi Kendala</label>
        <textarea name="deskripsi_masalah" class="form-control" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
