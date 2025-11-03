<?php
session_start();
include 'includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validasi dari tabel admin
  $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
  $result = $conn->query($query);

  if ($result && $result->num_rows > 0) {
    $_SESSION['admin'] = $username;
    header("Location: admin.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SIMAPARE</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-left">
      <div class="overlay"></div>
      <img src="/images/background.png" alt="Gambar Login">
      <div class="info-box">
        <div class="token">
          <h4>SIMAPARE</h4>
          <p>Sistem Informasi Magang Pengadilan Negeri Parepare</p>
        </div>
      </div>
    </div>

    <div class="login-right">
      <div class="form-box">
        <h2>Selamat Datang di <span>SIMAPARE</span></h2>

        <?php if (isset($error)): ?>
          <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required placeholder="Masukkan Username">

          <label for="password">Password</label>
          <input type="password" id="password" name="password" required placeholder="Masukkan Password">

          <button type="submit" class="btn-login">Login</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
