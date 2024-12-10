<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVITIES</title>
  <link rel="stylesheet" href="css/navBar.css">
  <link rel="stylesheet" href="css/activities.css">
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
    
      <div class="activities-inline">
        <div class="activities">
          <a href="mangroves.php">MANGROVES PLANTING</a>
        </div>
        <div class="activities">
          <a href="wasteCollect.php">WASTE COLLECTION</a>
        </div>
      </div>
        
      <div class="activities-inline">
        <div class="activities">
          <a href="algaePlant.php">SEAWEED AND ALGAE COLLECTION</a>
        </div>
        <div class="activities">
          <a href="fishFeeding.php">FISH FEEDING</a>
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