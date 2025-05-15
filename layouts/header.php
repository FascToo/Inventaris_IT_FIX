<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../config/koneksi.php';

// Semua user lihat semua notifikasi: pending, disetujui, ditolak
$queryNotif = "
    SELECT 'peminjaman' AS tipe, id, status, created_at FROM peminjaman 
    WHERE status IN ('pending', 'disetujui', 'ditolak') 
    UNION ALL
    SELECT 'permintaan' AS tipe, id, status, created_at FROM permintaan 
    WHERE status IN ('pending', 'disetujui', 'ditolak')
    ORDER BY created_at DESC
    LIMIT 5
";

$queryUnread = "
    SELECT 
        (SELECT COUNT(*) FROM peminjaman WHERE status IN ('pending', 'disetujui', 'ditolak') AND dibaca_admin = 0) +
        (SELECT COUNT(*) FROM permintaan WHERE status IN ('pending', 'disetujui', 'ditolak') AND dibaca_admin = 0) AS jml
";

$resultNotif = mysqli_query($conn, $queryNotif);
$resUnread = mysqli_query($conn, $queryUnread);
$rowUnread = mysqli_fetch_assoc($resUnread);
$jmlNotif = $rowUnread['jml'] ?? 0;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SI Manajemen Inventaris IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
        }

        .navbar {
            z-index: 1040;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 50px;
            left: 0;
            width: 250px;
            background-color: #212529;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #ced4da;
            padding: 10px 20px;
            transition: background-color 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background-color: #343a40;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 80px 30px 60px 30px;
            min-height: calc(100vh - 56px - 50px);
        }

        .footer {
            background-color: #ffffff;
            border-top: 1px solid #dee2e6;
            text-align: center;
            padding: 12px;
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            z-index: 1030;
        }

        .btn-toggle-nav a {
            font-size: 0.95rem;
            display: block;
            padding: 5px 0 5px 20px;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .nav-link {
            color: #ffffffcc;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
            font-weight: bold;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .toggle-btn {
  position: fixed;
  top: 10px;
  left: 10px;
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  padding: 6px 10px;
  cursor: pointer;
  z-index: 2000; /* buat di atas semua */
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.toggle-btn:hover {
  background-color: rgba(255, 255, 255, 0.2);
}
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Inventaris IT</span>

            <div class="d-flex align-items-center">
                <!-- Notifikasi -->
                <div class="dropdown me-3">
                    <button class="btn btn-dark position-relative dropdown-toggle" type="button" id="notifDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <?php if ($jmlNotif > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $jmlNotif ?>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        <?php endif; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="width: 320px;">
                        <li class="dropdown-header">Notifikasi Terbaru</li>
                        <?php if (mysqli_num_rows($resultNotif) > 0): ?>
                            <?php while ($notif = mysqli_fetch_assoc($resultNotif)): ?>
                                <li>
                                    <?php
                                    $tipe = $notif['tipe'];
                                    $id = $notif['id'];
                                    $redirect = $tipe === 'peminjaman'
                                        ? "../pengajuan/peminjaman_list.php?id=$id"
                                        : "../pengajuan/permintaan_list.php?id=$id";
                                    ?>
                                    <a class="dropdown-item"
                                        href="../layouts/baca_notifikasi.php?tipe=<?= $tipe ?>&id=<?= $id ?>&redirect=<?= urlencode($redirect) ?>">
                                        <?= $tipe === 'peminjaman' ? '📦 Peminjaman' : '📝 Permintaan' ?> ID #<?= $id ?> -
                                        Status: <?= ucfirst($notif['status']) ?>
                                        <br /><small
                                            class="text-muted"><?= date('d M Y H:i', strtotime($notif['created_at'])) ?></small>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><span class="dropdown-item-text">Tidak ada notifikasi baru</span></li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-primary text-center"
                                href="../layouts/baca_notifikasi.php?aksi=baca_semua">
                                Baca Semua
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Profile -->
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <span id="userRole">Admin</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="profile.php">Profil Saya</a></li>
                        <li><a class="dropdown-item" href="settings.php">Pengaturan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="../auth/logout.php"
                                onclick="return confirm('Yakin ingin logout?')">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>