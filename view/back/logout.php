<?php
session_start();
session_unset(); 
session_destroy(); 
header('Location:../front office/index.html'); 
exit();
?>
