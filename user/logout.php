<?php
session_start();
session_unset(); 
session_destroy(); 

header('Location: /BERAAM_UTSLAB/user/login.php');
exit;
?>
