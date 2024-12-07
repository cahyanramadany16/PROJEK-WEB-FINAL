
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
    <link rel="stylesheet" href="css/styleForm.css">
    <script>
        // Function to show alert when reservation is submitted
        function showAlert() {
            alert("Your reservation has been successfully submitted!");
        }
    </script>d
</head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<body>
    <header>
        <h1>Welcome to Four Points by Sheraton Makassar</h1>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="user_dashboard.php#About">About</a></li> <!-- Tautan ke ID About -->
                <li><a href="user_dashboard.php#Contact">Contact</a></li> <!-- Tautan ke ID Contact -->
                <li><a href="tabelRoom.php">Room Types</a></li>
                <li><a href="#Reservation">Reservation</a></li>
                <li><a href="logout.php">logout</a></li>          
            </ul>
        </nav>
    </header>

    <div id="Reservation" class="section" style="background-image: url(resource/hotel.jpg);">
        <h2>Reservation Form</h2>
        <form action="/submit-reservation" method="POST" onsubmit="showAlert();">
            <div class="form-group">
                <label for="roomType">Room Type:</label>
                <select id="roomType" name="roomType" required>
                    <option value="">Select a room type</option>
                    <option value="single">Single Room</option>
                    <option value="double">Double Room</option>
                    <option value="suite">Suite</option>
                    <option value="family">Family Room</option>
                </select>
            </div>
            <div class="form-group">
                <label for="checkIn">Check-In Date:</label>
                <input type="date" id="checkIn" name="checkIn" required>
            </div>
            <div class="form-group">
                <label for="checkOut">Check-Out Date:</label>
                <input type="date" id="checkOut" name="checkOut" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact Information:</label>
                <input type="text" id="contact" name="contact" placeholder="Your contact info" required>
            </div>
            <button type="submit">Reserve Now</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2023 Four Points by Sheraton Makassar</p>
    </div>
</body>
</html>
