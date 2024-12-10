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
  .donateForm{
    width: 20%;
    height: 25%;
    position: absolute;
    border: 2px solid #fff;
    border-radius: 20px;
    backdrop-filter: blur(20px);
    box-shadow: 0, 0, 30px rgba(131, 4, 78, 0.5);
    visibility: hidden;
    overflow: hidden;
    transition: .3s;
    color: white;
    align-content: center

  }
  .closeDonate{
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
  .donateForm input{
    display: flex;
  }
  .donation{
    justify-content: center;
    display: flex;
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
      <div class="donations-container">
        <ul class="donations-list">
            <li>Liam Johnson has donated 500 PHP to <strong>mangrove planting</strong></li>
            <li>Olivia Smith has donated 400 PHP to <strong>waste collection</strong></li>
            <li>Noah Brown has donated 500 PHP to <strong>fish feeding</strong></li>
            <li>Charlotte Taylor has donated 200 PHP to <strong>seaweed and algae planting</strong></li>
            <li>Amelia Thomas has donated 300 PHP to <strong>mangrove planting</strong></li>
            <li>Calliope Morgan has donated 600 PHP to <strong>fish feeding</strong></li>
        </ul>
        <button class="donate-button" onclick="openDonate()">DONATE</button>
      </div>
    </main>

    <div class="donateForm" id="donateForm">
      <span class="closeDonate" onclick="closeDonate()">&times</span>
      <div class="donation">
        <form action="">
          <h4>Donate through GCash
            :</h4>
          <label for="gcashnum">Gcash Number</label>
          <input type="text" name="" id="gcashnum">
          <label for="amount">Amount</label>
          <input type="text" name="" id="amount">
          <button>Send</button>
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