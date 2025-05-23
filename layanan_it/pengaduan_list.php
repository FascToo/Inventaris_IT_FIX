<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if (!isset($_SESSION['id'])) {
  die("Akses ditolak. Anda belum login.");
}

$id_user = $_SESSION['id'];
$role = $_SESSION['role'];
$status_filter = $_GET['status'] ?? '';

// Query berdasarkan role
if ($role === 'Karyawan') {
  $sql = "SELECT p.*, u.username, pt.nama_pt, d.nama_divisi 
          FROM pengaduan p 
          JOIN users u ON p.id_user = u.id 
          LEFT JOIN master_pt pt ON p.id_pt = pt.id_pt
          LEFT JOIN master_divisi d ON p.kode_divisi = d.kode_divisi
          WHERE p.id_user = ?";
  if (!empty($status_filter)) {
    $sql .= " AND p.status = ?";
  }
  $sql .= " ORDER BY p.tanggal_pengaduan DESC";
  $stmt = $conn->prepare($sql);
  if (!empty($status_filter)) {
    $stmt->bind_param("is", $id_user, $status_filter);
  } else {
    $stmt->bind_param("i", $id_user);
  }
} elseif (in_array($role, ['Manajer', 'Admin'])) {
  $sql = "SELECT p.*, u.username, pt.nama_pt, d.nama_divisi 
          FROM pengaduan p 
          JOIN users u ON p.id_user = u.id 
          LEFT JOIN master_pt pt ON p.id_pt = pt.id_pt
          LEFT JOIN master_divisi d ON p.kode_divisi = d.kode_divisi";
  if (!empty($status_filter)) {
    $sql .= " WHERE p.status = ?";
    $sql .= " ORDER BY p.tanggal_pengaduan DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status_filter);
  } else {
    $sql .= " ORDER BY p.tanggal_pengaduan DESC";
    $stmt = $conn->prepare($sql);
  }
} else {
  die("Akses ditolak.");
}

if (!$stmt) {
  die("Query gagal: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar Pengaduan Perangkat</h4>
      <?php if ($role === 'Karyawan'): ?>
        <a href="pengaduan_tambah.php" class="btn btn-primary">+ Buat Pengaduan</a>
      <?php endif; ?>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
      <?php if ($_GET['pesan'] === 'status_updated'): ?>
        <div class="alert alert-info">Status pengaduan berhasil diperbarui.</div>
      <?php elseif ($_GET['pesan'] === 'hapus_berhasil'): ?>
        <div class="alert alert-success">Pengaduan berhasil dihapus.</div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Filter -->
    <form method="GET" class="mb-3">
      <div class="row g-2 align-items-center">
        <div class="col-auto">
          <label for="status" class="form-label">Filter Status:</label>
        </div>
        <div class="col-auto">
          <select name="status" id="status" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <?php
            $status_options = ['Pending', 'Diproses', 'Diperbaiki', 'Tidak Bisa Diperbaiki'];
            foreach ($status_options as $status) {
              $selected = ($status_filter === $status) ? 'selected' : '';
              echo "<option value=\"$status\" $selected>$status</option>";
            }
            ?>
          </select>
        </div>
      </div>
    </form>

    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Nama PT</th>
          <th>Divisi</th>
          <th>Lantai</th>
          <th>Jenis Perangkat</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id_pengaduan']) ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['nama_pt'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['nama_divisi'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['lantai'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['jenis_perangkat']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td><?= date('d-m-Y H:i', strtotime($row['tanggal_pengaduan'])) ?></td>
              <td>
                <a href="pengaduan_detail.php?id=<?= $row['id_pengaduan'] ?>" class="btn btn-info btn-sm">Detail</a>

                <?php if (
                  ($role === 'Karyawan' && $row['status'] === 'Pending') ||
                  in_array($role, ['Manajer', 'Admin'])
                ): ?>
                  <a href="pengaduan_edit.php?id=<?= $row['id_pengaduan'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <?php endif; ?>

                <?php if ($role === 'Karyawan' && $row['status'] === 'Pending'): ?>
                  <form method="POST" action="pengaduan_hapus.php" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                    <input type="hidden" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                <?php elseif ($role === 'Admin'): ?>
                  <form method="POST" action="pengaduan_hapus.php" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                    <input type="hidden" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                <?php endif; ?>

                <?php if ($role === 'Karyawan' && strtolower($row['status']) === 'tidak bisa diperbaiki'): ?>
                  <a href="../pengajuan/permintaan_list.php?id_pengaduan=<?= $row['id_pengaduan'] ?>"
                    class="btn btn-warning btn-sm">Pengajuan Permintaan</a>
                <?php endif; ?>

                <?php if (in_array($role, ['Manajer', 'Admin'])): ?>
                  <?php
                  $status = $row['status'];
                  $id_pengaduan = $row['id_pengaduan'];
                  ?>

                  <?php if ($status === 'Pending'): ?>
                    <form method="POST" action="pengaduan_ubah_status.php" class="d-inline">
                      <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan ?>">
                      <input type="hidden" name="action" value="Diproses">
                      <button type="submit" class="btn btn-secondary btn-sm">Diproses</button>
                    </form>

                  <?php elseif ($status === 'Diproses'): ?>
                    <a href="pengaduan_tindakan.php?id=<?= $id_pengaduan ?>" class="btn btn-success btn-sm">Diperbaiki</a>
                    <form method="POST" action="pengaduan_ubah_status.php" class="d-inline">
                      <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan ?>">
                      <input type="hidden" name="action" value="Tidak Bisa Diperbaiki">
                      <button type="submit" class="btn btn-danger btn-sm">Tidak Bisa Diperbaiki</button>
                    </form>

                  <?php elseif ($status === 'Diperbaiki'): ?>
                    <?php
                    $cekMaintenance = $conn->prepare("SELECT 1 FROM maintenance WHERE id_pengaduan = ?");
                    $cekMaintenance->bind_param("i", $id_pengaduan);
                    $cekMaintenance->execute();
                    $hasMaintenance = $cekMaintenance->get_result()->num_rows > 0;
                    $cekMaintenance->close();
                    ?>
                    <?php if (!$hasMaintenance): ?>
                      <a href="maintenance_tambah.php?id=<?= $id_pengaduan ?>" class="btn btn-warning btn-sm">Kirim ke
                        Maintenance</a>
                    <?php else: ?>
                      <span class="badge bg-success">Selesai</span>
                    <?php endif; ?>

                  <?php elseif ($status === 'Tidak Bisa Diperbaiki'): ?>
                    <span class="badge bg-danger">Selesai</span>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if ($role === 'Karyawan' && in_array($row['status'], ['Diperbaiki', 'Tidak Bisa Diperbaiki'])): ?>
                  <?php
                  $cekReview = $conn->prepare("SELECT 1 FROM review_pengaduan WHERE id_pengaduan = ? AND id_user = ?");
                  $cekReview->bind_param("ii", $row['id_pengaduan'], $id_user);
                  $cekReview->execute();
                  $reviewResult = $cekReview->get_result();
                  $cekReview->close();
                  ?>
                  <?php if ($reviewResult->num_rows === 0): ?>
                    <a href="review_pengaduan.php?id=<?= $row['id_pengaduan'] ?>" class="btn btn-warning btn-sm">Review</a>
                  <?php endif; ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">Tidak ada data pengaduan.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$stmt->close();
include('../layouts/footer.php');
?>