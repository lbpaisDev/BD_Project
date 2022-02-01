<?php
    require_once 'connect.php';
    session_start();
    $connection = OpenCon();

    $id='';
    if (!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    if (empty($_GET['id'])){
        throw new Exception("ID is Blank");
    }

    $sql = "UPDATE request_team SET accepted = '0' where reqid = '".$id."'";
    $resp = $connection->query($sql);

    header("Location: capitan_pedidos.php");
    die;
    ?>