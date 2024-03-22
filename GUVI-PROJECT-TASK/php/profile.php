<?php

session_start();

// Replace the connection URL with your own MongoDB connection string
$connectionString = "mongodb://localhost:27017";

try {
    // Create a new MongoDB client
    $mongoClient = new MongoDB\Client($connectionString);

    // Specify the database and collection
    $databaseName = "guvi";
    $collectionName = "users";

    // Select the database and collection
    $database = $mongoClient->$databaseName;
    $collection = $database->$collectionName;

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $address = $_POST["address"];
        $state = $_POST["state"];
        $country = $_POST["country"];
        $aadharNumber = $_POST["aadharNumber"];

        $result = $collection->updateOne(
            ["_id" => new MongoDB\BSON\ObjectID($userId)],
            [
                '$set' => [
                    "address" => $address,
                    "state" => $state,
                    "country" => $country,
                    "aadharNumber" => $aadharNumber,
                ]
            ]
        );

        if ($result->getModifiedCount() > 0) {
            echo 'success';
        } else {
            echo 'error: Failed to update profile.';
        }
    }

} catch (MongoDB\Driver\Exception\Exception $e) {
    // Handle connection errors
    echo "Error connecting to MongoDB: " . $e->getMessage();
}

?>
