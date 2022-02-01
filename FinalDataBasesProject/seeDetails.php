<?php

    session_start();
    require_once "connect.php";

    if(isset($_GET['edit_id'])){
        $torId = $_GET['edit_id'];
        console_log($torId);
    }

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit();
    }



    $connection = OpenCon();
    if ($connection->connect_errno != 0)
    {
        throw new Exception(mysqli_connect_errno());
    }

    $quick_cast = ($_SESSION['cc']);
    $result = $connection->query("SELECT detailsid, gameweekday, gamestarttime, gamefield, gameendtime FROM tournamentdetails WHERE tournament_tournamentid = $torId;");
    $num_of_results = mysqli_num_rows($result);


    if($num_of_results>0)
    {

        echo '
        <table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                <tr>
                    <th>Dia da semana</th>
                    <th>Hora de começo</th>       
                    <th>Hora de termino</th>    
                    <th>Campo</th>             
                    <th>Apagar</th> 
                </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);

            $detailsid = $row['detailsid'];
            $gameweekday = $row['gameweekday'];
            $gamestarttime = $row['gamestarttime'];
            $gameendtime = $row['gameendtime'];
            $gamefield = $row['gamefield'];

            echo
                '<tr>
            <td>'.$gameweekday.'</td>
            <td>'.$gamestarttime.'</td>
            <td>'.$gameendtime.'</td>   
            <td>'.$gamefield.'</td>   
            <form method="post">     
            <td><input name="ajax" id="apagar1" class="bbt" type="submit" value="Apagar"></td> 
           </form>
            </tr>';
        }

        echo '</table>';
    }else{
        echo '<br><br>';
        echo '<h3 style="color: red; position: absolute; left: 20%; top: 40%;">Nao existem horários para esta torneio</h3>';

}



    $result = $connection->query("SELECT nocontestdate from dates WHERE tournament_tournamentid = $torId;");
    $num_of_results = mysqli_num_rows($result);


    if($num_of_results>0)
    {

        echo '
            <table id="Torneios2" class="mytable"> <!-- style="width:70%">  -->
                    <tr>
                        <th>Dias sem jogo</th>            
                        <th>Apagar</th> 
                    </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);

            $nocontestdate = $row['nocontestdate'];

            echo
                '<tr>
                <td>'.$nocontestdate.'</td>  
                <form method="post">     
                <td><input name="ajax2" id="apagar1" class="bbt" type="submit" value="Apagar"></td> 
               </form>
                </tr>';
        }

        echo '</table>';
    }else{
        echo '<br><br>';
        echo '<h3 style="color: red; position: absolute; left: 60%; top: 40%;">Nao existem dias sem jogo</h3>';

    }

?>

<!DOCTYPE html>
<html lang="pt">

<!--Header -->
<!--References all css and js usages-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>FOOTBALLERS'R'US</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Page Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styling -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="css/seeDetails.css">

</head>

<!--Body-->

<body>

<!--/Navigation Bar-->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div id="navbox" style="margin-top: 20px">
                    <a href="php/frontEnd/mainNav.php" style="color: #FFF; text-decoration: none;font-weight: 600;font-size: 20px;letter-spacing: 0.5px;">
                        <em style="font-weight: 600;color: black;">FOOT</em>
                        <span>'R'</span>US</a>
                </div>
            </div>

            <!--/Nav options-->
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="indexGestao.php" class="scroll-top">Home</a>
                    </li>
                    <li>
                        <a href="CriarTorneio.php" class="scroll-link" data-id="torneios">Criar torneio</a>
                    </li>
                    <li>
                        <a href="logout.php" class="scroll-link" data-id="logout">Logout</a>
                    </li>
                </ul>
            </div>
            <!--/.navbar-collapse-->
        </nav>
        <!--/.navbar-->
    </div>
    <!--/.container-->
</div>
<!--/.header-->

<br><br><br><br>
<div>
    <div style="position: fixed; top:12%; right: 40%">
    <h2 class="text-center">Detalhes do torneio</h2>
    </div>

    <br><br>
    <div class="menu-esquerda btn-group">
        <form action="indexGestao.php">
            <button type="submit"><- Voltar</button>
        </form>
    </div>

</div>

</body>

</html>


<?php
require_once "connect.php";
if(isset($_POST['ajax']) and isset($detailsid)) {
    $db = OpenCon();
    $query = "DELETE FROM tournamentdetails where detailsid = $detailsid";
    $result = mysqli_query($db, $query);
}

if(isset($_POST['ajax2']) and isset($nocontestdate)) {
    $db = OpenCon();
    $qiko = $_SESSION['editTourId'];
    $query = "DELETE FROM dates where nocontestdate = '$nocontestdate' and tournament_tournamentid=$qiko";
    $result = mysqli_query($db, $query);
}


?>
