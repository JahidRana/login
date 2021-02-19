<?php 
session_start();
include 'db.php';

if(isset($_REQUEST['token'])){

$token = $_REQUEST['token'];

$updatequery = "UPDATE registration_table SET status='active' where token='$token'";
$query = mysqli_query($connect,$updatequery);


if($query){
if(isset($_SESSION['msg'])){
    $_SESSION['msg'] = "Account updated succesfully";
    header("location: index.php");
}
}else{
    $_SESSION['msg'] = "You are logged out";
    header("location: index.php");
}


}else{
    $_SESSION['msg'] = "Account not Updated";
    header("location: reg.php");
}
