<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create feedback table if not exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS feedback (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gender VARCHAR(10) NOT NULL,
    rating VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    message TEXT NOT NULL
)";

if ($conn->query($sql_create_table) === FALSE) {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $gender = $_POST["gender"];
    $rating = $_POST["rating"];
    $email = $_POST["email"];
    $message = $_POST["textarea"];

    // Perform field validations
    // Example: Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Check if message length is between 5 and 200 characters
    $messageLength = strlen($message);
    if ($messageLength < 5 || $messageLength > 200) {
        echo "<script>alert('Message must be between 5 and 200 characters'); window.location.href='feedback.html';</script>";
        exit;
    }

    // Check if similar feedback already exists
    $sql_check_feedback = "SELECT * FROM feedback WHERE email = '$email' AND message = '$message'";
    $result = $conn->query($sql_check_feedback);
    if ($result->num_rows > 0) {
        echo "<script>alert('You have already submitted similar feedback. Thank you for your contribution!'); window.location.href='feedback.html';</script>";
        exit;
    }

    // Insert data into the database
    $sql_insert_feedback = "INSERT INTO feedback (gender, rating, email, message) VALUES ('$gender', '$rating', '$email', '$message')";
    if ($conn->query($sql_insert_feedback) === TRUE) {
        echo "<script>alert('Feedback submitted successfully. We appreciate your feedback!'); window.location.href='feedback.html';</script>";
    } else {
        echo "<script>alert('Error occurred, please try again'); window.location.href='feedback.html';</script>";
    }
}

$conn->close();
?>

