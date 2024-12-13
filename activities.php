<?php
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVITIES</title>
  <link rel="stylesheet" href="css/navBar.css">
  <link rel="stylesheet" href="css/activities.css">
  <style>
    .activities-content {
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
          align-items: flex-start;
          margin-top: 20px;
      }
      .activities-inline {
          display: flex;
          flex-direction: column;
          align-items: center;
          width: 45%;
          margin: 10px;
      }
      .activities {
          border: 2px solid white; /* White border */
          padding: 20px;
          border-radius: 10px;
          text-align: center;
          width: 100%;
          margin-bottom: 20px;
          box-shadow: 0 0 10px rgba(0,0,0,0.1);
          background-color: transparent; /* No fill */
      }
      .activities a {
          text-decoration: none;
          color: white; /* White text */
          font-weight: bold;
      }
      .activities a:hover {
          color: #cccccc; /* Light gray on hover */
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

  <div class="container">
    <!-- Login -->
    <div class="formContainer"  id="loginPop">
      <span class="closelogin" onclick="closeForm()">&times</span>
      <div class="loginForm-login">
        <h2>LOGIN</h2>
        <form action="">
          <div class="input_box">
            <input type="email" required>
            <label for="email">EMAIL</label>
          </div>
          <div class="input_box">
            <input type="password" required>
            <label for="password">PASSWORD</label>
          </div>
          <div class="remember-forgot">
            <label><input type="checkbox">Remember Me</label>
            <a href="">Forgot Password?</a>
          </div>
          <button type="submit" class="btn">LOGIN</button>
          <div class="login-register">
            <p>Don't Have an Account?<a href="" class="register-link">Register</a></p>
          </div>
        </form>
      </div>
    </div>

    <!-- Activities Content -->
    <div class="activities-content">  
      <?php
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

      // Fetch data from activities table
      $sql = "SELECT Act_ID, Act_name, Description, Image FROM activities";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          // Output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo '<div class="activities-inline">';
              echo '<div class="activities">';
              echo '<a href="actdetails.php?id=' . $row["Act_ID"] . '">' . $row["Act_name"] . '</a>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo "No activities found.";
      }

      // Close connection
      mysqli_close($conn);
      ?>
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