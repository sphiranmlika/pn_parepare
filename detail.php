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
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Pendaftar - <?= htmlspecialchars($row['nama']) ?></title>
  <link rel="stylesheet" href="assets/form.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--primary:#8E2C18;--secondary:#EE9636;--muted:#6b7280;--success:#16a34a;--danger:#dc2626;--text:#1f2937;--text-light:#6b7280;--bg-light:#f9fafb}
    *{box-sizing:border-box}
    body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,Arial;background:#fafaf8;color:var(--text);margin:0;padding:0;min-height:100vh}
    .header{background:linear-gradient(135deg,#8E2C18 0%,#C85A2A 50%,#EE9636 100%);color:#fff;padding:28px 24px;display:flex;align-items:center;justify-content:space-between;gap:20px;box-shadow:0 4px 16px rgba(142,44,24,0.15)}
    .header h1{margin:0;font-size:28px;font-weight:800;letter-spacing:-0.5px}
    .header-subtitle{color:rgba(255,255,255,0.9);font-size:13px;font-weight:500;margin:6px 0 0;letter-spacing:0.3px}
    .header-left{flex:1}
    .btn-back{display:inline-flex;align-items:center;gap:6px;padding:11px 22px;background:#fff;color:var(--primary);text-decoration:none;border:none;border-radius:8px;font-weight:700;cursor:pointer;transition:all .3s ease;font-size:13px;box-shadow:0 2px 8px rgba(0,0,0,0.1);letter-spacing:0.2px}
    .btn-back:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,0.12)}
    .container{max-width:1120px;margin:0 auto;padding:36px 24px}
    .section-title{font-size:13px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:1.2px;margin-bottom:20px;display:block}
    .card{background:#fff;border-radius:16px;padding:28px;margin-bottom:24px;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e5e7eb;transition:all .3s}
    .card:hover{box-shadow:0 8px 24px rgba(0,0,0,0.08);border-color:#EE9636}
    .info-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px;margin-top:16px}
    .info-item{background:linear-gradient(135deg,#fafaf8 0%,#f3f4f6 100%);padding:20px;border-radius:12px;border-left:4px solid var(--primary);transition:all .3s;cursor:default}
    .info-item:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(142,44,24,0.1)}
    .info-label{font-size:11px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:10px;opacity:0.9}
    .info-value{font-size:16px;font-weight:700;color:var(--text);word-break:break-word;line-height:1.5}
    .info-value a{color:var(--primary);text-decoration:none;font-weight:700;border-bottom:2px solid transparent;transition:all .2s}
    .info-value a:hover{border-bottom-color:var(--secondary)}
    .data-section{margin-bottom:24px}
    .data-section .section-title{margin-bottom:16px}
    .data-row{display:flex;gap:24px;padding-bottom:16px;border-bottom:1px solid #e5e7eb;align-items:flex-start}
    .data-row:last-child{border-bottom:none;padding-bottom:0}
    .data-label{width:130px;font-weight:800;color:var(--primary);font-size:12px;text-transform:uppercase;letter-spacing:0.5px;flex-shrink:0}
    .data-value{flex:1;color:var(--text);line-height:1.7;font-weight:500}
    .data-value strong{color:var(--text);font-weight:700}
    img.photo{width:100%;max-width:220px;height:auto;border-radius:12px;border:2px solid var(--secondary);box-shadow:0 6px 20px rgba(238,150,54,0.15);transition:all .3s}
    img.photo:hover{transform:scale(1.03);box-shadow:0 10px 28px rgba(238,150,54,0.25)}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:11px 18px;background:linear-gradient(135deg,var(--primary) 0%,#C85A2A 100%);color:#fff;text-decoration:none;border:none;border-radius:9px;font-weight:700;cursor:pointer;transition:all .3s;font-size:13px;box-shadow:0 3px 10px rgba(142,44,24,0.18)}
    .btn:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(142,44,24,0.3)}
    .btn-success{background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);box-shadow:0 3px 10px rgba(22,163,74,0.18)}
    .btn-success:hover{box-shadow:0 6px 16px rgba(22,163,74,0.3)}
    .btn-danger{background:linear-gradient(135deg,#dc2626 0%,#b91c1c 100%);box-shadow:0 3px 10px rgba(220,38,38,0.18)}
    .btn-danger:hover{box-shadow:0 6px 16px rgba(220,38,38,0.3)}
    .badge{display:inline-block;padding:9px 16px;border-radius:8px;font-size:12px;font-weight:800;letter-spacing:0.5px;text-transform:capitalize}
    .badge-pending{background:#fef3c7;color:#92400e}
    .badge-ok{background:#dcfce7;color:#166534}
    .badge-bad{background:#fee2e2;color:#991b1b}
    .status-box{background:linear-gradient(135deg,#fafaf8 0%,#f3f4f6 100%);padding:20px;border-radius:12px;border-left:4px solid var(--secondary);margin-bottom:18px}
    .status-label{font-size:11px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:12px}
    .action-group{display:flex;gap:10px;flex-wrap:wrap}
    .action-group form{flex:1;min-width:160px}
    .action-group .btn{width:100%;justify-content:center}
    .photo-box{background:linear-gradient(135deg,#fafaf8 0%,#f3f4f6 100%);padding:24px;border-radius:12px;text-align:center;margin-bottom:18px}
    .doc-item{background:linear-gradient(135deg,#fafaf8 0%,#f3f4f6 100%);padding:16px;border-radius:10px;border-left:3px solid var(--secondary);margin-bottom:12px;display:flex;align-items:center;gap:14px;transition:all .3s}
    .doc-item:hover{transform:translateX(3px);box-shadow:0 4px 12px rgba(238,150,54,0.15)}
    .doc-name{flex:1;font-weight:700;color:var(--text);font-size:14px}
    .doc-actions{display:flex;gap:6px}
    .empty-state{padding:20px;background:#f9fafb;border-radius:10px;text-align:center;color:var(--text-light);font-style:italic;font-size:14px}
    @media (max-width:768px){
      .header{padding:20px 16px;flex-direction:column;text-align:center;gap:12px}
      .header h1{font-size:24px}
      .header-subtitle{font-size:12px}
      .btn-back{padding:10px 18px;font-size:12px}
      .container{padding:24px 16px}
      .info-grid{grid-template-columns:1fr}
      .data-row{flex-direction:column;gap:8px}
      .data-label{width:100%;margin-bottom:4px}
      .action-group{flex-direction:column}
      .action-group form{width:100%}
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-left">
      <h1><?= htmlspecialchars($row['nama']) ?></h1>
      <p class="header-subtitle">Detail Pendaftar • <?= ucfirst(htmlspecialchars($row['kategori'])) ?></p>
    </div>
    <a href="admin.php" class="btn-back">← Kembali</a>
  </div>

  <div class="container">
    <div class="card">
      <span class="section-title">Informasi Dasar</span>
      <div class="info-grid">
        <div class="info-item">
          <div class="info-label">Nama Lengkap</div>
          <div class="info-value"><?= htmlspecialchars($row['nama']) ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Kategori</div>
          <div class="info-value"><strong><?= ucfirst(htmlspecialchars($row['kategori'])) ?></strong></div>
        </div>
      </div>
      <div class="info-grid">
        <div class="info-item">
          <div class="info-label">Email</div>
          <div class="info-value"><a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></div>
        </div>
        <div class="info-item">
          <div class="info-label">Telepon</div>
          <div class="info-value"><a href="tel:<?= htmlspecialchars($row['telepon']) ?>"><?= htmlspecialchars($row['telepon']) ?></a></div>
        </div>
      </div>
      <div class="info-grid">
        <div class="info-item" style="grid-column:1/-1">
          <div class="info-label">Alamat</div>
          <div class="info-value"><?= nl2br(htmlspecialchars($row['alamat'])) ?></div>
        </div>
      </div>
    </div>

    <div class="card">
      <span class="section-title">Informasi Akademik</span>
      <?php $kat = strtolower(trim($row['kategori'] ?? ''));
            if ($kat === 'siswa'): ?>
        <div class="data-section">
          <div class="data-row">
            <div class="data-label">Sekolah</div>
            <div class="data-value"><strong><?= htmlspecialchars($row['sekolah']) ?></strong></div>
          </div>
          <div class="data-row">
            <div class="data-label">NISN</div>
            <div class="data-value"><?= htmlspecialchars($row['nisn']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Jurusan</div>
            <div class="data-value"><?= htmlspecialchars($row['jurusan']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Kelas</div>
            <div class="data-value"><?= htmlspecialchars($row['kelas']) ?></div>
          </div>
        </div>
      <?php elseif ($kat === 'mahasiswa'): ?>
        <div class="data-section">
          <div class="data-row">
            <div class="data-label">Institusi</div>
            <div class="data-value"><strong><?= htmlspecialchars($row['institusi']) ?></strong></div>
          </div>
          <div class="data-row">
            <div class="data-label">NIM</div>
            <div class="data-value"><?= htmlspecialchars($row['nim']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Program Studi</div>
            <div class="data-value"><?= htmlspecialchars($row['prodi']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Semester</div>
            <div class="data-value"><?= htmlspecialchars($row['semester']) ?></div>
          </div>
        </div>
      <?php else: ?>
        <div class="data-section">
          <div class="data-row">
            <div class="data-label">Sekolah</div>
            <div class="data-value"><strong><?= htmlspecialchars($row['sekolah']) ?></strong></div>
          </div>
          <div class="data-row">
            <div class="data-label">NISN</div>
            <div class="data-value"><?= htmlspecialchars($row['nisn']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Jurusan</div>
            <div class="data-value"><?= htmlspecialchars($row['jurusan']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Kelas</div>
            <div class="data-value"><?= htmlspecialchars($row['kelas']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Institusi</div>
            <div class="data-value"><strong><?= htmlspecialchars($row['institusi']) ?></strong></div>
          </div>
          <div class="data-row">
            <div class="data-label">NIM</div>
            <div class="data-value"><?= htmlspecialchars($row['nim']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Program Studi</div>
            <div class="data-value"><?= htmlspecialchars($row['prodi']) ?></div>
          </div>
          <div class="data-row">
            <div class="data-label">Semester</div>
            <div class="data-value"><?= htmlspecialchars($row['semester']) ?></div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="card">
      <span class="section-title">Periode Magang & Dokumen</span>
      <div class="data-section">
        <div class="data-row">
          <div class="data-label">Periode</div>
          <div class="data-value">
            <strong><?= htmlspecialchars($row['tanggal_mulai']) ?></strong>
            <span style="margin:0 8px;color:var(--text-light)">→</span>
            <strong><?= htmlspecialchars($row['tanggal_selesai']) ?></strong>
          </div>
        </div>
      </div>

      <div style="margin-top:24px;">
        <span class="section-title" style="margin-bottom:14px">Foto Pendaftar</span>
        <?php if (!empty($row['foto']) && file_exists('uploads/'.$row['foto'])): ?>
          <div class="photo-box">
            <img class="photo" src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto <?= htmlspecialchars($row['nama']) ?>">
            <div style="margin-top:14px;">
              <a href="uploads/<?= htmlspecialchars($row['foto']) ?>" download="<?= htmlspecialchars($row['nama']) ?>_foto_<?= htmlspecialchars($row['id']) ?>" class="btn">Download Foto</a>
            </div>
          </div>
        <?php else: ?>
          <div class="empty-state">Tidak ada foto</div>
        <?php endif; ?>
      </div>

      <div style="margin-top:24px;">
        <span class="section-title" style="margin-bottom:14px">Dokumen Pendukung</span>
        <?php if (!empty($row['surat']) && file_exists('uploads/'.$row['surat'])): ?>
          <div class="doc-item">
            <div style="flex:1">
              <div class="doc-name">Surat Pendukung</div>
            </div>
            <div class="doc-actions">
              <a href="uploads/<?= htmlspecialchars($row['surat']) ?>" target="_blank" class="btn" style="padding:9px 12px;font-size:12px">Lihat</a>
              <a href="uploads/<?= htmlspecialchars($row['surat']) ?>" download="<?= htmlspecialchars($row['nama']) ?>_surat_<?= htmlspecialchars($row['id']) ?>" class="btn" style="padding:9px 12px;font-size:12px">Download</a>
            </div>
          </div>
        <?php else: ?>
          <div class="empty-state">Tidak ada dokumen</div>
        <?php endif; ?>
      </div>
    </div>

    <section class="section">
      <h3>✅ Status Pendaftar</h3>
      <div style="padding:20px;background:linear-gradient(135deg,#FFF8F3 0%,#FFF0E6 100%);border-radius:14px;border-left:4px solid #EE9636;margin-bottom:24px;">
        <div style="font-size:13px;font-weight:700;color:#8E2C18;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px">Status Saat Ini</div>
        <div>
          <?php $s = strtolower(trim($row['status'] ?? ''));
            if ($s === 'diterima'): ?>
              <span class="badge badge-ok">✓ Diterima</span>
            <?php elseif ($s === 'ditolak'): ?>
              <span class="badge badge-bad">✕ Ditolak</span>
            <?php else: ?>
              <span class="badge badge-pending">⏳ Menunggu Verifikasi</span>
            <?php endif; ?>
        </div>
      </div>

      <div style="padding:20px;background:#f9fafb;border-radius:14px;border:1px solid #e5e7eb;">
        <div style="font-size:13px;font-weight:700;color:#8E2C18;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px">Aksi Admin</div>
        <?php
          if ($s === 'diterima' || $s === 'ditolak'): ?>
            <div style="padding:16px;background:linear-gradient(135deg,#F3F4F6 0%,#E5E7EB 100%);border-radius:10px;text-align:center;color:#6b7280;font-weight:600">
              ✓ Status sudah final, tidak dapat diubah
            </div>
          <?php else: ?>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
              <form action="update_status.php" method="post" style="flex:1; min-width:160px">
                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                <button name="status" value="Diterima" class="btn btn-success" style="width:100%;justify-content:center" onclick="return confirm('Yakin TERIMA pendaftar ini?')">✓ Terima Pendaftar</button>
              </form>
              <form action="update_status.php" method="post" style="flex:1; min-width:160px">
                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                <button name="status" value="Ditolak" class="btn btn-danger" style="width:100%;justify-content:center" onclick="return confirm('Yakin TOLAK pendaftar ini?')">✕ Tolak Pendaftar</button>
              </form>
            </div>
        <?php endif; ?>
      </div>
    </section>
    </div>
  </div>
</body>
</html>
