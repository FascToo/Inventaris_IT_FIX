<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

$pesan = '';

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $satuan = $_POST['satuan'] ?? 'pcs';
    $jumlah = intval($_POST['jumlah']);
    $keterangan = $_POST['keterangan'];

    if (empty($nama_barang) || empty($kategori) || $jumlah < 0) {
        $pesan = '<div class="alert alert-danger">Semua field wajib diisi dengan benar.</div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO stok_barang (nama_barang, kategori, satuan, jumlah, keterangan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nama_barang, $kategori, $satuan, $jumlah, $keterangan);

        if ($stmt->execute()) {
            $pesan = '<div class="alert alert-success">Stok berhasil ditambahkan.</div>';
        } else {
            $pesan = '<div class="alert alert-danger">Gagal menyimpan: ' . $conn->error . '</div>';
        }

        $stmt->close();
    }
}
?>

<div class="content">
  <div class="container mt-4">
    <h4 class="mb-4">Tambah Stok Barang</h4>

    <?= $pesan ?>

    <form method="POST">
      <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang</label>
        <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Contoh: RAM, HDD, SSD" required>
      </div>

      <div class="mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" name="satuan" id="satuan" class="form-control" value="pcs">
      </div>

      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" min="0" required>
      </div>

      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="stok_list.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
