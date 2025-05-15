<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

// Fungsi format tanggal agar lebih enak dibaca
function formatTanggal($date) {
    return $date ? date('d-m-Y H:i', strtotime($date)) : '-';
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID tidak ditemukan.");
}

$id = mysqli_real_escape_string($conn, $id);
$sql = "SELECT p.*, u.username FROM permintaan p JOIN users u ON p.id_user = u.id WHERE p.id='$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<div class="content">
  <div class="container mt-4">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Permintaan</h5>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>Tanggal Permintaan:</strong> <?= formatTanggal($data['tanggal_permintaan']) ?></li>
          <li class="list-group-item"><strong>Karyawan:</strong> <?= htmlspecialchars($data['username']) ?></li>
          <li class="list-group-item"><strong>Perusahaan:</strong> <?= htmlspecialchars($data['perusahaan']) ?></li>
          <li class="list-group-item"><strong>Jabatan:</strong> <?= htmlspecialchars($data['jabatan']) ?></li>
          <li class="list-group-item"><strong>Keterangan:</strong> <?= nl2br(htmlspecialchars($data['keterangan'])) ?></li>
          <li class="list-group-item"><strong>Status Permintaan:</strong> <?= htmlspecialchars($data['status']) ?></li>
          <li class="list-group-item"><strong>Diajukan Pada:</strong> <?= formatTanggal($data['created_at']) ?></li>
        </ul>
        <a href="permintaan_list.php" class="btn btn-secondary mt-3">Kembali ke daftar</a>
      </div>
    </div>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
