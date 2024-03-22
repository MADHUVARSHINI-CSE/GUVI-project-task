<?php
session_start(); // Start the session

// Include your database connection code here
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

// Define the columns to be added
$columnsToAdd = [
    "address VARCHAR(255)",
    "state VARCHAR(255)",
    "country VARCHAR(255)",
    "aadharNumber VARCHAR(255)"
];

// Check and create columns if they don't exist
foreach ($columnsToAdd as $column) {
    $result = $conn->query("SHOW COLUMNS FROM users LIKE '$column'");

    if ($result->num_rows == 0) {
        // Column doesn't exist, create it
        $conn->query("ALTER TABLE users ADD $column");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from the session
    $userId = $_SESSION['user_id'];

    // Get new profile information from the POST data
    $address = $_POST["address"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $aadharNumber = $_POST["aadharNumber"];

    // Update user profile using prepared statement
    $stmt = $conn->prepare("UPDATE users SET address = ?, state = ?, country = ?, aadharNumber = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $address, $state, $country, $aadharNumber, $userId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: Failed to update profile.';
    }

    // Close the statement
    $stmt->close();
    $conn->close();
}
?>
