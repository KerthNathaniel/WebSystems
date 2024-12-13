<?php
include 'dbconn.php';
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: home.php");
    exit();
}

// Ensure the user has the appropriate role
if (!in_array($_SESSION['Role'], ['ngo', 'consumer', 'seller'])) {
  header("Location: home.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/donations.css">
    <title>Donations</title>
</head>
<style>
  main{
    height: 90%;
  }
  .donateForm {
    width: 650px;
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
    margin-top: 20px;
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
  .text-donate {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px; /* Space between inputs */
  }
  .text-donate input {
      width: 48%; /* Adjust width to fit inline */
  }
  .announcement {
            text-align: center;
            background: #f0f0f0;
            padding: 20px;
            border: 1px solid #ccc;
            margin: 20px auto;
            width: 80%;
            border-radius: 10px;
  }
  .logoutbtn {
      background-color: #f44336; /* Red color for logout */
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
  }

  .logoutbtn:hover {
      background-color: #d32f2f;
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
          <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logoutbtn">LOGOUT</button>
                    </form>
                </li>
            <?php else: ?>
                <!-- Fallback to login button -->
                <li><button class="loginbtn" onclick="openLogin()">LOGIN</button></li>
            <?php endif; ?>
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

      <div class="donateForm" id="donateForm">
      <span class="closeDonate" onclick="closeDonate()">&times;</span>
      <div class="donation">
        <!-- Form POST to the same file for handling submission -->
        <form action="donations.php" method="POST">
          <h4>Donate through GCash:</h4>
          <div class="text-donate">
            <label for="gcashnum">Gcash Number</label>
            <input type="text" name="gcashnum" id="gcashnum" required>
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" required>
          </div>
          <div class="select-donate">
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
          </div>
          
          <button type="submit">Send</button>
        </form>
      </div>
    </div>
    </main>

    

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