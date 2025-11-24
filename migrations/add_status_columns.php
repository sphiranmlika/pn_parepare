<?php
/**
 * Migration script: add_status_columns.php
 * Run once from CLI or browser to add two columns to `pendaftar`:
 * - status_updated_by VARCHAR(100) NULL
 * - status_updated_at DATETIME NULL
 *
 * Usage (CLI):
 * php migrations/add_status_columns.php
 */

include __DIR__ . '/../includes/koneksi.php';

$cols = [];
$res = $conn->query("SHOW COLUMNS FROM pendaftar LIKE 'status_updated_by'");
if (!($res && $res->num_rows > 0)) $cols[] = "ADD COLUMN status_updated_by VARCHAR(100) NULL";
$res = $conn->query("SHOW COLUMNS FROM pendaftar LIKE 'status_updated_at'");
if (!($res && $res->num_rows > 0)) $cols[] = "ADD COLUMN status_updated_at DATETIME NULL";

if (empty($cols)) {
    echo "Kolom sudah ada, tidak ada perubahan.\n";
    exit;
}

$sql = "ALTER TABLE pendaftar " . implode(', ', $cols);
if ($conn->query($sql) === TRUE) {
    echo "Berhasil menambahkan kolom: " . implode(', ', $cols) . "\n";
} else {
    echo "Gagal: " . $conn->error . "\n";
}

$conn->close();
