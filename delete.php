<?php
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "spacy";

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $email = $_POST["email"];
    
   
            $delete_stmt = $conn->prepare("DELETE FROM users WHERE email= ?");
            if (!$delete_stmt) {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                exit();
            }
            $delete_stmt->bind_param("s", $email);
            $delete_stmt->execute();
            
            if ($delete_stmt->affected_rows > 0) {
                echo "<script>alert('Account deleted successfully.'); window.location.href='signup.html';</script>";
            } else {
                echo "<script>alert('Failed to delete account.'); window.location.href='Login.html';</script>";
            }
            
            exit();
        
    } else {
        // User does not exist
        echo "<script>alert('User not found!'); window.location.href='signup.html';</script>";
        exit();
    }

?>
