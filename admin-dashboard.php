<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navBar.css">
    <style>
        .profile-container {
            background: #3f51b5;
            padding: 20px;
            border-radius: 15px;
            width: 600px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            justify-content: center;
        }
        .profile-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }
        .profile-container a {
            color: #03a9f4;
            text-decoration: none;
        }
        .profile-info {
            text-align: left;
            margin: 20px 0;
        }
        .profile-info div {
            margin-bottom: 10px;
        }
        .profile-info div span {
            font-weight: bold;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .buttons a {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .buttons a:hover {
            background: white;
            color: #3f51b5;
        }
    </style>
</head>
<body>
    <header class="topBar">
        <h1 class="logo">PHILSEAS</h1>
        <nav class="navbar">
        <ul>
            <li><a href="home.php">HOME</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="market.php">MARKET</a></li>
            <li><a href="report.php">REPORTS</a></li>
            <li><a href="donations.php">DONATIONS</a></li>
            <li><a href="activities.php">ACTIVITIES</a></li>
            <li><button class="loginbtn" onclick="openLogin()">LOGIN</button></li>
        </ul>
        </nav>
    </header>

    <div class="profile-container">
        <?php
        // Connect to the database
        include 'dbconn.php'; // Ensure this file has the $conn variable for database connection

        // Start the session
        session_start();

        // Retrieve user data based on logged-in User_ID
        if (isset($_SESSION['User_ID'])) {
            $user_id = $_SESSION['User_ID'];

            // Query to fetch user information
            $sql = "SELECT Username, Email_addr, Number, Address FROM users WHERE User_ID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Display user information
                $name = htmlspecialchars($row['Username']);
                $address = htmlspecialchars($row['Address']);
                $contact = htmlspecialchars($row['Number']);
                $email = htmlspecialchars($row['Email_addr']);
                //$profile_image = htmlspecialchars($row['Profile_Image']); // Assuming this stores the image URL
            } else {
                echo "<p>No user data found.</p>";
                exit();
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Please log in to view your profile.</p>";
            exit();
        }

        mysqli_close($conn);
        ?>
        
        <h1><?php echo $name; ?></h1>
        <img src="pic.png" alt="Profile Picture">
        <a href="editProfile.php" class="edit-link">edit</a>
        <div class="profile-info">
            <div><span>Username:</span> <?php echo $name; ?></div>
            <div><span>Address:</span> <?php echo $address; ?></div>
            <div><span>Contact Info:</span> <?php echo $contact; ?></div>
            <div><span>Email Address:</span> <?php echo $email; ?></div>
        </div>
        <div class="buttons">
            <a href="#">Donation Log</a>
            <a href="#">Volunteered Activities</a>
        </div>
    </div>
</body>
</html>
