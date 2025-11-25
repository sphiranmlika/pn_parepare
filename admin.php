<?php
session_start();
include 'includes/koneksi.php';

// Jika belum login, arahkan ke login
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

// Ambil data pendaftar
$filter = isset($_GET['filter']) ? strtolower(trim($_GET['filter'])) : 'all';
$allowed = ['all','siswa','mahasiswa'];
if (!in_array($filter, $allowed)) $filter = 'all';

// Statistik umum
$totalQ = $conn->query("SELECT COUNT(*) AS c FROM pendaftar");
$total = (int)($totalQ->fetch_assoc()['c'] ?? 0);
$waitingQ = $conn->query("SELECT COUNT(*) AS c FROM pendaftar WHERE status IS NULL OR status = '' OR LOWER(status) = 'menunggu'");
$waiting = (int)($waitingQ->fetch_assoc()['c'] ?? 0);
$acceptedQ = $conn->query("SELECT COUNT(*) AS c FROM pendaftar WHERE LOWER(status) = 'diterima'");
$accepted = (int)($acceptedQ->fetch_assoc()['c'] ?? 0);
$rejectedQ = $conn->query("SELECT COUNT(*) AS c FROM pendaftar WHERE LOWER(status) = 'ditolak'");
$rejected = (int)($rejectedQ->fetch_assoc()['c'] ?? 0);

// Ambil data pendaftar sesuai filter
if ($filter === 'all') {
  $result = $conn->query("SELECT * FROM pendaftar ORDER BY kategori ASC, tanggal_daftar DESC");
} else {
  $f = $conn->real_escape_string($filter);
  $result = $conn->query("SELECT * FROM pendaftar WHERE kategori='{$f}' ORDER BY tanggal_daftar DESC");
}
$lastKategori = null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin SIMAPARE</title>
  <link rel="stylesheet" href="assets/form.css">
  <link rel="stylesheet" href="css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <header class="topbar">
      <div>
        <h1>SIMAPARE Admin</h1>
        <p class="subtitle">Kelola & Monitor Pendaftar Dengan Mudah</p>
      </div>
      <div class="top-actions">
        <a href="logout.php" class="btn ghost">Logout</a>
      </div>
    </header>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
      <div class="alert success">Status pendaftar berhasil diperbarui.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'invalid'): ?>
      <div class="alert error">Akses tidak valid.</div>
    <?php endif; ?>

    <section class="controls">
      <div class="filters">
    <?php $baseUrl = strtok($_SERVER["REQUEST_URI"], '?'); ?>
    <a href="<?= $baseUrl ?>?filter=all" class="filter-btn <?= $filter === 'all' ? 'active' : '' ?>">Semua</a>
    <a href="<?= $baseUrl ?>?filter=mahasiswa" class="filter-btn <?= $filter === 'mahasiswa' ? 'active' : '' ?>">Mahasiswa</a>
    <a href="<?= $baseUrl ?>?filter=siswa" class="filter-btn <?= $filter === 'siswa' ? 'active' : '' ?>">Siswa</a>
      </div>

      <div class="stats">
        <div class="stat-card"><div class="stat-title">Total</div><div class="stat-value"><?= $total ?></div></div>
        <div class="stat-card"><div class="stat-title">Menunggu</div><div class="stat-value highlight"><?= $waiting ?></div></div>
        <div class="stat-card"><div class="stat-title">Diterima</div><div class="stat-value ok"><?= $accepted ?></div></div>
        <div class="stat-card"><div class="stat-title">Ditolak</div><div class="stat-value bad"><?= $rejected ?></div></div>
      </div>
    </section>

    <section class="table-wrap">
      <div class="table-responsive">
        <table class="table styled">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Email</th>
              <th>Telepon</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Detail</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php if ($lastKategori !== $row['kategori']): ?>
              <tr class="category-row"><td colspan="8"><?= htmlspecialchars(ucfirst($row['kategori'])) ?></td></tr>
              <?php $lastKategori = $row['kategori']; endif; ?>
            <?php
              // prepare initials and searchable text
              $parts = preg_split('/\s+/', trim($row['nama']));
              $initials = '';
              if (!empty($parts)) {
                $initials .= strtoupper(substr($parts[0],0,1));
                if (isset($parts[1])) $initials .= strtoupper(substr($parts[1],0,1));
              }
              $searchable = htmlspecialchars(strtolower($row['nama'].' '.$row['email'].' '.$row['telepon'].' '.$row['kategori']));
            ?>
            <tr data-search="<?= $searchable ?>">
              <td data-label="Nama">
                <div class="cell-name">
                  <div class="avatar"><?= $initials ?></div>
                  <div class="name-block">
                    <div class="name"><?= htmlspecialchars($row['nama']) ?></div>
                    <div class="small muted"><?= htmlspecialchars($row['email']) ?></div>
                  </div>
                </div>
              </td>
              <td data-label="Kategori"><?= ucfirst(htmlspecialchars($row['kategori'])) ?></td>
              <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
              <td data-label="Telepon"><?= htmlspecialchars($row['telepon']) ?></td>
              <td data-label="Tanggal"><?= htmlspecialchars($row['tanggal_mulai']) ?> → <?= htmlspecialchars($row['tanggal_selesai']) ?></td>
              <td data-label="Status">
                <?php $s = strtolower(trim($row['status'] ?? ''));
                  if ($s === 'diterima'): ?>
                    <span class="badge ok">Diterima</span>
                  <?php elseif ($s === 'ditolak'): ?>
                    <span class="badge bad">Ditolak</span>
                  <?php else: ?>
                    <span class="badge pending">Menunggu</span>
                  <?php endif; ?>
              </td>
              <td data-label="Detail"><a href="detail.php?id=<?= (int)$row['id'] ?>" class="btn small">Lihat</a></td>
              <td data-label="Aksi">
                <?php if ($s === 'diterima' || $s === 'ditolak'): ?>
                  <span class="muted"><?= htmlspecialchars(ucfirst($row['status'])) ?></span>
                <?php else: ?>
                  <form action="update_status.php" method="post" class="action-form confirm-form">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button name="status" value="Diterima" class="btn success">✔</button>
                    <button name="status" value="Ditolak" class="btn danger">✖</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>
  <script>
    // Client-side search filter
    (function(){
      const input = document.getElementById('tableSearch');
      if (!input) return;
      const tbody = document.querySelector('.table.styled tbody');
      input.addEventListener('input', function(e){
        const q = e.target.value.trim().toLowerCase();
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(r => {
          // skip category rows
          if (r.classList.contains('category-row')) { r.style.display = ''; return; }
          const s = r.getAttribute('data-search') || r.textContent.toLowerCase();
          r.style.display = q === '' || s.indexOf(q) !== -1 ? '' : 'none';
        });
      });

      // confirm forms
      document.querySelectorAll('.confirm-form').forEach(form => {
        form.addEventListener('submit', function(ev){
          const btn = ev.submitter || form.querySelector('button');
          const status = btn ? btn.value : '';
          if (!confirm('Ubah status pendaftar menjadi "' + status + '"?')) ev.preventDefault();
        });
      });
    })();
  </script>
</body>
</html>
