<?php
    require_once 'connect.php';
    $db = OpenCon();
    $issetcc = '';

    $cc='';
    $capcc = $_SESSION['cc'];
    $resp = $db->query("SELECT team_teamname FROM captain_team where user_cc = $capcc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];
    if (!empty($_GET['cc'])){
        $cc = $_GET['cc'];
    }
    if (empty($_GET['cc'])){
        throw new Exception("ID is Blank");
    }

    $sql = "UPDATE user SET user.iscaptain = 0 where cc = '".$capcc."'";
    $resp = $db->query($sql);

    $sql = "UPDATE captain_team SET user_cc = '".$cc."' where team_teamname = '".$teamname."'";
    $resp = $db->query($sql);
    $sql = "UPDATE user SET user.iscaptain = 1 where cc = '".$cc."'";
    $resp = $db->query($sql);
    echo $resp;
    header("Location: capitan_gestao.php"); //header to login page
die;

