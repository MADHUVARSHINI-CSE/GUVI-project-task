<?php
// Inside register.php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "users" table exists
$tableExistsQuery = "SHOW TABLES LIKE 'users'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 0) {
    // The "users" table doesn't exist, so create it
    $createTableQuery = "CREATE TABLE users(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        age INT(3) NOT NULL,
        dob DATE NOT NULL   
    )";
     if($conn->query($createTableQuery) === TRUE) {
        echo "Table 'users' created successfully. ";
    } else {
        echo "Error creating table: " . $conn->error;
        exit(); // Exit the script if table creation fails
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $country = $_POST["country"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
   

    // Implement registration logic using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (username, password, country, email, phone, dob) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissss",$username, $password, $country, $email, $phone, $dob);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        // Handle database error
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
