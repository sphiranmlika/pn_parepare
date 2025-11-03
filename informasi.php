<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Informasi Program Magang - SIMAPARE</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/css/navbar.css" />
  <link rel="stylesheet" href="informasi.css" />
  <link rel="stylesheet" href="/css/footer.css" />
</head>
<body>
  
  <!-- Include Navbar -->
  <?php include 'navbar.php'; ?>

  <main>
    <!-- Section Program -->
    <section class="section light">
      <div class="container">
        <h2 class="section-head">Jenis Program Magang</h2>
        <p class="section-desc">SIMAPARE menyediakan berbagai jenis program magang yang dirancang untuk memberikan pengalaman belajar dan praktik nyata di lingkungan Pengadilan Negeri Parepare.</p>
        <div class="program-types">
          <div class="program-card">
            <h3>Magang Akademik</h3>
            <p>Diperuntukkan bagi mahasiswa yang sedang menempuh pendidikan formal dan ingin mempelajari sistem administrasi peradilan secara langsung.</p>
          </div>
          <div class="program-card">
            <h3>Magang Profesi</h3>
            <p>Memberikan kesempatan bagi peserta untuk mengembangkan kemampuan profesional dan memahami etika kerja di dunia peradilan.</p>
          </div>
          <div class="program-card">
            <h3>Magang Riset</h3>
            <p>Diperuntukkan bagi peneliti atau mahasiswa yang sedang melakukan penelitian di bidang hukum, administrasi, dan sistem peradilan.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Section Alur -->
    <section class="section">
      <div class="container">
        <h2 class="section-head">Alur Pendaftaran Magang</h2>
        <ol class="alur-list">
          <li>Mengisi formulir pendaftaran online melalui SIMAPARE.</li>
          <li>Mengunggah dokumen yang diperlukan seperti surat pengantar dan identitas diri.</li>
          <li>Menunggu proses verifikasi dari pihak Pengadilan Negeri Parepare.</li>
          <li>Menerima surat penerimaan magang jika dinyatakan lolos.</li>
          <li>Memulai kegiatan magang sesuai jadwal yang ditentukan.</li>
        </ol>
      </div>
    </section>

    <!-- Section Syarat -->
    <section class="section light">
      <div class="container">
        <h2 class="section-head">Syarat Pendaftaran</h2>
        <ul class="syarat-list">
          <li>Mahasiswa aktif atau siswa SMK sederajat.</li>
          <li>Surat pengantar resmi dari institusi pendidikan.</li>
          <li>Pas foto berwarna ukuran 3x4.</li>
          <li>CV singkat dan motivasi mengikuti magang.</li>
          <li>Bersedia mematuhi tata tertib yang berlaku di Pengadilan Negeri Parepare.</li>
        </ul>
      </div>
    </section>

    <!-- Section Hak & Kewajiban -->
    <section class="section">
      <div class="container">
        <h2 class="section-head">Hak dan Kewajiban Peserta Magang</h2>
        <div class="hak-grid">
          <div>
            <h3>Hak Peserta</h3>
            <ul>
              <li>Mendapatkan bimbingan dari pegawai pengadilan.</li>
              <li>Mengakses fasilitas yang relevan untuk kegiatan magang.</li>
              <li>Mendapatkan sertifikat setelah menyelesaikan program.</li>
            </ul>
          </div>
          <div>
            <h3>Kewajiban Peserta</h3>
            <ul>
              <li>Menjaga disiplin dan etika selama kegiatan magang.</li>
              <li>Mengikuti seluruh kegiatan yang telah dijadwalkan.</li>
              <li>Menjaga kerahasiaan dokumen dan data instansi.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Include Footer -->
  <?php include 'footer.php'; ?>

  <script>
    function toggleMenu() {
      document.querySelector('.nav-menu').classList.toggle('active');
    }
  </script>

</body>
</html>