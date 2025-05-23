<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID tidak ditemukan.");
}

// Ambil data yang akan diedit
$stmt = $conn->prepare("SELECT * FROM maintenance WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data maintenance tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengaduan = $_POST['id_pengaduan'] ?? null;
    $kode_barang = $_POST['kode_barang'] ?? '';
    $masalah = $_POST['masalah'] ?? '';
    $solusi = $_POST['solusi'] ?? '';
    $teknisi = $_POST['teknisi'] ?? '';

    $update = $conn->prepare("UPDATE maintenance SET id_pengaduan = ?, kode_barang = ?, masalah = ?, solusi = ?, teknisi = ? WHERE id = ?");
    $update->bind_param("issssi", $id_pengaduan, $kode_barang, $masalah, $solusi, $teknisi, $id);

    if ($update->execute()) {
        echo "<script>alert('Data berhasil diperbarui.'); window.location='maintenance_list.php';</script>";
        exit;
    } else {
        echo "Gagal memperbarui data: " . $update->error;
    }
}
?>

<?php include('../layouts/header.php'); ?>
<?php include('../layouts/sidebar.php'); ?>

<div class="content">
  <div class="container mt-4">
    <h4>Edit Data Maintenance</h4>
    <form method="POST">
      <div class="mb-3">
        <label for="kode_barang" class="form-label">Kode Barang</label>
        <select name="kode_barang" class="form-select" required>
          <option value="">-- Pilih Kode Barang --</option>
          <?php
          $barangResult = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM inventaris");
          while ($barang = mysqli_fetch_assoc($barangResult)) {
              $selected = $barang['kode_barang'] === $data['kode_barang'] ? 'selected' : '';
              echo "<option value=\"{$barang['kode_barang']}\" $selected>{$barang['kode_barang']} - {$barang['nama_barang']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="masalah" class="form-label">Masalah</label>
        <textarea name="masalah" class="form-control" required><?= htmlspecialchars($data['masalah']) ?></textarea>
      </div>
      <div class="mb-3">
        <label for="solusi" class="form-label">Solusi</label>
        <textarea name="solusi" class="form-control" required><?= htmlspecialchars($data['solusi']) ?></textarea>
      </div>
      <div class="mb-3">
        <label for="teknisi" class="form-label">Teknisi</label>
        <input type="text" name="teknisi" class="form-control" value="<?= htmlspecialchars($data['teknisi']) ?>" required>
      </div>
      <input type="hidden" name="id_pengaduan" value="<?= htmlspecialchars($data['id_pengaduan']) ?>">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="maintenance_list.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
