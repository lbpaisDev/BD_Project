<?php
    session_start();
    require_once "connect.php";


    if(isset($_GET['del_id'])){
        $apagar = $_GET['del_id'];
        console_log($apagar);
    }

    $db= OpenCon();
    $query = "UPDATE request SET accepted='0' where reqId = $apagar";
    $resp = mysqli_query($db, $query);
    console_log($resp);
    header('Location: popUpRequest.php');

?>