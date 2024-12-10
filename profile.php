<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4a148c, #1a237e);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            background: #3f51b5;
            padding: 20px;
            border-radius: 15px;
            width: 600px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .profile-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }
        .profile-container a {
            color: #03a9f4;
            text-decoration: none;
        }
        .profile-info {
            text-align: left;
            margin: 20px 0;
        }
        .profile-info div {
            margin-bottom: 10px;
        }
        .profile-info div span {
            font-weight: bold;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .buttons a {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .buttons a:hover {
            background: white;
            color: #3f51b5;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Phil-Seas</h1>
        <img src="your-image-url-here.jpg" alt="Profile Picture">
        <a href="editProfile.html" class="edit-link">edit</a>
        <div class="profile-info">
            <div><span>Name:</span> Samuel L. Jackson</div>
            <div><span>Address:</span> California, U.S.A</div>
            <div><span>Contact Info:</span> 0913-246-9789</div>
            <div><span>Email Address:</span> samuel@gmail.com</div>
        </div>
        <div class="buttons">
            <a href="#">Donation Log</a>
            <a href="#">Volunteered Activities</a>
        </div>
    </div>
</body>
</html>
