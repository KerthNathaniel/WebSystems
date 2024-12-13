<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['User_ID'])) {
    echo "Error: User not logged in.";
    exit;
}

// Fetch the username from the session
$username = isset($_SESSION['Username']) ? $_SESSION['Username'] : '';

// Database connection details
$hostname = "localhost";
$db_username = "root"; // Changed variable name to avoid conflict with session username
$password = "";
$database = "webdev";

// Create connection
$conn = mysqli_connect($hostname, $db_username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch comments from the database for a specific Act_ID (replace with appropriate activity ID)
$act_id = 1; // Example Act_ID, you may want to dynamically set this based on context
$sql = "SELECT comments.Comment_ID, comments.Comment_Text, comments.Comment_Date, comments.User_ID, users.Username 
        FROM comments 
        JOIN users ON comments.User_ID = users.User_ID 
        WHERE comments.Act_ID = ? 
        ORDER BY comments.Comment_Date DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $act_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$comments = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REPORTS</title>
  <link rel="stylesheet" href="css/navBar.css">
  <link rel="stylesheet" href="css/report.css">
  <style>
      .comment {
          margin-bottom: 20px; /* Add spacing between comments */
          padding: 10px;
          border-bottom: 1px solid #ccc;
          display: flex;
          align-items: flex-start;
          position: relative; /* For positioning the delete button */
      }
      .comment img {
          display: inline-block;
          vertical-align: top;
          margin-right: 15px;
      }
      .comment-details {
          display: inline-block;
          vertical-align: top;
          max-width: calc(100% - 60px);
      }
      .comment-username {
          font-weight: bold;
          margin-right: 10px;
          display: inline-block;
      }
      .comment-date {
          color: #666;
          display: inline-block;
          margin-bottom: 5px;
      }
      .comment-text {
          display: block;
          margin-bottom: 10px;
      }
      .delete-button {
          background-color: #ff4c4c;
          color: white;
          border: none;
          padding: 5px 10px;
          border-radius: 3px;
          cursor: pointer;
          position: absolute;
          top: 10px;
          right: 10px;
      }
      .comments-container {
          max-height: 300px; /* Adjust based on the height of your comments */
          overflow-y: auto;
      }
      .comment-form {
          display: flex;
          align-items: center;
          margin-top: 20px;
          width: 100%; /* Ensure the comment form takes full width */
      }
      .comment-form .username {
          margin-right: 10px;
          font-weight: bold;
      }
      .comment-form input[type="text"] {
          flex: 1;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 3px;
          width: calc(100% - 120px); /* Adjust to make it span full width */
      }
      .comment-form button {
          margin-left: 10px;
          padding: 10px 20px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 3px;
          cursor: pointer;
          flex-shrink: 0; /* Ensure the button stays the same size */
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
              <li><button class="loginbtn" onclick="openLogin()">LOGIN</button></li>
          </ul>
      </nav>
    </header>

    <div class="container">
        <div class="reportbtn">
            <a href="reportForm.php" class="report-label" id="report-label">REPORT</a>
        </div>
        
        <!-- Login -->
        <div class="formContainer" id="loginPop">
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
        
        <!-- Content -->
        <div class="content-container">
            <div class="report-content">
                <div class="side-report">
                    <div class="report-item">
                        <img src="sample.png" alt="Basilan police">
                        <p>Basilan police confiscate materials for dynamite fishing</p>
                    </div>
                    <div class="report-item">
                        <img src="sample.png" alt="Pagadian leads clean-up">
                        <p>Pagadian leads simultaneous coastal clean-up activity</p>
                    </div>
                </div>
  
                <div class="main-report">
                    <h2>General Santos, Philippines</h2>
                    <p>In a significant crackdown on illegal fishing practices, local authorities arrested a fisherman caught using cyanide to capture fish in the waters off General Santos. The arrest marks a crucial step in the ongoing efforts to protect the region's delicate marine ecosystems.</p>
                    <p><strong>The Incident:</strong> The fisherman, identified as Juan Dela Cruz, was apprehended by the Philippine Coast Guard during a routine patrol. Authorities discovered several bottles of sodium cyanide and a substantial catch of live fish in his possession.</p>
                </div>
            </div>
  
            <!-- Comment Section -->
            <div class="comments-section">
                <h3>COMMENTS</h3>
                <div class="comments-container">
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <img src="user-avatar.png" alt="User avatar" width="40" height="40">
                        <div class="comment-details">
                            <span class="comment-username"><?php echo htmlspecialchars($comment['Username']); ?></span>
                            <span class="comment-date"><?php echo htmlspecialchars($comment['Comment_Date']); ?></span>
                            <p class="comment-text"><?php echo htmlspecialchars($comment['Comment_Text']); ?></p>
                            <?php if ($comment['User_ID'] == $_SESSION['User_ID']): ?>
                            <form action="deletecomment.php" method="POST">
                                <input type="hidden" name="comment_id" value="<?php echo $comment['Comment_ID']; ?>">
                                <input type="hidden" name="act_id" value="<?php echo $act_id; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="comment-form">
                    <span class="username"><?php echo htmlspecialchars($username); ?></span>
                    <form action="postcomment.php" method="POST" style="display: flex; align-items: center; width: 100%;">
                        <input type="hidden" name="act_id" value="<?php echo $act_id; ?>">
                        <input type="text" name="comment_text" placeholder="Add a comment..." required style="flex: 1; margin-right: 10px;">
                        <button type="submit">Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script>
      function openLogin[_{{{CITATION{{{_1{](https://github.com/yash-hoke-0602/TYCSEmini/tree/a12a6af71fba9f14a71dd4e781f83e1925bdd4f7/teqip%2FRegistration%2Fverify.php)[_{{{CITATION{{{_2{](https://github.com/rhen99/php-simple-blog-project/tree/0ba9d497dea60374f0aaf228840057121366ce4b/edit_post.php)[_{{{CITATION{{{_3{](https://github.com/Racheal-Iperu/LARAVEL-PART-G-15-COVID-19-CASE-MANAGEMENT-SYSTEM/tree/6af2d2e6640995896fc2db2740adadfc67f4f05e/resources%2Fviews%2Freports.blade.php)
        function openLogin() {
        document.getElementById("loginPop").style.visibility = "visible";
      }
  
      function closeForm() {
        document.getElementById("loginPop").style.visibility = "hidden";
      }
    </script>
  
</body>
</html>
