<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/reportForm.css">
    <title>Report Form</title>
</head>
<body>
    <main>
        
        <div class="close-button">
            <a href="report.php">&times;</a>
        </div>

        <div class="form-container">
            <!-- Form POST to the same file for handling submission -->
            <form action="reportForm.php" method="POST">
                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="name">NAME</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="date">DATE</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="contact">CONTACT NUMBER</label>
                        <input type="text" id="contact" name="contact" required>
                    </div>
                </div>
            
                <div class="form-row">
                    <div style="flex: 1;">
                        <label for="incident">TYPE OF INCIDENT</label>
                        <input type="text" id="incident" name="incident" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="location">LOCATION</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                </div>
            
                <label for="description">DESCRIBE THE SITUATION</label>
                <textarea id="description" name="description" required></textarea>
            
                <button type="submit" class="report-button">REPORT</button>
            </form>
        </div>

    </main>
    
    <!-- Pop-up and Overlay -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <p>YOUR REPORT HAS BEEN SENT TO US. PLEASE BE ASSURED WE WILL RELAY IT TO THE AUTHORITIES AND CONDUCT PROPER INVESTIGATION. THANK YOU FOR KEEPING OUR MARINE ECOSYSTEM HEALTHY AND SAFE.</p>
        <div class="popup-close" onclick="closePopup()"><a href="report.php">&times;</a></div>
    </div>

    <script>
        function showPopup() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Collect form data
    $name = $_POST['name'];
    $date = $_POST['date'];
    $contact = $_POST['contact'];
    $incident = $_POST['incident'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Insert form data into reports table
    $sql = "INSERT INTO reports (Name, Date, Contact_no, Type_of_incident, Location, Description) VALUES ('$name', '$date', '$contact', '$incident', '$location', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>showPopup();</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
