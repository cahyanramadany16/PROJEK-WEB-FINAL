<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Proses logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: logout.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Four Points by Sheraton Makassar</title>
  <link rel="stylesheet" href="style.css">

</head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<body>

<header>
  <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
  <h1>Welcome To Four Points by Sheraton Makassar</h1>
    <div class="user-greeting" style="font-size: 1.5em; margin-right: 15%; color: white;  padding-top: 50px;">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
  </div>
  <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard Admin</a></li>
                <li><a href="manage_admin.php">Manage Room</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </nav>
</header>
  
  <div id="Home" class="hero" style="background-image: url(resource/hotel.jpg) ;">
    <div class="hero-content">
      <h1>Four Points by Sheraton Makassar</h1>
      <p>Experience the best of Makassar at our hotel</p>
    </div>
  </div>
</body>
  </html>



  