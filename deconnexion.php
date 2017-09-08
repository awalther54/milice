<?php
include ('info_base_donnees.php');
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit();
?>