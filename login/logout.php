<?php include("functions/init.php");
session_destroy();
setcookie('email', '', time()-84600);
redirect("index.php");
