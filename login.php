<?php
    include 'dbconn.php';


    if(isset($_POST['email']) && isset($_POST['password'])){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email = validate($_POST['email']);
        $pass = validate($_POST['password']);

        if (empty($email)) {
            header("Location: home.php?error=Email_addr is required");
            exit();
        } elseif (empty($pass)) {
            header("Location: home.php?error=Password is required");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE Email_addr = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt); 
        
            $result = mysqli_stmt_get_result($stmt);
        
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                
                $role = $row['Role'];
                // Verify the password
                if (password_verify($pass, $row['Password'])) {
                    session_start();
                    $_SESSION['User_ID'] = $row['User_ID'];
                    if ($role === 'consumer') {
                        header("Location: consumer-dashboard.php");
                        exit();
                    } elseif ($role === 'seller') {
                        header("Location: seller-dashboard.php");
                        exit();
                    } elseif ($role === 'ngo') {
                        header("Location: ngo-dashboard.php");
                        exit();
                    }
                    
                } else {
                    header("Location: home.php?error=Incorrect password");
                    exit();
                }

            } else {
                header("Location: home.php?error=User not found");
                exit();
            }
        }
    }else{
        header("Location: home.php");
    }

    
?>