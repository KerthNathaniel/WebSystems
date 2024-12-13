<?php
session_start();

// Check if User_ID is set in the session
if (isset($_SESSION['User_ID']) && isset($_POST['act_id']) && isset($_POST['user_role'])) {
    $user_id = $_SESSION['User_ID'];
    $activity_id = $_POST['act_id'];
    $user_role = $_POST['user_role'];

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

    // Insert user activity into database
    $sql = "INSERT INTO user_activities (User_ID, Act_ID, Participation_Date) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $activity_id);
    mysqli_stmt_execute($stmt);

    // Check if the insertion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Redirect to activities page
        header("Location: activities.php");
        exit();
    } else {
        echo "Error joining activity.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "User not logged in or invalid activity ID.";
}
?>
