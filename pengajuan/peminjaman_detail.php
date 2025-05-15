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
$sql = "SELECT p.*, u.username FROM peminjaman p JOIN users u ON p.id_user = u.id WHERE p.id='$id'";
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
        <h5 class="mb-0">Detail Peminjaman</h5>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>Tanggal Pinjam:</strong> <?= formatTanggal($data['tanggal_pinjam']) ?></li>
          <li class="list-group-item"><strong>Karyawan:</strong> <?= htmlspecialchars($data['username']) ?></li>
          <li class="list-group-item"><strong>Perusahaan:</strong> <?= htmlspecialchars($data['perusahaan']) ?></li>
          <li class="list-group-item"><strong>Jabatan:</strong> <?= htmlspecialchars($data['jabatan']) ?></li>
          <li class="list-group-item"><strong>Keterangan:</strong> <?= nl2br(htmlspecialchars($data['keterangan'])) ?></li>
          <li class="list-group-item"><strong>Kondisi Sekarang:</strong> <?= htmlspecialchars($data['kondisi_sekarang']) ?: '-' ?></li>
          <li class="list-group-item"><strong>Tanggal Cek Terakhir:</strong> <?= formatTanggal($data['tanggal_cek']) ?></li>
          <li class="list-group-item"><strong>Diajukan Pada:</strong> <?= formatTanggal($data['created_at']) ?></li>

          <?php if (!empty($data['file_formulir'])): ?>
            <li class="list-group-item">
              <strong>File Formulir:</strong><br>
              <?php 
                $filePath = '../uploads/' . $data['file_formulir'];
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Gambar bisa diklik dan memperbesar modal
                    echo "<img src=\"$filePath\" alt=\"Formulir\" class=\"img-fluid\" style=\"max-height:300px; cursor:pointer;\" data-bs-toggle=\"modal\" data-bs-target=\"#imageModal\">";
                } elseif ($ext === 'pdf') {
                    echo "<a href=\"$filePath\" target=\"_blank\" class=\"btn btn-outline-primary btn-sm\">Lihat PDF</a>";
                } else {
                    echo "<a href=\"$filePath\" download class=\"btn btn-outline-secondary btn-sm\">Download File</a>";
                }
              ?>
            </li>
          <?php else: ?>
            <li class="list-group-item"><strong>File Formulir:</strong> -</li>
          <?php endif; ?>

        </ul>
        <a href="peminjaman_list.php" class="btn btn-secondary mt-3">Kembali ke daftar</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk memperbesar gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid w-100" alt="Formulir Besar">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modalImage = document.getElementById('modalImage');
    const images = document.querySelectorAll('img[data-bs-toggle="modal"]');

    images.forEach(img => {
      img.addEventListener('click', function() {
        modalImage.src = this.src;
      });
    });
  });
</script>
