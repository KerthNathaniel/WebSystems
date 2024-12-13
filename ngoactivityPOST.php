<?php
// Start the session at the very beginning of the script
session_start();

// Check if user is logged in
if (!isset($_SESSION['User_ID'])) {
    echo "Error: User not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Get User_ID from session
    $user_id = $_SESSION['User_ID'];

    // Ensure the uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Check if user ID exists in the users table
    $user_check_sql = "SELECT User_ID FROM users WHERE User_ID = $user_id";
    $user_check_result = mysqli_query($conn, $user_check_sql);

    if (mysqli_num_rows($user_check_result) > 0) {
        // Insert form data into activities table
        $sql = "INSERT INTO activities (Act_name, Description, Image, User_ID) VALUES ('$title', '$description', '$image', $user_id)";
        
        if (mysqli_query($conn, $sql)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo "<script>showPopup();</script>";
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: User ID does not exist.";
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/ngoActivityForm.css">
    <title>Post NGO Activity</title>
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
        input[type="text"], input[type="file"], textarea {
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
                <a href="ngo-dashboard.php">&times;</a>
            </div>
            <h1>POST ACTIVITY</h1>
            <!-- Form POST to ngoactivityPOST.php for handling submission -->
            <form action="ngoactivityPOST.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="title">ACTIVITY TITLE</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                </div>
                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="image">Add Picture</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                </div>

                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="description">DESCRIPTION</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                </div>
            
                <button type="submit" class="post-button">POST</button>
            </form>
        </div>
    </main>

    <!-- Pop-up and Overlay -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <div class="popup-close"><a href="activities.php">&times;</a></div>
        <p>Your activity has been posted successfully.</p>
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
