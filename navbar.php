<nav class="navbar">
  <div class="logo">
    <a href="index.php" class="logo-link">
      <img src="images/logo.png" alt="Logo PN Parepare">
      <div class="logo-text">
        <h1>SIMAPARE</h1>
        <p>Pengadilan Negeri Parepare</p>
      </div>
    </a>
  </div>

  <ul class="nav-menu">
    <li><a href="form.php">Daftar Sekarang</a></li>
    <li><a href="informasi.php">Informasi Program</a></li>
    <li><a href="login.php">Login</a></li>
  </ul>

  <button class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

<script>
  function toggleMenu() {
    const menu = document.querySelector('.nav-menu');
    const hamburger = document.querySelector('.hamburger');
    menu.classList.toggle('active');
    hamburger.classList.toggle('active');
  }
</script>
