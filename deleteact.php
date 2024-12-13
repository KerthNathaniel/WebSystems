<?php
// Connect to the database
include 'dbconn.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $activity_id = $_GET['id'];

    // Delete the activity from the database
    $sql = "DELETE FROM activities WHERE Act_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $activity_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the profile page after deletion
        header("Location: ngo-dashboard.php");
        exit();
    } else {
        echo "Error deleting activity: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
