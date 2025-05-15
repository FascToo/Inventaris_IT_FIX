<?php
include '../config/koneksi.php';
include '../auth/cek_login.php';
include('../layouts/header.php');
include('../layouts/sidebar.php');

if ($_SESSION['role'] != 'Karyawan') {
    die("Akses hanya untuk karyawan.");
}

if (isset($_POST['submit'])) {
    $id_user = $_SESSION['id'];
    $tanggal_permintaan = $_POST['tanggal_permintaan'];
    $perusahaan = mysqli_real_escape_string($conn, $_POST['perusahaan']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $jenis_barang = mysqli_real_escape_string($conn, $_POST['jenis_barang']);
    $spesifikasi = mysqli_real_escape_string($conn, $_POST['spesifikasi']);
    $jumlah = intval($_POST['jumlah']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Upload file formulir
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

    $query = "INSERT INTO permintaan (
        id_user, tanggal_permintaan, perusahaan, jabatan, jenis_barang, spesifikasi, jumlah, keterangan, file_formulir
    ) VALUES (
        '$id_user', '$tanggal_permintaan', '$perusahaan', '$jabatan', '$jenis_barang', '$spesifikasi', '$jumlah', '$keterangan', '$path_formulir'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Permintaan berhasil dikirim.'); window.location='permintaan_list.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="content">
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Permintaan Barang IT</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                            <input type="date" class="form-control" name="tanggal_permintaan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="perusahaan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">Divisi / Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_barang" class="form-label">Jenis Barang</label>
                            <input type="text" class="form-control" name="jenis_barang" placeholder="Contoh: Laptop, Mouse" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="spesifikasi" class="form-label">Spesifikasi Barang</label>
                            <textarea class="form-control" name="spesifikasi" rows="2" placeholder="Contoh: Dell Latitude 7490, Core i5, 8GB RAM" required></textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Untuk kebutuhan kerja lapangan, troubleshooting, dll."></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="file_formulir" class="form-label">Upload Formulir Permintaan (Opsional)</label>
                            <input type="file" class="form-control" name="file_formulir" accept=".pdf,.doc,.docx,.jpg,.png">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="permintaan_list.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="submit" class="btn btn-success">Ajukan Permintaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../layouts/footer.php'); ?>
