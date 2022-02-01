<?php
    session_start();
    require_once "connect.php";
    $quicko = $_SESSION['editTourId'];

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit();
    }

    if(isset($_GET['upt_id'])){
        $upt = $_GET['upt_id'];
        console_log($upt);
    }

    if(isset($_SESSION['tutu1']) and isset($_SESSION['tutu2'])) {
        $db = OpenCon();
        $cast1 = $_SESSION['tutu1'];
        $cast2 = $_SESSION['tutu2'];

        $query = "UPDATE game set goalsteam1manager=$cast1, goalsteam2manager=$cast2, check_game='0' WHERE gameid=$upt;";
        mysqli_query($db, $query);
        console_log($query);

    }else{
        echo 'Invalid';
    }

    header('Location: confResult.php');

?>