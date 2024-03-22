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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Implement login logic using prepared statements
    $stmt = $conn->prepare("SELECT password, id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $stmt->bind_result($hashedPassword, $userId);
        $stmt->fetch();
        
        if ($password == $hashedPassword) {
            // Store the user's ID in the session
            $_SESSION['user_id'] = $userId;
            echo 'success';
        } else {
            echo 'error: Invalid password';
        }
    } else {
        echo 'error: ' . $stmt->error . $hashedPassword ;  // Print SQL error
    }

    // Close the statement
    $stmt->close();
    $conn->close();
}

?>
