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
    <title>ABOUT</title>
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/about.css">
    <style>
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
    
    <div class="about-content">
        <h1>ABOUT PHILSEAS</h1>
        <p><strong>Your Partner in Marine Conservation</strong> <br><br>

            PhilSeas is a dedicated organization committed to the promotion, protection, and preservation of marine life and ecosystems in the 
            Philippines. We strive to create a sustainable future for our oceans and the diverse species that call them home. <br><br>

           <strong>Our Mission</strong> <br><br>

            To inspire and empower individuals to take action in marine conservation, fostering a deep appreciation for our oceans and 
            their invaluable resources. <br><br>

            <strong>Our Vision</strong> <br><br>

            A thriving marine environment where biodiversity flourishes, and coastal communities prosper sustainably. <br><br>

            <strong>What We Offer</strong><br><br>
                <ul>
                    <li><strong>Educational Programs:</strong> Immerse yourself in the wonders of the marine 
                            world through our engaging educational programs. Learn about marine ecology, 
                            biodiversity, and conservation efforts.</li>
                    
                    <li><strong>Volunteer Opportunities:</strong> Join our dedicated team of volunteers and contribute
                        to hands-on conservation projects, such as coral reef restoration, marine debris
                        cleanup, and sea turtle monitoring.</li>
                    <li><strong>Research Initiatives:</strong> Support our cutting-edge research initiatives that provide 
                        valuable insights into marine ecosystems and inform conservation strategies.</li>
                    <li><strong>Community Outreach:</strong> Engage with local communities to raise awareness about marine conservation issues and promote sustainable practices.</li>

                    
                </ul>

            <strong>Join Us in Protecting Our Marine Heritage</strong>

            Together, we can make a significant impact on marine conservation. Whether you're an individual, 
            a business, or an organization, there are numerous ways to get involved.</p>




        <section class="developers">
            <h1>DEVELOPERS</h1>
            <h3>This Project is done by:</h3>
            <ul>
                <li>KERTH NATHANIEL CANDA</li>
                <li>EJAY RULONA</li>
                <li>OMBRE HAMSIRANI III</li>
                <li>JOHN MCHALES BUENAVENTURA</li>
                <li>SOPHIA TOLOSA</li>
            </ul>
        </section>
    </div>
    
</body>
</html>