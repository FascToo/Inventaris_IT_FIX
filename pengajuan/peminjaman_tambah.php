<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if ($_SESSION['role'] != 'Karyawan') {
    die("Akses hanya untuk karyawan.");
}

// Ambil data inventaris untuk dropdown
$inventarisQuery = "SELECT kode_barang, nama_barang FROM inventaris ORDER BY nama_barang ASC";
$inventarisResult = mysqli_query($conn, $inventarisQuery);

if (isset($_POST['submit'])) {
    $id_user = $_SESSION['id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']); // baru
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['perusahaan']);
    $divisi = mysqli_real_escape_string($conn, $_POST['jabatan']);
    // kita hapus jenis_barang dan spesifikasi karena sudah ada di inventaris
    $jumlah = intval($_POST['jumlah']);
    $kondisi_barang = mysqli_real_escape_string($conn, $_POST['kondisi_pinjam']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Upload formulir
    $formulir_name = $_FILES['file_formulir']['name'];
    $formulir_tmp = $_FILES['file_formulir']['tmp_name'];
    $upload_dir = "../uploads/";
    $path_formulir = "";

    if (!empty($formulir_name)) {
        $ext = pathinfo($formulir_name, PATHINFO_EXTENSION);
        $new_name = uniqid() . '.' . $ext;
        $path_formulir = $upload_dir . $new_name;

        if (!move_uploaded_file($formulir_tmp, $path_formulir)) {
            echo "<script>alert('Gagal upload formulir.');</script>";
            $path_formulir = "";
        }
    }

    $query = "INSERT INTO peminjaman (
        id_user, tanggal_pinjam, kode_barang, perusahaan, jabatan, jumlah, kondisi_pinjam, keterangan, file_formulir
    ) VALUES (
        '$id_user', '$tanggal_pinjam', '$kode_barang', '$nama_perusahaan', '$divisi', '$jumlah', '$kondisi_barang', '$keterangan', '$path_formulir'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengajuan peminjaman berhasil dikirim.'); window.location='peminjaman_list.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="content">
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Pengajuan Peminjaman Perangkat IT</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="tanggal_pinjam" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kode_barang" class="form-label">Pilih Barang</label>
                            <select class="form-select" name="kode_barang" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php while ($item = mysqli_fetch_assoc($inventarisResult)) : ?>
                                    <option value="<?= htmlspecialchars($item['kode_barang']) ?>">
                                        <?= htmlspecialchars($item['kode_barang'] . ' - ' . $item['nama_barang']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="perusahaan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="divisi" class="form-label">Divisi / Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                            <select class="form-select" name="kondisi_pinjam" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Untuk kebutuhan kerja lapangan, troubleshooting, dll."></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="peminjaman_list.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="submit" class="btn btn-success">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
