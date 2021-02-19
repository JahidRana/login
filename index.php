<?php

if (isset($_REQUEST['submit'])) {

  require_once("db.php");

  $name = mysqli_real_escape_string($connect, $_REQUEST['userName']);
  $pwd = mysqli_real_escape_string($connect, $_REQUEST['userPwd']);



  $select = "SELECT * FROM registration_table where Email='{$name}'";

  $run_query = mysqli_query($connect, $select);

  $count = mysqli_num_rows($run_query);

  if ($count == 1) {
    $row = mysqli_fetch_assoc($run_query);

      $db_pass = $row['password'];

      $pass_decode = password_verify($pwd, $db_pass);

      if ($pass_decode) {
        header("location: post.php");
      }else{
        header("location: index.php?wrong='wrong password'");
      }

      //remember password code start here
      session_start();
      if (isset($_REQUEST['remember'])) {
        setcookie('emailcookie', $name, time() + 86400);
        setcookie('passwordcookie', $pwd, time() + 86400);
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        // header("location: post.php");
       } else {

        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        // header("location: post.php");
      }
     // remember password code end  here
    
  } 
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jahid's website</title>
  <link rel="stylesheet" href="loginpage.css" />
</head>

<body>
  <section>
    <div class="box">
      <div class="form">
        <h2>Login</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="inputBx">
            <input type="text" name="userName" placeholder="Email here" required value="<?php

                                                                                      if (isset($_COOKIE['emailcookie'])) {
                                                                                        echo $_COOKIE['emailcookie'];
                                                                                      }


                                                                                      ?>" />
            <img src="../images/user.png" alt="" />
          </div>
          <div class="inputBx">
            <input type="password" name="userPwd" placeholder="Password here" required value="<?php
                                                                                          if (isset($_COOKIE['passwordcookie'])) {
                                                                                            echo $_COOKIE['passwordcookie'];
                                                                                          }
                                                                                          ?>" />
            <img src="../images/lock.png" alt="" />
          </div>
          <label class="remember"><input type="checkbox" name="remember" />Remember Me</label>
          <div class="inputBx">
            <input type="submit" name="submit" value="Login" />
          </div>
        </form>
        <?php
        session_start();
        if (isset($_SESSION['msg'])) {
          echo "<p>";
          echo $_SESSION['msg'];
          echo "</p>";
        }

        if (isset($_REQUEST['wrong'])) {

          echo "<h1 style='color:red;text-align:center;'>Wrong Information</h1>";
        }
        ?>
        <p>Forget <a href="#">Password</a></p>
        <p>Sign Up?<a href="reg.php">Create account</a></p>
      </div>
    </div>
  </section>
</body>

</html>