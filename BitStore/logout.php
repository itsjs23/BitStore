<?php
session_start();
unset($_SESSION["myuserid"]);  
unset($_SESSION["myusername"]);  
unset($_SESSION["mypassword"]);
unset($_SESSION["type"]);
session_unset();
session_destroy();
header("Location: index.php");
?>