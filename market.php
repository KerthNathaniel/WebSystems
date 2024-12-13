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
    <title>MARKET</title>
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/market.css">
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

    <main>
        <section class="product-categories">
            <h3>MARKETPLACE</h3>
            <ul>
                <span class="icons"><i class="fa-solid fa-fish fa-rotate-by" style="--fa-rotate-angle: 315deg; color: rgb(48, 9, 139);"></i></span>
                
                <li><a href="market.php">Fishes</a></li>
                <li><a href="clams.php">Clams</a></li>
                <li><a href="crabs.php">Crabs</a></li>
                <li><a href="agar.php">Agar</a></li>
                <!-- <li><a href="others.html">Others</a></li>-->
            </ul>
        </section>

        <section class="product-list">
            <li>
                <img src="images/Fish/alaskan cod.JPG" alt="Alaskan Cod">
                <div class="product-info">
                    <p>Alaskan Cod</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/capelin.jpg" alt="Capelin">
                <div class="product-info">
                    <p>Capelin</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/cod-isolated-7591887.webp" alt="Cod Isolated">
                <div class="product-info">
                    <p>Cod Isolated</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/north cod.jpg" alt="North Cod">
                <div class="product-info">
                    <p>North Cod</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/pacific cod.png" alt="Pacific Cod">
                <div class="product-info">
                    <p>Pacific Cod</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/pollcok.jpg" alt="Pollcock">
                <div class="product-info">
                    <p>Pollcock</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/sardines.jpg" alt="Sardines">
                <div class="product-info">
                    <p>Sardines</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/sea bream.jpg" alt="Sea Brim">
                <div class="product-info">
                    <p>Sea Brim</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/trout.jpg" alt="Trout">
                <div class="product-info">
                    <p>Trout</p>
                </div>
            </li>
            <li>
                <img src="images/Fish/Yellowfin-Tuna.jpg" alt="Yellowfin Tuna">
                <div class="product-info">
                    <p>Yellowfin Tuna</p>
                </div>
            </li>
        </section>
    </main>
    
    <script src="https://kit.fontawesome.com/3ea0af40f5.js" crossorigin="anonymous"></script>

</body>
</html>