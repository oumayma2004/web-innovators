
<?php
include '../../controller/packc.php'; 
$packc = new packc(); 
$packc->deletePack($_GET["id"]); 
header('Location:pack.php');
?>