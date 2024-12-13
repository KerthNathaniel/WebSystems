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
    } else {
        echo "<p>No user data found.</p>";
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<p>Please log in to view your profile.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navBar.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }
        .profile-container, .donation-log-container, .activities-container, .joined-activities-container, .activity-participants-container, .donators-list-container {
            background: #3f51b5;
            padding: 10px 20px;
            border-radius: 15px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            justify-content: center;
            position: relative;
            overflow: hidden; /* To keep the container size fixed */
        }
        .profile-container h1, .donation-log-container h1, .activities-container h1, .joined-activities-container h1, .activity-participants-container h1, .donators-list-container h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .profile-container img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }
        .profile-container a {
            color: #03a9f4;
            text-decoration: none;
        }
        .profile-info, .donation-log, .activities-log, .joined-activities-log, .activity-participants-log, .donators-list-log {
            text-align: left;
            margin: 10px 0;
            max-height: 150px; /* Adjust this as needed */
            overflow-y: auto; /* Make it scrollable */
        }
        .profile-info div, .donation-log div, .activities-log div, .joined-activities-log div, .activity-participants-log div, .donators-list-log div {
            margin-bottom: 10px;
            position: relative;
        }
        .profile-info div span, .donation-log div span, .activities-log div span, .joined-activities-log div span, .activity-participants-log div span, .donators-list-log div span {
            font-weight: bold;
        }
        .edit-button, .delete-button {
            display: inline-block;
            background-color: white;
            border: 1px solid #ccc;
            padding: 3px 8px;
            text-decoration: none;
            color: black;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        .edit-button:hover, .delete-button:hover {
            background-color: #f0f0f0;
            color: #000;
        }
        .add-button {
            background-color: #fff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        .add-button:hover {
            background-color: #f0f0f0;
        }
        .add-button img {
            width: 30px;
            height: 30px;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 5px;
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
    <div class="container">
        <div class="profile-container">
            <h1>Non Government Organization</h1>
            <img src="pic.png" alt="Profile Picture">
            <a href="editProfile.php" class="edit-link">edit</a>
            <div class="profile-info">
                <div><span>Username:</span> <?php echo $name; ?></div>
                <div><span>Address:</span> <?php echo $address; ?></div>
                <div><span>Contact Info:</span> <?php echo $contact; ?></div>
                <div><span>Email Address:</span> <?php echo $email; ?></div>
            </div>
            <div class="add-button">
                <a href="ngoactivityPOST.php"><img src="icon/icons8-add-30.png" alt="Add"></a>
            </div>
        </div>
        <div class="donation-log-container">
            <h1>Donation Log</h1>
            <div class="donation-log">
                <?php
                // Fetch the list of donations for the logged-in user
                $sql = "SELECT d.Amount, a.Act_name 
                        FROM donations d 
                        JOIN activities a ON d.Act_ID = a.Act_ID 
                        WHERE d.User_ID = ? 
                        ORDER BY d.Donate_ID DESC";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div><span>Donated:</span> " . htmlspecialchars($row['Amount']) . " PHP to <strong>" . htmlspecialchars($row['Act_name']) . "</strong></div>";
                    }
                } else {
                    echo "<div>No donations found.</div>";
                }

                mysqli_stmt_close($stmt);
                ?>
            </div>
        </div>
        
        <div class="activities-container">
            <h1>Posted Activities</h1>
            <div class="activities-log">
                <?php
                // Fetch the list of activities for the[_{{{CITATION{{{_1{](https://github.com/keangkai/Instagram-without-accesstoken/tree/f0191ec0ee3c2ac864206469c29eaba2c9e8697d/getdata.php)[_{{{CITATION{{{_2{](https://github.com/wiza898/webcode/tree/cd9d543a39726a2761f1b4eaf09bf41eec89606a/admin%2Fok.php)[_{{{CITATION{{{_3{](https://github.com/Alson33/Minor_Project_SBR/tree/9cb6e7545623ee20314f04a33df4a94e529cd05a/PAGES%2Fprofile.php)[_{{{CITATION{{{_4{](https://github.com/hemanthcmbadoor/laravellogin/tree/ddd3925ee4a45836a2faaa7a15cd095687d2cf31/resources%2Fviews%2Flayouts%2Fprofile.blade.php)
                        // Fetch the list of activities for the logged-in NGO user
                        $sql = "SELECT Act_ID, Act_name, Description FROM activities WHERE User_ID = ? ORDER BY Act_ID DESC";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
        
                        $result = mysqli_stmt_get_result($stmt);
        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div style='display: flex; justify-content: space-between; align-items: center;'><span><strong>Activity:</strong> " . htmlspecialchars($row['Act_name']) . "<br><strong>Description:</strong> " . htmlspecialchars($row['Description']) . "</span>";
                                echo "<div class='action-buttons'>";
                                echo "<a class='edit-button' href='editact.php?id=" . htmlspecialchars($row['Act_ID']) . "'>Edit</a>";
                                echo "<a class='delete-button' href='deleteact.php?id=" . htmlspecialchars($row['Act_ID']) . "'>Delete</a>";
                                echo "</div></div>";
                            }
                        } else {
                            echo "<div>No activities found.</div>";
                        }
        
                        mysqli_stmt_close($stmt);
                        ?>
                    </div>
                </div>
                
                <div class="joined-activities-container">
                    <h1>Joined Activities</h1>
                    <div class="joined-activities-log">
                        <?php
                        // Fetch the list of activities that the NGO has joined
                        $sql = "SELECT a.Act_name 
                                FROM user_activities ua 
                                JOIN activities a ON ua.Act_ID = a.Act_ID 
                                WHERE ua.User_ID = ? 
                                ORDER BY a.Act_ID DESC";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
        
                        $result = mysqli_stmt_get_result($stmt);
        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div><span>Activity:</span> " . htmlspecialchars($row['Act_name']) . "</div>";
                            }
                        } else {
                            echo "<div>No joined activities found.</div>";
                        }
        
                        mysqli_stmt_close($stmt);
                        ?>
                    </div>
                </div>
                
                <div class="activity-participants-container">
                    <h1>Participants in Your Activities</h1>
                    <div class="activity-participants-log">
                        <?php
                        // Fetch the participants for the activities posted by the logged-in NGO user
                        $sql = "SELECT ua.User_ID, u.Username, a.Act_name 
                                FROM user_activities ua 
                                JOIN users u ON ua.User_ID = u.User_ID 
                                JOIN activities a ON ua.Act_ID = a.Act_ID 
                                WHERE a.User_ID = ? 
                                ORDER BY ua.Participation_Date DESC";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
        
                        $result = mysqli_stmt_get_result($stmt);
        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div><span>User:</span> " . htmlspecialchars($row['Username']) . "<br><span>Activity:</span> " . htmlspecialchars($row['Act_name']) . "</div>";
                            }
                        } else {
                            echo "<div>No participants found.</div>";
                        }
        
                        mysqli_stmt_close($stmt);
                        ?>
                    </div>
                </div>
        
                <div class="donators-list-container">
            <h1>Donators List</h1>
            <div class="donators-list-log">
                <?php
                // Fetch the list of donators for the activities posted by the logged-in NGO user
                $sql = "SELECT d.User_ID, u.Username, d.Amount, a.Act_name 
                        FROM donations d 
                        JOIN users u ON d.User_ID = u.User_ID 
                        JOIN activities a ON d.Act_ID = a.Act_ID 
                        WHERE a.User_ID = ? 
                        ORDER BY d.Donate_ID DESC";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div><span>User:</span> " . htmlspecialchars($row['Username']) . "<br><span>Donated:</span> " . htmlspecialchars($row['Amount']) . " PHP to <strong>" . htmlspecialchars($row['Act_name']) . "</strong></div>";
                    }
                } else {
                    echo "<div>No donators found.</div>";
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>
            </div>
        </div>

            </div>
        </body>
        </html>
        