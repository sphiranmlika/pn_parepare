<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Sekarang - SIMAPARE</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="form.css" />
  <link rel="stylesheet" href="/css/footer.css" />
</head>
<body>

  <!-- Include Navbar -->
  <?php include 'navbar.php'; ?>

  <!-- FORM SECTION -->
  <section class="form-section">
    <div class="form-container">
      <h2>Daftar Sekarang</h2>

      <!-- === FORM UTAMA === -->
      <form id="daftarForm" action="proses_daftar.php" method="post" enctype="multipart/form-data">

        <!-- === KATEGORI === -->
        <h3 class="section-title">Kategori Pelamar</h3>
        <select name="kategori" id="kategori" required onchange="gantiKategori()">
          <option value="">Pilih Kategori</option>
          <option value="siswa">Siswa PKL</option>
          <option value="mahasiswa">Mahasiswa Magang</option>
        </select>

        <!-- === INFORMASI PRIBADI === -->
        <h3 class="section-title">Informasi Pribadi</h3>
        <div class="form-group full">
          <label>Nama Lengkap <span class="required">*</span></label>
          <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap Anda" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Alamat Email <span class="required">*</span></label>
            <input type="email" name="email" id="email" placeholder="Masukkan email Anda" required>
          </div>
          <div class="form-group">
            <label>Nomor Telepon <span class="required">*</span></label>
            <input type="text" name="telepon" id="telepon" placeholder="Masukkan No. Tlp Anda" required>
          </div>
        </div>

        <div class="form-group full">
          <label>Alamat <span class="required">*</span></label>
          <textarea name="alamat" id="alamat" placeholder="Alamat lengkap, kota, provinsi, kode pos" required></textarea>
        </div>

        <!-- === FORM SISWA === -->
        <div id="form-siswa" style="display: none;">
          <h3 class="section-title">Informasi Sekolah</h3>
          <div class="form-row">
            <div class="form-group">
              <label>Nama Sekolah <span class="required">*</span></label>
              <input type="text" name="sekolah" id="sekolah" placeholder="Nama Sekolah">
            </div>
            <div class="form-group">
              <label>NISN <span class="required">*</span></label>
              <input type="text" name="nisn" id="nisn" placeholder="Masukkan NISN">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Jurusan <span class="required">*</span></label>
              <input type="text" name="jurusan" id="jurusan" placeholder="Masukkan Jurusan">
            </div>
            <div class="form-group">
              <label>Kelas <span class="required">*</span></label>
              <select name="kelas" id="kelas">
                <option value="">Pilih Kelas</option>
                <option>X</option>
                <option>XI</option>
                <option>XII</option>
              </select>
            </div>
          </div>
        </div>

        <!-- === FORM MAHASISWA === -->
        <div id="form-mahasiswa" style="display: none;">
          <h3 class="section-title">Informasi Akademik</h3>
          <div class="form-row">
            <div class="form-group">
              <label>Nama Institusi <span class="required">*</span></label>
              <input type="text" name="institusi" id="institusi" placeholder="Nama Universitas/Perguruan Tinggi">
            </div>
            <div class="form-group">
              <label>NIM <span class="required">*</span></label>
              <input type="text" name="nim" id="nim" placeholder="Masukkan NIM">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Program Studi <span class="required">*</span></label>
              <input type="text" name="prodi" id="prodi" placeholder="Masukkan Program Studi">
            </div>
            <div class="form-group">
              <label>Semester <span class="required">*</span></label>
              <input type="text" name="semester" id="semester" placeholder="Semester Saat Ini">
            </div>
          </div>
        </div>

        <!-- === TANGGAL MAGANG === -->
        <div class="form-row">
          <div class="form-group">
            <label>Tanggal Mulai <span class="required">*</span></label>
            <input type="date" name="mulai" id="mulai" required>
          </div>
          <div class="form-group">
            <label>Tanggal Selesai <span class="required">*</span></label>
            <input type="date" name="selesai" id="selesai" required>
          </div>
        </div>

        <!-- === DOKUMEN === -->
        <h3 class="section-title">Dokumen Persyaratan</h3>
        <div class="form-row">
          <div class="form-group">
            <label>Pas Foto <span class="required">*</span></label>
            <input type="file" name="foto" id="foto" accept="image/*" required>
          </div>
          <div class="form-group">
            <label>Surat Rekomendasi <span class="required">*</span></label>
            <input type="file" name="surat" id="surat" accept=".pdf" required>
          </div>
        </div>

        <button type="submit" class="submit-btn">KIRIM</button>
      </form>
    </div>
  </section>

  <script>
    function gantiKategori() {
      const kategori = document.getElementById("kategori").value;
      document.getElementById("form-siswa").style.display = kategori === "siswa" ? "block" : "none";
      document.getElementById("form-mahasiswa").style.display = kategori === "mahasiswa" ? "block" : "none";
    }
  </script>

  <!-- Include Footer -->
  <?php include 'footer.php'; ?>

</body>
</html>