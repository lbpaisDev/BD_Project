<?php
    require_once 'connect.php';
    $db = OpenCon();


    $id='';
    if (!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    if (empty($_GET['id'])){
        throw new Exception("ID is Blank");
    }

    $sql = "SELECT  user_cc,team_name,pos from request_team WHERE reqid = '".$id."'";
    $resp = $db->query($sql);
    $row = mysqli_fetch_assoc($resp);
    $user_cc = $row['user_cc'];
    $team_name = $row['team_name'];
    $pos = $row['pos'];
    $user_cc = $row['user_cc'];
    $sql = "SELECT contact,name FROM user where cc = '".$user_cc."'";
    $resp = $db->query($sql);
    $row=mysqli_fetch_assoc($resp);
    $contact = $row['contact'];
    $name = $row['name'];
    echo $user_cc;


    $sql = "INSERT INTO player (balance, callnumber, position, status, isavailable, gamesplayed, goalsscored, gamesmissed, faults, teamname, user_cc,isvisible) VALUES ('0', $contact,'$pos', 'Apto a Jogar', '1', '0', '0', '0', '0', '$team_name', $user_cc,1)";
    $resp = $db->query($sql);
    $sql = "UPDATE request_team SET accepted = '1' where reqid = '".$id."'";
    $resp = $db->query($sql);
    $sql = "UPDATE capitan_team SET team_nplayers = team_nplayers + 1 where team_name = '".$team_name."'";
    $resp = $db->query($sql);
    header("Location: capitan_pedidos.php");
    die;
