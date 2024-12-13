<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['User_ID'])) {
    echo "Error: User not logged in.";
    exit;
}

// Database connection details
$hostname = "localhost";
$username = "root";
$password = "";
$database = "webdev";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get User_ID from session
    $user_id = $_SESSION['User_ID'];
    $act_id = $_POST['act_id'];
    $comment_text = $_POST['comment_text'];

    // Insert comment into database
    $sql = "INSERT INTO comments (User_ID, Act_ID, Comment_Text) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $act_id, $comment_text);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the activity page or any other relevant page
        header("Location: report.php?act_id=" . $act_id);
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
