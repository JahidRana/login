<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php

    if (isset($_REQUEST['submit'])) {
        require_once("db.php");
     
        $email = mysqli_real_escape_string($connect, $_REQUEST['email']);
         $emailquery = "SELECT * FROM registration_table WHERE email='$email'";
        $result = mysqli_query($connect, $emailquery);
        $emailcount = mysqli_num_rows($result);
        
        if ($emailcount) {
            $userdata = mysqli_fetch_assoc($result);
            $userName = $userdata['username'];
            $token = $userdata['token'];
                    $subject = "Reset Password";
                    $body = "Hi,$userName.click here to reset your password http://localhost/login/reset_password.php?token=$token";
                    $header = "From: jahidrana333@gmail.com";

                    if (mail($email, $subject, $body, $header)) {
                        session_start();
                        $_SESSION['msg'] = "check you mail to reset your password $email";
                        header("location: index.php");
                    } else {
                        echo "Email sending failed...";
                    }
               
            }else{
               echo "Email Not Matching";
            }
        }
    
    ?>










    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

       
        <input type="text" placeholder="Email" name="email"><br>
 
        <input type="submit" value="send mail" name="submit">


    </form>
</body>

</html>