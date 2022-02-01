<?php
    session_start();
    require_once "connect.php";
    $quicko = $_SESSION['editTourId'];

    if(isset($_GET['del_id'])){
        $apagar = $_GET['del_id'];
        console_log($apagar);
    }

    $db = OpenCon();

    $vagas = $db->query("SELECT freespots from tournament WHERE tournamentid=1");
    $row2 = mysqli_fetch_assoc($vagas);
    $trueVagas = $row2['freespots'];

    if($trueVagas > 0) {
        $query = "UPDATE request SET accepted='1' where reqId = $apagar";
        $resp = mysqli_query($db, $query);
        $query = "UPDATE tournament set freespots=freespots-1, currentteams=currentteams+1 WHERE tournamentid=$quicko;";
        $resp = mysqli_query($db, $query);

        console_log($resp);
    }
    header('Location: popUpRequest.php');

?>