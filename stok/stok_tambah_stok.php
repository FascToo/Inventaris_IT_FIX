<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Ambil data barang yang tersedia
$barang = mysqli_query($conn, "SELECT id_barang, nama_barang FROM stok_barang ORDER BY nama_barang ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = intval($_POST['id_barang']);
    $jumlah = intval($_POST['jumlah']);

    if ($id_barang > 0 && $jumlah > 0) {
        // Update stok
        $stmt = $conn->prepare("UPDATE stok_barang SET jumlah = jumlah + ? WHERE id_barang = ?");
        $stmt->bind_param("ii", $jumlah, $id_barang);
        if ($stmt->execute()) {
            echo "<script>alert('Stok berhasil ditambahkan.'); window.location.href='stok_list.php';</script>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menambahkan stok.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-warning'>Silakan pilih barang dan jumlah yang valid.</div>";
    }
}
?>

<div class="content">
  <div class="container mt-4">
    <h4 class="mb-4">Tambahkan Stok Barang</h4>

    <form method="POST">
      <div class="mb-3">
        <label for="id_barang" class="form-label">Pilih Barang</label>
        <select name="id_barang" class="form-select" required>
          <option value="">-- Pilih Barang --</option>
          <?php while ($row = mysqli_fetch_assoc($barang)): ?>
            <option value="<?= $row['id_barang'] ?>"><?= htmlspecialchars($row['nama_barang']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah Tambahan</label>
        <input type="number" name="jumlah" class="form-control" min="1" required>
      </div>

      <button type="submit" class="btn btn-success">Tambah Stok</button>
      <a href="stok_list.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
