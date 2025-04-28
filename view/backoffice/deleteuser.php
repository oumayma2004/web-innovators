
<?php
include '../../controller/userc.php'; 
$userc = new userc(); 
$userc->deleteUser($_GET["id"]); 
header('Location:user.php');
?>