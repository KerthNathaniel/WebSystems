<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4a148c, #1a237e);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .profile-container {
            background: #3f51b5;
            padding: 20px;
            border-radius: 15px;
            width: 700px;
            display: flex;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }
        .left-section {
            flex: 1;
            text-align: center;
            padding: 10px;
        }
        .left-section img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }
        .left-section a {
            display: block;
            margin-top: 10px;
            color: #03a9f4;
            text-decoration: none;
        }
        .right-section {
            flex: 2;
            padding: 20px;
        }
        .right-section h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .save-button {
            display: inline-block;
            background: transparent;
            color: white;
            border: 2px solid #00ff00;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .save-button:hover {
            background: #00ff00;
            color: #3f51b5;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="left-section">
            <img src="your-image-url-here.jpg" alt="Profile Picture">
            <input type="file" name="" id="" accept="image/*" >
        </div>
        <div class="right-section">
            <h1>Phil-Seas</h1>
            <form>
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" value="Samuel L. Jackson">
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" value="California, U.S.A">
                </div>
                <div class="input-group">
                    <label for="contact">Contact Info</label>
                    <input type="text" id="contact" value="0913-246-9789">
                </div>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" value="samuel@gmail.com">
                </div>
                <button type="submit" class="save-button">SAVE</button>
            </form>
        </div>
    </div>
</body>
</html>
