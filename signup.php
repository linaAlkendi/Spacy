<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "spacy";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$spacyDB = "CREATE DATABASE IF NOT EXISTS spacy";
if ($conn->query($spacyDB) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error with database creation: " . $conn->error;
}

// Select the database
$conn->select_db($database);

// Create table
$spacyTable = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($spacyTable) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error with table creation: " . $conn->error;
}



// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Server-side validation for name (only letters)
    if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        echo "<script>alert('Name must contain only letters.'); window.location.href='signup.html';</script>";
        exit(); // Prevent further execution
    }
    
 

    // Hash the combined string
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
    // Check if the user already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email= ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, direct them to login
        echo "<script>alert('Already have an account.'); window.location.href='Login.html';</script>";
        exit();
    } else {
        // User does not exist, insert into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        if ($stmt->execute()) {
            echo "User registered successfully<br>"; // Add success message
            header("Location: planetPage.html");
            exit();
        } else {
            echo "Error with user registration: " . $conn->error;
        }
    }
}

$conn->close();
?>
