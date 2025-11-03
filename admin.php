<?php
session_start();
include 'includes/koneksi.php';

// Jika belum login, arahkan ke login
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

// Ambil data pendaftar
$result = $conn->query("SELECT * FROM pendaftar ORDER BY tanggal_daftar DESC");
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

  <table>
    <tr>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Email</th>
      <th>Telepon</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Surat</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['nama']) ?></td>
      <td><?= ucfirst(htmlspecialchars($row['kategori'])) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['telepon']) ?></td>
      <td><?= htmlspecialchars($row['tanggal_mulai']) ?> → <?= htmlspecialchars($row['tanggal_selesai']) ?></td>
      <td><?= htmlspecialchars($row['status'] ?? 'Menunggu') ?></td>
      <td><a href="download.php?id=<?= (int)$row['id'] ?>" target="_blank">📄 Lihat / Unduh</a></td>
      <td>
        <form action="update_status.php" method="post" style="display:inline;">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button name="status" value="Diterima" class="btn btn-acc">Terima</button>
          <button name="status" value="Ditolak" class="btn btn-rej">Tolak</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
