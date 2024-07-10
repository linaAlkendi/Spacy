<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spacy";


// Process form data  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $year = intval($_POST['year']);

    if (!$year) {
        echo "Invalid year provided.";
        exit;
    }

    $stmt = $conn->prepare("SELECT EventName, EventDescription FROM Events WHERE year = ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Event Name</th><th>Description</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["EventName"]."</td><td>".$row["EventDescription"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No events found for this year.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "No POST request received.";
}
?>
