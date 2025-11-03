<?php
include 'includes/koneksi.php';

// Pastikan data dikirim lewat POST
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']); // biar aman dari SQL injection
    $status = $conn->real_escape_string($_POST['status']);

    $conn->query("UPDATE pendaftar SET status='$status' WHERE id=$id");

    // Redirect dengan notifikasi status
    header("Location: admin.php?status=updated");
    exit;
} else {
    // Jika file diakses langsung tanpa form POST
    header("Location: admin.php?status=invalid");
    exit;
}
?>
