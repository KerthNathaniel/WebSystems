<?php
// Start the session at the very beginning of the script
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

// Get activity ID from URL
if (isset($_GET['id'])) {
    $act_id = $_GET['id'];

    // Fetch activity details
    $sql = "SELECT Act_name, Description FROM activities WHERE Act_ID = ? AND User_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $act_id, $_SESSION['User_ID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $act_name = $row['Act_name'];
        $description = $row['Description'];
    } else {
        echo "Error: Activity not found or you do not have permission to edit it.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error: Invalid activity ID.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update activity details in the database
    $sql = "UPDATE activities SET Act_name = ?, Description = ? WHERE Act_ID = ? AND User_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $title, $description, $act_id, $_SESSION['User_ID']);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>showPopup();</script>";
    } else {
        echo "Error updating activity: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect back to activities page after update
    header("Location: activities.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/ngoActivityForm.css">
    <title>Edit NGO Activity</title>
    <style>
        /* Style for the form container */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }

        /* Style for the title */
        .form-container h1 {
            margin-bottom: 20px;
        }

        /* Style for form rows */
        .form-row {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 15px;
        }

        /* Style for form labels */
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        /* Style for form inputs */
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Style for textarea */
        textarea {
            height: 150px;
            resize: none;
        }

        /* Style for the submit button */
        .post-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        /* Style for button hover state */
        .post-button:hover {
            background-color: #45a049;
        }

        /* Style for close button */
        .close-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .close-button a {
            font-size: 2em;
            color: red;
            text-decoration: none;
        }

        /* Style for popup overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
        }

        /* Style for popup message */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            display: none;
            position: relative;
            width: 300px;
        }

        /* Style for popup close button */
        .popup-close {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .popup-close a {
            font-size: 1.5em;
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main>
        <div class="form-container">
            <div class="close-button">
                <a href="activities.php">&times;</a>
            </div>
            <h1>EDIT ACTIVITY</h1>
            <!-- Form POST to editact.php for handling submission -->
            <form action="editact.php?id=<?php echo $act_id; ?>" method="POST">
                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="title">ACTIVITY TITLE</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($act_name); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="description">DESCRIPTION</label>
                        <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                    </div>
                </div>
            
                <button type="submit" class="post-button">UPDATE</button>
            </form>
        </div>
    </main>

    <!-- Pop-up and Overlay -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <div class="popup-close"><a href="activities.php">&times;</a></div>
        <p>Your activity has been updated successfully.</p>
    </div>

    <script>
        function showPopup() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>
</html>
