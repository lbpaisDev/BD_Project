<?php

//Continue sessions
    session_start();
    //Issue destroy command
    session_destroy();
    header("Location: index.php");
?>
