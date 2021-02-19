<?php 

setcookie('emailcookie',"",time()-86400);
setcookie('passwordcookie',"",time()-86400);

header("location: index.php");




?>