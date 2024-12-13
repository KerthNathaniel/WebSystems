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
// Fetch the username from the session
$username = isset($_SESSION['Username']) ? $_SESSION['Username'] : '';

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

      p{
        font-size: 1.5em;
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
    
    <div class="reportbtn">
      <a href="reportForm.php" class="report-label" id="report-label">REPORT</a>
    </div>
    
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
    
    <!-- Content -->
    <div class="content-container">
      <div class="report-content">
          
          <div class="side-report">
              <div class="report-item">
                  <p>Basilan police confiscate materials for dynamite fishing</p>
              </div>
              <br>
              <br>
              <div class="report-item">
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
                <div class="comment-form">
                    <span class="username"><?php echo htmlspecialchars($username); ?></span>
                    <form action="postcomment.php" method="POST" style="display: flex; align-items: center; width: 100%;">
                        <input type="hidden" name="act_id" value="<?php echo $act_id; ?>">
                        <input type="text" name="comment_text" placeholder="Add a comment..." required style="flex: 1; margin-right: 10px;">
                        <button type="submit">Comment</button>
                    </form>
                </div>
                <div class="comments-container">
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment">
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
                
            </div>
        </div>
    </div>
  
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