<?php
    session_start();
    require_once "connect.php";
    $db = OpenCon();
    $cccap = $_SESSION['cc'];
    $resp = $db->query("SELECT team_teamname FROM captain_team where user_cc = $cc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];

    $cc='';
    if (!empty($_GET['cc'])){
        $cc = $_GET['cc'];
    }
    if (empty($_GET['cc'])){
        throw new Exception("ID is Blank");
    }



    $sql = "DELETE player WHERE user_cc = $cc";
    $resp = $db->query($sql);
    $sql = "UPDATE capitan_team SET team_nplayers = team_nplayers - 1 where team_name = '$teamname'";
    $resp = $db->query($sql);


    header("Location: capitan_gestao.php");
    die;

