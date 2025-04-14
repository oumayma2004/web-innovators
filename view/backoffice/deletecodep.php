
<?php
include '../../controller/codePromoc.php'; 
$codePromoc = new codePromoc(); 
$codePromoc->deleteCodePromo($_GET["id_code"]); 
header('Location:codePromo.php');
?>