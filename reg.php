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
        $userName = mysqli_real_escape_string($connect, $_REQUEST['Name']);
        $email = mysqli_real_escape_string($connect, $_REQUEST['email']);
        $mobile = mysqli_real_escape_string($connect, $_REQUEST['phone']);

        $password = mysqli_real_escape_string($connect, $_REQUEST['pwd']);
        $cpassword = mysqli_real_escape_string($connect, $_REQUEST['pwds']);

        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(15));



        $emailquery = "SELECT * FROM registration_table WHERE email='$email'";
        $result = mysqli_query($connect, $emailquery);
        $emailcount = mysqli_num_rows($result);

        if ($emailcount > 0) {
            echo "Email already exists";
        } else {
            if ($password === $cpassword) {
                $insertquery = "INSERT INTO registration_table(username,Email,mobile,password,cpassword,token,status) VALUES ('$userName','$email','$mobile','$pass','$cpass','$token','inactive')";
                $iquery = mysqli_query($connect, $insertquery);

                if ($iquery) {

                    $subject = "Email Activation";
                    $body = "Hi,$userName.click here to active your account http://localhost/login/active.php?token=$token";
                    $header = "From: jahidrana333@gmail.com";

                    if (mail($email, $subject, $body, $header)) {
                        session_start();
                        $_SESSION['msg'] = "check you mail to active your account $email";
                        header("location: index.php");
                    } else {
                        echo "Email sending failed...";
                    }
                } else {
                    echo "Data Not inserted";
                }
            } else {
                echo "password not matching";
            }
        }
    }
    ?>










    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <input type="text" placeholder="Full Name" name="Name"><br>
        <input type="text" placeholder="Email" name="email"><br>
        <input type="text" placeholder="Phone Number" name="phone"><br>
        <input type="password" placeholder="create password" name="pwd"><br>
        <input type="password" placeholder="confirm password" name="pwds"><br>
        <input type="submit" value="create Account" name="submit">


    </form>
</body>

</html>