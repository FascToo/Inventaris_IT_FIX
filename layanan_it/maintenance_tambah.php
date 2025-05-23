<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengaduan = !empty($_POST['id_pengaduan']) ? intval($_POST['id_pengaduan']) : null;
    $kode_barang = $_POST['kode_barang'] ?? '';
    $masalah = $_POST['masalah'] ?? '';
    $solusi = $_POST['solusi'] ?? '';
    $teknisi = $_POST['teknisi'] ?? '';

    $stmt = $conn->prepare("INSERT INTO maintenance (id_pengaduan, kode_barang, masalah, solusi, teknisi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_pengaduan, $kode_barang, $masalah, $solusi, $teknisi);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan.'); window.location='maintenance_list.php';</script>";
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }
    $stmt->close();
    exit;
}
?>

<?php include('../layouts/header.php'); ?>
<?php include('../layouts/sidebar.php'); ?>

<div class="content">
  <div class="container mt-4">
    <h4>Tambah Data Maintenance</h4>
    <form method="POST">
      <div class="mb-3">
        <label for="kode_barang" class="form-label">Kode Barang</label>
        <select name="kode_barang" class="form-select" required>
          <option value="">-- Pilih Kode Barang --</option>
          <?php
          $barangResult = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM inventaris");
          while ($barang = mysqli_fetch_assoc($barangResult)) {
              echo "<option value=\"{$barang['kode_barang']}\">{$barang['kode_barang']} - {$barang['nama_barang']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="masalah" class="form-label">Masalah</label>
        <textarea name="masalah" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label for="solusi" class="form-label">Solusi</label>
        <textarea name="solusi" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label for="teknisi" class="form-label">Teknisi</label>
        <input type="text" name="teknisi" class="form-control" required>
      </div>
      <input type="hidden" name="id_pengaduan" value="">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="maintenance_list.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
