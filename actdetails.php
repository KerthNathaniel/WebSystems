<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Details</title>
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/activity-content.css">
</head>
<body>
    
    <!-- Top Bar -->
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

    <div class="main-content">
        <?php
        // Start the session
        session_start();

        // Check if User_ID is set in the session
        if (isset($_SESSION['User_ID'])) {
            $user_id = $_SESSION['User_ID'];

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
            $activity_id = $_GET['id'];

            // Fetch activity details from database
            $sql = "SELECT Act_name, Description, Image, User_ID FROM activities WHERE Act_ID = $activity_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo '<h1>' . $row["Act_name"] . '</h1>';
                echo '<p>' . $row["Description"] . '</p>';
                echo '<div class="image">';
                echo '<img src="' . $row["Image"] . '" alt="' . $row["Act_name"] . '">';
                echo '</div>';

                // Check if the logged-in user is the same as the activity creator and is an NGO
                $creator_id = $row['User_ID'];
                if ($creator_id == $user_id) {
                    $user_sql = "SELECT Role FROM users WHERE User_ID = $user_id";
                    $user_result = mysqli_query($conn, $user_sql);
                    if (mysqli_num_rows($user_result) > 0) {
                        $user_data = mysqli_fetch_assoc($user_result);
                        $user_role = $user_data['Role'];
                    } else {
                        $user_role = '';
                    }
                } else {
                    $user_role = '';
                }
            } else {
                echo "Activity not found.";
            }

            // Close connection
            mysqli_close($conn);
        } else {
            echo "User not logged in.";
            $user_role = '';
        }
        ?>
    </div>

    <div class="side-content">
        <div class="button-side">
            <?php
            if ($user_role == 'ngo') {
                echo '<a href="edit_activity.php?id=' . $activity_id . '"><button>EDIT</button></a>';
            } else {
                echo '<form id="joinForm" action="join_activity.php" method="POST" style="display: inline;">
                        <input type="hidden" name="act_id" value="' . $activity_id . '">
                        <input type="hidden" name="user_role" value="' . $user_role . '">
                        <button type="submit">JOIN US</button>
                      </form>';
            }
            ?>
            <a href="donations.php"><button>DONATE</button></a>
        </div>
    </div>

    <script>
        function openLogin() {
            document.getElementById("loginPop").style.visibility = "visible";
        }

        function closeForm() {
            document.getElementById("loginPop").style.visibility = "hidden";
        }
    </script>

</body>
</html>
