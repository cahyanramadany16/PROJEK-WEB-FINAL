<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_projek";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Room Data
$result = $conn->query("SELECT * FROM room_types");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="css/styleTable.css">
</head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<body>
    <header>
        <h1>Welcome to Four Points by Sheraton Makassar</h1>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="user_dashboard.phpl#About">About</a></li> <!-- Tautan ke ID About -->
                <li><a href="user_dashboard.php#Contact">Contact</a></li> <!-- Tautan ke ID Contact -->
                <li><a href="#RoomTypes">Room Types</a></li>
                <li><a href="reservationForm.php">Reservation</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="RoomTypes">
          <h2>Room Types and Rates</h2>
          <table>
            <thead>
              <tr>
                <th>Room Type</th>
                <th>Category</th>
                <th>Price (per night)</th>
                <th>Benefits</th>
                <th>Image</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $row['room_type'] ?></td>
                  <td><?= $row['category'] ?></td>
                  <td>Rp. <?= number_format($row['price'], 2) ?></td>
                  <td><?= $row['benefits'] ?></td>
                  <td>
                    <img src="<?= $row['image_path'] ?>" alt="Room Image" class="room-image">
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </section>
      </main>
    
    <div class="footer">
        <p>&copy; 2023 Four Points by Sheraton Makassar</p>
    </div>
</body>
</html>