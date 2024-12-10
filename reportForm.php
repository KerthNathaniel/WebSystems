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
    \
    <main>
        
        <div class="close-button">
            <a href="report.php">&times;</a>
        </div>

        <div class="form-container">
            
            <div class="form-row">
                <div style="flex: 1;">
                    <label for="name">NAME</label>
                    <input type="text" id="name" name="name">
                </div>
                <div style="flex: 1;">
                    <label for="date">DATE</label>
                    <input type="text" id="date" name="date">
                </div>
                <div style="flex: 1;">
                    <label for="contact">CONTACT NUMBER</label>
                    <input type="text" id="contact" name="contact">
                </div>
            </div>
        
            <div class="form-row">
                <div style="flex: 1;">
                    <label for="incident">TYPE OF INCIDENT</label>
                    <input type="text" id="incident" name="incident">
                </div>
                <div style="flex: 1;">
                    <label for="location">LOCATION</label>
                    <input type="text" id="location" name="location">
                </div>
            </div>
        
            <label for="description">DESCRIBE THE SITUATION</label>
            <textarea id="description" name="description"></textarea>
        
            <div class="report-button" onclick="showPopup()">REPORT</div>
        </div>

    </main>
    

    <!-- Pop-up and Overlay -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <p>YOUR REPORT HAS BEEN SENT TO US. PLEASE BE ASSURED WE WILL RELAY IT TO THE AUTHORITIES AND CONDUCT PROPER INVESTIGATION. THANK YOU FOR KEEPING OUR MARINE ECOSYSTEM HEALTHY AND SAFE.</p>
        <div class="popup-close" onclick="closePopup()"><a href="report.html">&times;</a></div>
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