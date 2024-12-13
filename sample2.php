<?php
session_start();


$servername = "localhost";
$username = "root"; 
$password = "";      
$dbname = "webdev"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login (simulate login for this example)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Email_addr']) && isset($_POST['password'])) {
    $email = $_POST['Email_addr'];
    $password = $_POST['password']; 

    // Insert email and password into the database
    $stmt = $conn->prepare("INSERT INTO users (Email_addr, Password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $_SESSION['Email_addr'] = $email;  // Save the email in the session after successful login
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
  }
// Handle logout
if (isset($_POST['logout'])) {
    session_unset();  //unset all variables
    session_destroy();  // Destroy the session
    header("Location: sample.php");  // Redirect to home after logout
    exit();
}

$conn->close();  
?>