<?php 

session_start();
session_destroy();
header("Location: http://localhost/php/Motus/PHP/connexion/login.php");
exit();

?>