<?php 


$host = "localhost";
$userName = "jahidrana";
$userPwd = "601888";
$dbName = "logindata";

$connect = mysqli_connect($host,$userName,$userPwd,$dbName);



if(!$connect){
   die("DataBase not Connected".mysqli_error());
}


?>