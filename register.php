
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navBar.css">
    <style>
        h1{
            justify-content: center;
            align-items: center;
            display: flex;
            color: white;
        }
        div{
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin-top: 80px;
        }
        .choice{
            padding: 40px 60px;
            border: 2px solid;
            text-decoration: none;
            color: white;
            margin: 60px;
            border-radius: 15px;
            transition: 0.3s;
            background-color: rgb(50, 12, 218);
        }

        .choice:hover{
            color: gray;
            font-size: 1.5em;
        }
        .close-button {
            font-size: 5em;
            color: red;
            cursor: pointer;
            align-self: flex-end;
            z-index: 1;
            text-decoration: none;

        }
    </style>
</head>
<body>
    <div>
        <a  class="close-button" href="home.php">&times;</a>
    </div>
    <h1>Register as...</h1>
    
    <div class="buttons">
    <div>
        <a class="choice" href="consumer.php">User</a>
    </div>
    <div>
        <a class="choice" href="seller.php">Seller</a>
    </div>
    <div>
        <a class="choice" href="ngo.php">NGO</a>
    </div>
    </div>
    
    
</body>
</html>