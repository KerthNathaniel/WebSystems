<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOMEPAGE</title>
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="css/navBar.css">
  <style>
    body{
    min-height: 100vh;
    background-image: url('images/bg/background_oks.png') no-repeat;
    background-size: 80% 80%; 
    background-color: rgb(48, 9, 139);
    background-position-y: bottom;
    background-position-x: right;
    }
  </style>
  
</head>
<body style="background-image: url('images/bg/background_oks.png') no-repeat; background-size: cover; background-repeat: no-repeat; background-position: center;">

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
    
    <!-- Log In -->
    <div class="formContainer"  id="loginPop">
      <span class="closelogin" onclick="closeForm()">&times</span>
      <div class="loginForm-login">
        <h2>LOGIN</h2>
        <?php if(isset($_GET['error'])){ ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <form action="login.php" method="POST">
          <div class="input_box">
            <input type="email" name="email" required>
            <label for="email">EMAIL</label>
          </div>
          <div class="input_box">
            <input type="password" name="password" required>
            <label for="password">PASSWORD</label>
          </div>
          <div class="remember-forgot">
            <label><input type="checkbox">Remember Me</label>
            <a href="">Forgot Password?</a>
          </div>
          <button type="submit" class="btn">LOGIN</button>
          <div class="login-register">
            <p>Don't Have an Account?<a href="register.php" class="register-link">Register</a></p>
          </div>
        </form>
      </div>
    </div>

    <!-- Content -->
    <section class="content">
      <h1>PHILSEAS</h1>
      <p>
        Phil-Seas as a website that is dedicated to the protection and 
        preservation of marine life. The website offers a wealth of information 
        on marine species, ocean conservation, and the latest research in marine 
        biology. Visitors can explore detailed profiles of various marine organisms, 
        learn about the challenges facing our oceans, and discover ways to contribute 
        to marine conservation efforts.
      </p>

      <div class="content-buttons">
        <button onclick="openContacts()">Contact Us</button>
        <button><a href="market.php">Shop Now</a></button>
      </div>
    </section>

    <!-- contact window -->
    <div class="contact" id="contactwindow">
      <span class="closecntct" onclick="closeContacts()">&times</span>
      <h4>Contact us through these:</h4>
      <ul>
          <li>+63 912 345 6789</li>
          <li>+63 277 770 8888</li>
          <li>philseas@gmail.com</li>
      </ul>
    </div>

  </div>

  <script>
    function openLogin() {
      document.getElementById("loginPop").style.visibility = "visible";
    }
    function closeForm() {
      document.getElementById("loginPop").style.visibility = "hidden";
    }
    function openContacts() {
      document.getElementById("contactwindow").style.visibility = "visible";
    }
    function closeContacts() {
      document.getElementById("contactwindow").style.visibility = "hidden";
    }
  </script>

</body>
</html>