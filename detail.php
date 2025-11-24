<?php
session_start();
include 'includes/koneksi.php';

// Hanya admin yang boleh melihat
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  echo "<p>Id tidak valid. <a href=\"admin.php\">Kembali</a></p>";
  exit;
}

$stmt = $conn->prepare("SELECT * FROM pendaftar WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
if (!$row) {
  echo "<p>Data tidak ditemukan. <a href=\"admin.php\">Kembali</a></p>";
  exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Detail Pendaftar - <?= htmlspecialchars($row['nama']) ?></title>
  <link rel="stylesheet" href="assets/form.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background:#f8f9fa; }
    .card { background:#fff; padding:20px; border-radius:6px; box-shadow:0 1px 4px rgba(0,0,0,.08); max-width:900px }
    .row { display:flex; gap:12px; margin-bottom:8px }
    .label { width:180px; font-weight:700 }
    img.photo { max-width:150px; border-radius:4px; }
    a.button { display:inline-block; padding:8px 12px; background:#4CAF50; color:#fff; border-radius:5px; text-decoration:none }
  </style>
</head>
<body>
  <h2>Detail Pendaftar</h2>
  <a href="admin.php" class="button">← Kembali ke Daftar</a>
  <div class="card" style="margin-top:12px">
    <div class="row"><div class="label">Nama</div><div><?= htmlspecialchars($row['nama']) ?></div></div>
    <div class="row"><div class="label">Kategori</div><div><?= htmlspecialchars($row['kategori']) ?></div></div>
    <div class="row"><div class="label">Email</div><div><?= htmlspecialchars($row['email']) ?></div></div>
    <div class="row"><div class="label">Telepon</div><div><?= htmlspecialchars($row['telepon']) ?></div></div>
    <div class="row"><div class="label">Alamat</div><div><?= nl2br(htmlspecialchars($row['alamat'])) ?></div></div>

    <div style="margin-top:10px; border-top:1px solid #eee; padding-top:10px">
      <?php $kat = strtolower(trim($row['kategori'] ?? ''));
            if ($kat === 'siswa'): ?>
        <h3>Informasi Sekolah</h3>
        <div class="row"><div class="label">Sekolah</div><div><?= htmlspecialchars($row['sekolah']) ?></div></div>
        <div class="row"><div class="label">NISN</div><div><?= htmlspecialchars($row['nisn']) ?></div></div>
        <div class="row"><div class="label">Jurusan</div><div><?= htmlspecialchars($row['jurusan']) ?></div></div>
        <div class="row"><div class="label">Kelas</div><div><?= htmlspecialchars($row['kelas']) ?></div></div>
      <?php elseif ($kat === 'mahasiswa'): ?>
        <h3>Informasi Akademik</h3>
        <div class="row"><div class="label">Institusi</div><div><?= htmlspecialchars($row['institusi']) ?></div></div>
        <div class="row"><div class="label">NIM</div><div><?= htmlspecialchars($row['nim']) ?></div></div>
        <div class="row"><div class="label">Program Studi</div><div><?= htmlspecialchars($row['prodi']) ?></div></div>
        <div class="row"><div class="label">Semester</div><div><?= htmlspecialchars($row['semester']) ?></div></div>
      <?php else: ?>
        <h3>Informasi Sekolah / Institusi</h3>
        <div class="row"><div class="label">Sekolah</div><div><?= htmlspecialchars($row['sekolah']) ?></div></div>
        <div class="row"><div class="label">NISN</div><div><?= htmlspecialchars($row['nisn']) ?></div></div>
        <div class="row"><div class="label">Jurusan</div><div><?= htmlspecialchars($row['jurusan']) ?></div></div>
        <div class="row"><div class="label">Kelas</div><div><?= htmlspecialchars($row['kelas']) ?></div></div>

        <div class="row"><div class="label">Institusi</div><div><?= htmlspecialchars($row['institusi']) ?></div></div>
        <div class="row"><div class="label">NIM</div><div><?= htmlspecialchars($row['nim']) ?></div></div>
        <div class="row"><div class="label">Program Studi</div><div><?= htmlspecialchars($row['prodi']) ?></div></div>
        <div class="row"><div class="label">Semester</div><div><?= htmlspecialchars($row['semester']) ?></div></div>
      <?php endif; ?>
    </div>

    <div style="margin-top:10px; border-top:1px solid #eee; padding-top:10px">
      <h3>Periode Magang & Dokumen</h3>
      <div class="row"><div class="label">Tanggal</div><div><?= htmlspecialchars($row['tanggal_mulai']) ?> → <?= htmlspecialchars($row['tanggal_selesai']) ?></div></div>
      <div class="row"><div class="label">Foto</div><div>
        <?php if (!empty($row['foto']) && file_exists('uploads/'.$row['foto'])): ?>
          <a href="uploads/<?= htmlspecialchars($row['foto']) ?>" download="<?= htmlspecialchars($row['nama']) ?>_foto_<?= htmlspecialchars($row['id']) ?>">
            <img class="photo" src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto <?= htmlspecialchars($row['nama']) ?>">
          </a>
          <div style="margin-top:6px">
            <a href="uploads/<?= htmlspecialchars($row['foto']) ?>" download="<?= htmlspecialchars($row['nama']) ?>_foto_<?= htmlspecialchars($row['id']) ?>">⬇️ Unduh Foto</a>
          </div>
        <?php else: ?>
          (Tidak ada foto)
        <?php endif; ?>
      </div></div>
      <div class="row"><div class="label">Surat</div><div>
        <?php if (!empty($row['surat']) && file_exists('uploads/'.$row['surat'])): ?>
          <a href="uploads/<?= htmlspecialchars($row['surat']) ?>" target="_blank">📄 Buka Surat</a>
          <span style="margin-left:8px">|</span>
          <a href="uploads/<?= htmlspecialchars($row['surat']) ?>" download="<?= htmlspecialchars($row['nama']) ?>_surat_<?= htmlspecialchars($row['id']) ?>">⬇️ Unduh Surat</a>
        <?php else: ?>
          (Tidak ada surat)
        <?php endif; ?>
      </div></div>
    </div>

    <div style="margin-top:12px; border-top:1px solid #eee; padding-top:10px">
      <h3>Status</h3>
      <div class="row"><div class="label">Status saat ini</div><div><?= htmlspecialchars($row['status'] ?? 'Menunggu') ?></div></div>
      <div class="row"><div class="label">Aksi</div><div>
        <?php $s = strtolower(trim($row['status'] ?? ''));
          if ($s === 'diterima' || $s === 'ditolak'): ?>
            <strong>Status final: <?= htmlspecialchars(ucfirst($row['status'])) ?></strong>
          <?php else: ?>
            <form action="update_status.php" method="post" style="display:inline-block; margin-right:6px;">
              <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
              <button name="status" value="Diterima" class="btn btn-acc">Terima</button>
            </form>
            <form action="update_status.php" method="post" style="display:inline-block;">
              <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
              <button name="status" value="Ditolak" class="btn btn-rej">Tolak</button>
            </form>
        <?php endif; ?>
      </div></div>
    </div>
  </div>
</body>
</html>
