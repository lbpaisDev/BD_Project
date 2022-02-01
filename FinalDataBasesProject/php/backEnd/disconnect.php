<?php
    include('../backEnd/credentialsCheck.php');

    mysql_close($conn);
    header('location: ../frontEnd/home.php');
    exit;
?>