<?php
include('../config/koneksi.php');
include('../layouts/header.php');
include('../layouts/sidebar.php');

$query = mysqli_query($conn, "SELECT * FROM inventaris");
?>

<div class="content">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Data Inventaris</h4>
            <a href="tambah.php" class="btn btn-primary">+ Tambah Inventaris</a>
        </div>

        <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kode Inventaris</th>
                    <th>Nama Inventaris</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><a href="detail.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['kode_barang']) ?></a></td>
                        <td><a href="detail.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['nama_barang']) ?></a></td>
                        <td><?= htmlspecialchars($row['jenis_barang']) ?></td>
                        <td><?= htmlspecialchars($row['merk_barang']) ?></td>
                        <td><?= htmlspecialchars($row['kondisi_barang']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>"
                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>