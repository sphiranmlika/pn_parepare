<?php
session_start();
include 'includes/koneksi.php';

// => 1) Pastikan yang mengakses adalah admin
if (!isset($_SESSION['admin'])) {
  http_response_code(403);
  echo "Akses ditolak.";
  exit;
}

// => 2) Ambil id dan validasi
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  http_response_code(400);
  echo "Permintaan tidak valid.";
  exit;
}

$id = (int)$_GET['id'];

// => 3) Ambil info file dari DB
$stmt = $conn->prepare("SELECT surat FROM pendaftar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
  http_response_code(404);
  echo "File tidak ditemukan.";
  exit;
}

$row = $res->fetch_assoc();
$stored = $row['surat']; // nama file disimpan di kolom surat
$original = $stored;     // karena belum pakai nama asli terpisah
$fileType = mime_content_type('uploads/' . $stored);

// => 4) Path file di server (pastikan path ini benar)
$baseDir = __DIR__ . '/uploads/surat/'; // atau path di luar webroot jika ada
$filePath = $baseDir . $stored;

if (!file_exists($filePath)) {
  http_response_code(404);
  echo "File tidak ditemukan di server.";
  exit;
}

// => 5) Logging akses (opsional)
// file_put_contents('logs/downloads.log', date('c')." - admin=".$_SESSION['admin']." - file=".$stored.PHP_EOL, FILE_APPEND);

// => 6) Kirim header yang sesuai dan tampilkan inline untuk PDF/gambar, atau paksa download
$ext = strtolower(pathinfo($stored, PATHINFO_EXTENSION));
$inline_types = ['pdf','jpg','jpeg','png','gif','txt'];

if (in_array($ext, $inline_types)) {
  header('Content-Type: ' . $fileType);
  header('Content-Disposition: inline; filename="' . basename($original) . '"');
} else {
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . basename($original) . '"');
}

header('Content-Length: ' . filesize($filePath));
header('Cache-Control: private');
readfile($filePath);
exit;
