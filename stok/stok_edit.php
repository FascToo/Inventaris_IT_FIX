<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if (!isset($_GET['id'])) {
    die("ID barang tidak ditemukan.");
}

$id_barang = intval($_GET['id']);
$query = $conn->prepare("SELECT * FROM stok_barang WHERE id_barang = ?");
$query->bind_param("i", $id_barang);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $satuan = $_POST['satuan'];
    $jumlah = intval($_POST['jumlah']);
    $keterangan = $_POST['keterangan'];

    $update = $conn->prepare("UPDATE stok_barang SET nama_barang=?, kategori=?, satuan=?, jumlah=?, keterangan=? WHERE id_barang=?");
    $update->bind_param("sssisi", $nama_barang, $kategori, $satuan, $jumlah, $keterangan, $id_barang);
    if ($update->execute()) {
        header("Location: stok_list.php?pesan=berhasil_edit");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal mengupdate data.</div>";
    }
}
?>

<div class="content">
  <div class="container mt-4">
    <h4>Edit Data Barang</h4>
    <form method="POST">
      <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($data['kategori']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" name="satuan" class="form-control" value="<?= htmlspecialchars($data['satuan']) ?>">
      </div>
      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" name="jumlah" class="form-control" value="<?= (int)$data['jumlah'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control"><?= htmlspecialchars($data['keterangan']) ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="stok_list.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
