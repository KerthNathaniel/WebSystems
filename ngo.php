<?php
    require("dbconn.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['user'];
        $email = $_POST['email'];
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $confirm = $_POST['confirm_pass'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $role = 'ngo';

        if($pass !== $pass_confirm){
            header("location: consumer.php?error=Passwords do not match!");
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO users (Username, Email_addr, Password, Number, Address, Role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $username, $email, $password, $number, $address, $role);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    
        header("Location: home.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <style>
        *{
            box-sizing: border-box;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        body {
            min-height: 100vh;
            background: url('/images/background_oks.png') no-repeat;
            background-size: 80% 80%; 
            background-color: rgb(48, 9, 139);
            background-position-y: bottom;
            background-position-x: right;
        }

        .container {
            width: 40%;
            margin: 0 auto;
            padding: 20px;
            background: rgb(93, 27, 216);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            display: block;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background: none;
            color: white;
            padding: 10px 20px;
            border: 2px solid rgb(9, 204, 25);
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            border: 2px solid #3e8e41;
            font-size: medium;
        }
        .btn{
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        a{
            padding: 20px 30px;
            border: 2px solid;
            display: flex;
            color: white;
            text-align: center;
            text-decoration: none;
            justify-content: center;
            width: 10%;
            border-radius: 15px;

        }
        a:hover{
            color: gray;
        }
        .error{
            background: #f2dede;
            color: #a94442;
            padding: 10px;
            width: 95%;
            border-radius: 5px;

        }
        
    </style>
</head>
<body>
    <h2>Non Government Organization</h2>
    <div class="container">
        <form class="register-form" action="" method="post" onsubmit="return validateForm()">

            <label for="user">Username</label>
            <input type="text" name="user" id="user" placeholder="Enter Username" required> <br>

            <label for="email">Company Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Email" required> <br>

            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass" placeholder="Enter Password" required><br>

            <label for="confirm_pass"> Confirm Password</label>
            <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Confirm Password" onsubmit="validateForm()" required><br>

            <label for="number">Contact Number</label>
            <input type="text" name="number" id="number" placeholder="Enter Number" required><br>

            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="Enter Address" required><br>

            

            <button type="submit">Register</button>
    
    
        </form>
    </div>
    <div class="btn">
        <a href="register.php">Go Back</a>
    </div>
    
    <script>
        function validateForm() {
            let password = document.getElementById("pass").value;
            let confirmPassword = document.getElementById("confirm_pass").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
    
</body>
</html>