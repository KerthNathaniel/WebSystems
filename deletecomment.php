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
    // Get Comment_ID and User_ID from session
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['User_ID'];

    // Delete comment from database
    $sql = "DELETE FROM comments WHERE Comment_ID = ? AND User_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $comment_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the report page after deletion
        header("Location: report.php?act_id=" . $_POST['act_id']);
        exit;
    } else {
        echo "Error deleting comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
