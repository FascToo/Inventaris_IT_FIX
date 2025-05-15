<!-- Sidebar -->
<div id="sidebar" class="sidebar d-flex flex-column p-3 text-white">
  <button class="toggle-btn" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>

  <ul class="nav nav-pills flex-column" id="menu">
    <li class="nav-item">
      <a href="../dashboard/index.php" class="nav-link" data-page="dashboard" onclick="loadPage('dashboard')">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="../inventaris/index.php" class="nav-link" data-page="inventaris" onclick="loadPage('inventaris')">
        <i class="bi bi-box"></i> <span>Inventaris</span>
      </a>
    </li>

    <li>
      <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#pengajuanMenu" role="button">
        <i class="bi bi-journal-plus"></i> <span>Pengajuan</span>
      </a>
      <div class="collapse" id="pengajuanMenu">
        <ul class="btn-toggle-nav list-unstyled ps-3">
          <li><a href="../pengajuan/permintaan_list.php" class="nav-link" data-page="permintaan" onclick="loadPage('permintaan')">Permintaan</a></li>
          <li><a href="../pengajuan/peminjaman_list.php" class="nav-link" data-page="peminjaman" onclick="loadPage('peminjaman')">Peminjaman</a></li>
        </ul>
      </div>
    </li>

    <li>
      <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#layananMenu" role="button">
        <i class="bi bi-tools"></i> <span>Layanan IT</span>
      </a>
      <div class="collapse" id="layananMenu">
        <ul class="btn-toggle-nav list-unstyled ps-3">
          <li><a href="#" class="nav-link" data-page="pengaduan" onclick="loadPage('pengaduan')">Pengajuan Pengaduan</a></li>
          <li><a href="#" class="nav-link" data-page="status" onclick="loadPage('status')">Status Pengaduan</a></li>
          <li><a href="#" class="nav-link" data-page="maintenance" onclick="loadPage('maintenance')">Maintenance</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link" data-page="stock" onclick="loadPage('stock')"><i class="bi bi-boxes"></i> <span>Stock</span></a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link" data-page="laporan" onclick="loadPage('laporan')"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
    </li>
  </ul>
</div>