<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /* Existing styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4a148c, #1a237e);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .profile-container {
            background: #3f51b5;
            padding: 20px;
            border-radius: 15px;
            width: 700px;
            display: flex;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }
        .left-section {
            flex: 1;
            text-align: center;
            padding: 10px;
        }
        .left-section img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }
        .left-section input {
            margin-top: 10px;
        }
        .right-section {
            flex: 2;
            padding: 20px;
        }
        .right-section h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .save-button {
            display: inline-block;
            background: transparent;
            color: white;
            border: 2px solid #00ff00;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .save-button:hover {
            background: #00ff00;
            color: #3f51b5;
        }
    </style>
</head>
<body>
    <?php
    include 'dbconn.php';
    session_start();

    // Ensure the user is logged in
    if (!isset($_SESSION['User_ID'])) {
        echo "<p>Please log in to edit your profile.</p>";
        exit();
    }

    $user_id = $_SESSION['User_ID'];

    // Fetch current user data
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "SELECT Username, Email_addr, Number, Address FROM users WHERE User_ID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $name = htmlspecialchars($row['Username']);
            $address = htmlspecialchars($row['Address']);
            $contact = htmlspecialchars($row['Number']);
            $email = htmlspecialchars($row['Email_addr']);
            //$profile_image = htmlspecialchars($row['Profile_Image']);
        } else {
            echo "<p>User data not found.</p>";
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $address = htmlspecialchars($_POST['address']);
        $contact = htmlspecialchars($_POST['contact']);
        $email = htmlspecialchars($_POST['email']);

        // Update the user data
        $update_sql = "UPDATE users SET Username = ?, Address = ?, Number = ?, Email_addr = ? WHERE User_ID = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ssssi", $name, $address, $contact, $email, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            // Fetch the role of the user
            $role_query = "SELECT Role FROM users WHERE User_ID = ?";
            $role_stmt = mysqli_prepare($conn, $role_query);
            mysqli_stmt_bind_param($role_stmt, "i", $user_id);
            mysqli_stmt_execute($role_stmt);
            $role_result = mysqli_stmt_get_result($role_stmt);

            if ($role_row = mysqli_fetch_assoc($role_result)) {
                $role = $role_row['Role'];

                // Redirect based on the role
                if ($role === 'consumer') {
                    header("Location: consumer-dashboard.php");
                } elseif ($role === 'seller') {
                    header("Location: seller-dashboard.php");
                } elseif ($role === 'ngo') {
                    header("Location: ngo-dashboard.php");
                } else {
                    // Default to profile page if role is not recognized
                    header("Location: profile.php");
                }
                exit();
            } else {
                echo "<p>Error fetching user role.</p>";
            }
        } else {
            echo "<p>Error updating profile: " . mysqli_error($conn) . "</p>";
        }

        mysqli_stmt_close($update_stmt);
    }

    mysqli_close($conn);
    ?>
    <div class="profile-container">
        <div class="left-section">
            <img src="<?php echo isset($profile_image) ? $profile_image : 'default-image.jpg'; ?>" alt="Profile Picture">
            <input type="file" name="profile_image" accept="image/*">
        </div>
        <div class="right-section">
            <h1>Edit Profile</h1>
            <form method="POST">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
                </div>
                <div class="input-group">
                    <label for="contact">Contact Info</label>
                    <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                </div>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <button type="submit" class="save-button">SAVE</button>
            </form>
        </div>
    </div>
</body>
</html>
