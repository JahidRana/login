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
    session_start();
    if (isset($_REQUEST['submit'])) {
        require_once("db.php");

        if (isset($_REQUEST['token'])) {

            $token = $_REQUEST['token'];
           
            $password = mysqli_real_escape_string($connect, $_REQUEST['pwd']);
            $cpassword = mysqli_real_escape_string($connect, $_REQUEST['pwds']);

            $pass = password_hash($password, PASSWORD_BCRYPT);
            $cpass = password_hash($cpassword, PASSWORD_BCRYPT);



            if ($password === $cpassword) {
                $insertquery = "UPDATE registration_table SET password='$pass' WHERE token='$token'";
                $iquery = mysqli_query($connect, $insertquery);
                echo $iquery;
                if ($iquery) {

                    $_SESSION['msg'] = "Updated password $email";
                    header("location: index.php");
                } else {
                    $_SESSION['passmsg'] = 'Password not updated';
                    // header("location: reset_password.php");
                }
            } else {
                $_SESSION['passmsg'] = 'Password not matching';
            }
        } else {
            echo "Token not found";
        }
    }



    ?>










    <form action="" autocomplete="off" method="POST">

        <p>
            <?php
            if (isset($_SESSION['passmsg'])) {
                echo $_SESSION['passmsg'];
            } else {
                echo $_SESSION['passmsg'] = "";
            }
            ?>
        </p>
        <input type="password" placeholder="create password" name="pwd"><br>
        <input type="password" placeholder="confirm password" name="pwds"><br>
        <input type="submit" value="Update password" name="submit">


    </form>
</body>

</html>