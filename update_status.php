<?php
session_start();
include 'includes/koneksi.php';

// Hanya admin yang bisa melakukan perubahan status
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php?status=invalid");
    exit;
}

// Pastikan data dikirim lewat POST
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']); // biar aman dari SQL injection
    $status = $conn->real_escape_string($_POST['status']);
    $admin = $conn->real_escape_string($_SESSION['admin']);
    $updated_at = date('Y-m-d H:i:s');

    // Update status. Jika tabel punya kolom pencatat (status_updated_by / status_updated_at), update juga.
    $extra = '';
    $res = $conn->query("SHOW COLUMNS FROM pendaftar LIKE 'status_updated_by'");
    if ($res && $res->num_rows > 0) {
        $extra .= ", status_updated_by='{$admin}'";
    }
    $res2 = $conn->query("SHOW COLUMNS FROM pendaftar LIKE 'status_updated_at'");
    if ($res2 && $res2->num_rows > 0) {
        $extra .= ", status_updated_at='{$updated_at}'";
    }

    $sql = "UPDATE pendaftar SET status='{$status}' {$extra} WHERE id={$id}";
    $conn->query($sql);

    // Catat ke log file (logs/status_changes.log)
    $logDir = __DIR__ . '/logs';
    if (!is_dir($logDir)) mkdir($logDir, 0755, true);
    $logFile = $logDir . '/status_changes.log';
    $logLine = date('Y-m-d H:i:s') . " | id:{$id} | status:{$status} | by:{$admin}\n";
    @file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

    // Redirect dengan notifikasi status
    header("Location: admin.php?status=updated");
    exit;
} else {
    // Jika file diakses langsung tanpa form POST
    header("Location: admin.php?status=invalid");
    exit;
}
?>
