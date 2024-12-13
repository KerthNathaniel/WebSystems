<?php
// Start the session
session_start();

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
    $gcashnum = $_POST['gcashnum'];
    $amount = $_POST['amount'];
    $activity = $_POST['activity'];
    // Use the logged-in user's User_ID from the session
    if (isset($_SESSION['User_ID'])) {
        $user_id = $_SESSION['User_ID'];
    } else {
        die("Error: User not logged in.");
    }

    // Insert form data into donations table
    $sql = "INSERT INTO donations (Amount, number, Act_ID, User_ID) VALUES ('$amount', '$gcashnum', '$activity', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to avoid re-submitting the form on page refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="css/donations.css">
    <title>Donations</title>
    <style>
        .announcement {
            text-align: center;
            background: #f0f0f0;
            padding: 20px;
            border: 1px solid #ccc;
            margin: 20px auto;
            width: 80%;
            border-radius: 10px;
        }
    </style>
</head>
<style>
  .donateForm {
    width: 250px;
    padding: 20px;
    border: 2px solid #fff;
    border-radius: 20px;
    backdrop-filter: blur(20px);
    box-shadow: 0 0 30px rgba(131, 4, 78, 0.5);
    visibility: hidden;
    overflow-y: auto; /* Ensure it is scrollable */
    max-height: 400px; /* Set a maximum height */
    transition: .3s;
    color: white;
  }
  .closeDonate {
    color: white;
    font-size: 2em;
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    width: 45px;
    height: 45px;
    background: rgb(80, 5, 179);
    font-weight: 600;
    display: flex;
    justify-content: center;
    text-align: center;
    align-items: center;
    border-bottom-left-radius: 18px;
    z-index: 1;
  }
  .donateForm input, .donateForm select, .donateForm button {
    display: block;
    width: calc(100% - 40px);
    margin: 10px;
    padding: 10px;
    border-radius: 5px;
    border: none;
  }
  .donation {
    justify-content: center;
    display: flex;
  }
  .donations-list {
    max-height: 200px; /* Set a maximum height for the list */
    overflow-y: auto; /* Make the list scrollable */
  }
</style>
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

    <main>
      <div class="announcement">
        <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "webdev";

        $conn = mysqli_connect($hostname, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the latest donation announcement
        $sql = "SELECT d.Amount, u.Username, a.Act_name 
                FROM donations d 
                JOIN users u ON d.User_ID = u.User_ID 
                JOIN activities a ON d.Act_ID = a.Act_ID 
                ORDER BY d.Donate_ID DESC LIMIT 1";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'] . " has donated " . $row['Amount'] . " PHP to <strong>" . $row['Act_name'] . "</strong>";
        } else {
            echo "No donations yet.";
        }
        ?>
      </div>
      <div class="donations-container">
        <ul class="donations-list">
        <?php
          // Fetch the list of all donations
          $sql = "SELECT d.Amount, u.Username, a.Act_name 
                  FROM donations d 
                  JOIN users u ON d.User_ID = u.User_ID 
                  JOIN activities a ON d.Act_ID = a.Act_ID 
                  ORDER BY d.Donate_ID DESC";

          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                  echo "<li>" . $row['Username'] . " has donated " . $row['Amount'] . " PHP to <strong>" . $row['Act_name'] . "</strong></li>";
              }
          } else {
              echo "<li>No donations yet.</li>";
          }

          // Close connection
          mysqli_close($conn);
          ?>
        </ul>
        <button class="donate-button" onclick="openDonate()">DONATE</button>
      </div>
    </main>

    <div class="donateForm" id="donateForm">
      <span class="closeDonate" onclick="closeDonate()">&times;</span>
      <div class="donation">
        <!-- Form POST to the same file for handling submission -->
        <form action="donations.php" method="POST">
          <h4>Donate through GCash:</h4>
          <label for="gcashnum">Gcash Number</label>
          <input type="text" name="gcashnum" id="gcashnum" required>
          <label for="amount">Amount</label>
          <input type="number" name="amount" id="amount" required>
          <label for="activity">Activity</label>
          <select name="activity" id="activity" required>
            <?php
            // Fetch activities from the database to populate the dropdown
            $conn = mysqli_connect($hostname, $username, $password, $database);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT Act_ID, Act_name FROM activities";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['Act_ID'] . "'>" . $row['Act_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No activities available</option>";
            }
            mysqli_close($conn);
            ?>
          </select>
          <button type="submit">Send</button>
        </form>
      </div>
    </div>

    <script>
      function openDonate() {
        document.getElementById("donateForm").style.visibility = "visible";
      }
      function closeDonate() {
        document.getElementById("donateForm").style.visibility = "hidden";
      }
    </script>
</body>
</html>

