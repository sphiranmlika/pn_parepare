<?php
// === KONEKSI DATABASE ===
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_pnparepare"; // ubah sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// === AMBIL DATA DARI FORM ===
$kategori = $_POST['kategori'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];

$sekolah = $_POST['sekolah'] ?? null;
$nisn = $_POST['nisn'] ?? null;
$jurusan = $_POST['jurusan'] ?? null;
$kelas = $_POST['kelas'] ?? null;

$institusi = $_POST['institusi'] ?? null;
$nim = $_POST['nim'] ?? null;
$prodi = $_POST['prodi'] ?? null;
$semester = $_POST['semester'] ?? null;

$mulai = $_POST['mulai'];
$selesai = $_POST['selesai'];

// === VALIDASI TANGGAL ===
if (strtotime($selesai) <= strtotime($mulai)) {
  echo "<script>alert('Tanggal selesai harus setelah tanggal mulai!'); history.back();</script>";
  exit;
}

// === UPLOAD FOTO ===
$target_dir = "uploads/";
if (!is_dir($target_dir)) mkdir($target_dir);

$foto_nama = uniqid() . "_" . basename($_FILES["foto"]["name"]);
$foto_path = $target_dir . $foto_nama;
$surat_nama = uniqid() . "_" . basename($_FILES["surat"]["name"]);
$surat_path = $target_dir . $surat_nama;

// Validasi tipe file
$allowed_foto = ['jpg', 'jpeg', 'png'];
$allowed_surat = ['pdf'];

$foto_ext = strtolower(pathinfo($foto_path, PATHINFO_EXTENSION));
$surat_ext = strtolower(pathinfo($surat_path, PATHINFO_EXTENSION));

if (!in_array($foto_ext, $allowed_foto)) {
  echo "<script>alert('Format foto harus JPG, JPEG, atau PNG!'); history.back();</script>";
  exit;
}
if (!in_array($surat_ext, $allowed_surat)) {
  echo "<script>alert('Format surat harus PDF!'); history.back();</script>";
  exit;
}

// Upload file
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto_path) &&
    move_uploaded_file($_FILES["surat"]["tmp_name"], $surat_path)) {

  // === SIMPAN KE DATABASE ===
  $sql = "INSERT INTO pendaftar 
          (kategori, nama, email, telepon, alamat, sekolah, nisn, jurusan, kelas, institusi, nim, prodi, semester, tanggal_mulai, tanggal_selesai, foto, surat)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssssssssssssss", 
    $kategori, $nama, $email, $telepon, $alamat,
    $sekolah, $nisn, $jurusan, $kelas,
    $institusi, $nim, $prodi, $semester,
    $mulai, $selesai, $foto_nama, $surat_nama
  );

  if ($stmt->execute()) {
    echo "<script>alert('Pendaftaran berhasil dikirim!'); window.location='index.html';</script>";
  } else {
    echo "<script>alert('Gagal menyimpan ke database!'); history.back();</script>";
  }

  $stmt->close();
} else {
  echo "<script>alert('Gagal mengunggah file!'); history.back();</script>";
}

$conn->close();
?>
