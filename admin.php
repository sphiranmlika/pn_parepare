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
  <title>Admin SIMAPARE</title>
  <link rel="stylesheet" href="assets/form.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background-color: #f8f9fa;
    }
    h2 { color: #333; }
    .alert {
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      width: 50%;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
      margin-top: 20px; 
      background-color: #fff;
    }
    th, td { 
      border: 1px solid #ddd; 
      padding: 10px; 
      text-align: center; 
    }
    th { 
      background-color: #4CAF50; 
      color: white; 
    }
    .btn { 
      padding: 5px 10px; 
      border: none; 
      border-radius: 5px; 
      cursor: pointer; 
    }
    .btn-acc { 
      background-color: #2e8b57; 
      color: white; 
    }
    .btn-rej { 
      background-color: #dc3545; 
      color: white; 
    }
    .logout {
      float: right;
      text-decoration: none;
      background-color: #f44336;
      color: white;
      padding: 8px 12px;
      border-radius: 5px;
    }
    .category-row td {
      background-color: #eef6ff;
      font-weight: 700;
      text-align: left;
      padding: 10px;
      border: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <h2>📋 Daftar Pendaftar SIMAPARE</h2>
  <a href="logout.php" class="logout">Logout</a>

  <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
    <div class="alert alert-success">✅ Status pendaftar berhasil diperbarui.</div>
  <?php elseif (isset($_GET['status']) && $_GET['status'] == 'invalid'): ?>
    <div class="alert alert-error">❌ Akses tidak valid.</div>
  <?php endif; ?>

  <style>
    .stats { display:flex; gap:12px; margin-top:10px; margin-bottom:12px }
    .stat { background:#fff; padding:10px 14px; border-radius:6px; box-shadow:0 1px 3px rgba(0,0,0,.06); }
    .filters { margin-top:8px; margin-bottom:8px }
    .filter-btn { display:inline-block; padding:6px 10px; border-radius:5px; text-decoration:none; background:#e9ecef; color:#333; margin-right:6px }
    .filter-btn.active { background:#4CAF50; color:#fff }
  </style>

  <div class="filters">
    <?php $baseUrl = strtok($_SERVER["REQUEST_URI"], '?'); ?>
    <a href="<?= $baseUrl ?>?filter=all" class="filter-btn <?= $filter === 'all' ? 'active' : '' ?>">Semua</a>
    <a href="<?= $baseUrl ?>?filter=mahasiswa" class="filter-btn <?= $filter === 'mahasiswa' ? 'active' : '' ?>">Mahasiswa</a>
    <a href="<?= $baseUrl ?>?filter=siswa" class="filter-btn <?= $filter === 'siswa' ? 'active' : '' ?>">Siswa</a>
  </div>

  <div class="stats">
    <div class="stat"><strong>Total:</strong> <?= $total ?></div>
    <div class="stat"><strong>Menunggu:</strong> <?= $waiting ?></div>
    <div class="stat"><strong>Diterima:</strong> <?= $accepted ?></div>
    <div class="stat"><strong>Ditolak:</strong> <?= $rejected ?></div>
  </div>

  <table>
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
    <?php while ($row = $result->fetch_assoc()): ?>
      <?php if ($lastKategori !== $row['kategori']): ?>
        <tr class="category-row"><td colspan="8"><?= htmlspecialchars(ucfirst($row['kategori'])) ?></td></tr>
        <?php $lastKategori = $row['kategori']; endif; ?>
    <tr>
      <td><?= htmlspecialchars($row['nama']) ?></td>
      <td><?= ucfirst(htmlspecialchars($row['kategori'])) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['telepon']) ?></td>
      <td><?= htmlspecialchars($row['tanggal_mulai']) ?> → <?= htmlspecialchars($row['tanggal_selesai']) ?></td>
      <td><?= htmlspecialchars($row['status'] ?? 'Menunggu') ?></td>
      <td><a href="detail.php?id=<?= (int)$row['id'] ?>" class="btn">Lihat</a></td>
      <td>
        <?php $s = strtolower(trim($row['status'] ?? ''));
          if ($s === 'diterima' || $s === 'ditolak'): ?>
            <span><?= htmlspecialchars(ucfirst($row['status'])) ?></span>
          <?php else: ?>
            <form action="update_status.php" method="post" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button name="status" value="Diterima" class="btn btn-acc">Terima</button>
              <button name="status" value="Ditolak" class="btn btn-rej">Tolak</button>
            </form>
          <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
