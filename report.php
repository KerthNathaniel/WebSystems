<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REPORTS</title>
  <link rel="stylesheet" href="css/navBar.css">
  <link rel="stylesheet" href="css/report.css">
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
  
          <div class="comment">
              <img src="kerth-canda.png" alt="Kerth Canda">
              <p><strong>Kerth Canda:</strong> People really don’t have manners</p>
          </div>
  
          <div class="comment">
              <img src="jhon-mchales.png" alt="Jhon Mchales">
              <p><strong>Jhon Mchales:</strong> This is so sad</p>
          </div>
  
          <div class="comment">
              <img src="ombre-hamsirani.png" alt="Ombre Hamsirani">
              <p><strong>Ombre Hamsirani:</strong> LOL</p>
          </div>
  
          <div class="comment-form">
              <img src="user-avatar.png" alt="User avatar">
              <input type="text" placeholder="Add a comment...">
              <button>Comment</button>
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