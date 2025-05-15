<?php

include __DIR__ . '/../auth/cek_login.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';

?>

  

  <!-- Main Content -->
  <main class="content">
    <div class="container">
      <div id="main-content">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title">Selamat datang, <?= $_SESSION['username']; ?> (<?= ucfirst($_SESSION['role']); ?>)</h1>
            <p class="card-text">Ini adalah halaman dashboard utama.</p>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>  
