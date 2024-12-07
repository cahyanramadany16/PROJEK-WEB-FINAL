<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_projek";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Debugging: memastikan koneksi berhasil
    echo "Connected successfully";
}

// Handle Add Room
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $room_type = $_POST['room_type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $benefits = $_POST['benefits'];
    $image = $_FILES['image'];

    // Debugging: Memeriksa data yang dikirimkan
    var_dump($_POST);
    var_dump($_FILES);

    // Validasi untuk image
    if ($image['error'] !== UPLOAD_ERR_OK) {
        die("Error uploading file: " . $image['error']);
    }

    // Memastikan folder resource ada
    $image_path = "resource/" . basename($image['name']);
    if (!move_uploaded_file($image['tmp_name'], $image_path)) {
        die("Error uploading file to destination.");
    }

    // Persiapkan query untuk menambahkan data
    $stmt = $conn->prepare("INSERT INTO room_types (room_type, category, price, benefits, image_path) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    // Bind parameters untuk query
    $stmt->bind_param("ssdss", $room_type, $category, $price, $benefits, $image_path);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Room added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete Room
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM room_types WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Edit Room
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_room'])) {
    $id = $_POST['id'];
    $room_type = $_POST['room_type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $benefits = $_POST['benefits'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image'];
        $image_path = "uploads/" . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $image_path);

        $stmt = $conn->prepare("UPDATE room_types SET room_type = ?, category = ?, price = ?, benefits = ?, image_path = ? WHERE id = ?");
        $stmt->bind_param("ssdssi", $room_type, $category, $price, $benefits, $image_path, $id);
    } else {
        $stmt = $conn->prepare("UPDATE room_types SET room_type = ?, category = ?, price = ?, benefits = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $room_type, $category, $price, $benefits, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch Room Data
$result = $conn->query("SELECT * FROM room_types");

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Error fetching data: " . $conn->error);
}

session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

?>
<!DOCTYPE html>
<html>
<head>
  <title>Four Points by Sheraton Makassar</title>
  <link rel="stylesheet" href="style.css">
<style>
        /* Form Container */
        #form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #form-container h3 {
            text-align: center;
            color: #29668f;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #4aa4e0;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #29668f;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
        }

        .room-image {
            width: 150px;
            height: auto;
        }

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #29668f;
            color: white;
            margin-top: 20px;
        }
</style>
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

    <main>
        <div id="form-container">
            <h3 id="formTitle">Add/Edit Room</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                
                <label for="room_type">Room Type:</label>
                <input type="text" id="room_type" name="room_type" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>

                <label for="benefits">Benefits:</label>
                <textarea id="benefits" name="benefits" required></textarea>

                <label for="image">Room Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit" name="add_room">Save</button>
            </form>
        </div>

        <h2>Room Types Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Benefits</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['room_type'] ?></td>
                        <td><?= $row['category'] ?></td>
                        <td>Rp. <?= number_format($row['price'], 2) ?></td>
                        <td><?= $row['benefits'] ?></td>
                        <td><img src="<?= $row['image_path'] ?>" alt="Room Image" class="room-image"></td>
                        <td>
                            <button onclick="editRoom(<?= htmlspecialchars(json_encode($row)) ?>)" style="background-color: #4caf50; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Edit</button>
                            <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this room?');">
                                <button style="background-color: red; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Four Points by Sheraton Makassar</p>
    </footer>

    <script>
        function editRoom(data) {
            document.getElementById('id').value = data.id;
            document.getElementById('room_type').value = data.room_type;
            document.getElementById('category').value = data.category;
            document.getElementById('price').value = data.price;
            document.getElementById('benefits').value = data.benefits;
            document.getElementById('formTitle').textContent = "Edit Room";
        }
    </script>
</body>
</html>
