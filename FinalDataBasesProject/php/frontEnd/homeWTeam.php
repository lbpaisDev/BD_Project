<!-- BackEnd PhP-->
<?php 
include('../backEnd/credentialsCheck.php');
$cc=$_SESSION['cc'];
// session_start();

?>



<!DOCTYPE html>
<html>

<!-- Header -->
<!-- References all css and js usages -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>FOOTBALLERS'R'US</title>
    <meta name="description" content="">

    <!-- View Port - reactive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styling -->
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.css">
    <link rel="stylesheet" href="../../css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../js/userNL.js"></script>

</head>

<!--Body-->

<body>

    <!--/Navigation Bar-->
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse"
                        data-target="#main-nav"></button>
                    <div id="navbox" style="margin-top: 20px">
                        <a href="mainNav.php" style="color: #FFF; text-decoration: none;font-weight: 600;font-size: 20px;letter-spacing: 0.5px;">
                            <em style="font-weight: 600;color: black;">FOOT</em>
                            <span>'R'</span>US</a>
                    </div>
                </div>

                <!--/Nav options-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <!-- <a href="#" class="scroll-top"><b>Jogar Já</b></a> -->
                            <a href="#"><b>Home</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="about"><b>Torneios</b></a> -->
                            <a href="./torneios.php" data-id="about"><b>Torneios</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="reglog"><b>Jogadores</b></a> -->
                            <a href="./jogadores.php" data-id="reglog"><b>Jogadores</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="contact-us"><b>Perfil</b></a> -->
                            <a href="./editPerfil.php" data-id="contact-us"><b>Perfil</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="contact-us"><b>Saldo</b></a> -->
                            <a href="./userNL.php" data-id="contact-us"><b>Logout</b></a>
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

    <!--/Home Page-->
    <div class="parallax-content baner-content" id="home">
        <div class="container">

            <div class="col-lg-4">
                <div class="text-content">
                    <h3> As Tuas Equipas </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>Equipas</th>
                            <th>Posição</th>
                            <th>Faltas Dadas</th>
                            <th>Saldo</th>
                            <th>Ver Equipa</th>
                            <!-- <th>Data de Fim</th>
                            <th>Ver Torneio</th> -->
                        </tr>    
                        <?php
                            // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                            // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                            $sql="SELECT user.username,user.name, player.position,player.gamesmissed,player.teamname,player.balance,captain_team.tournament_tournamentid FROM user,player,captain_team where user.cc=player.user_cc and player.user_cc=$cc and player.teamname=captain_team.team_teamname;";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    // $url="./torneioPage.php?torneio_id=".$row["tournamentid"];
                                    $url="./equipaPlay.php?t_name=".$row['teamname']."&torneio_id=".$row['tournament_tournamentid'];
                                    $saldo=$row['balance'];
                                    if($saldo==NULL){
                                        $saldo=0;
                                    }
                                    // echo $url;
                                    echo "<td>".$row["teamname"]."</td>"."<td>".$row["position"]."</td>"."<td>".$row["gamesmissed"]."</td>"."<td>".$saldo."</td>"."<td><a class='button' href='".$url."'><b>Equipa</b></a></td>";
                                    // echo "<td>".$row["tournamentname"]."</td>"."<td>".$row["freespots"]."</td>"."</td>" ."<td>".$row["currentteams"]."</td>"."<td>".$row["gameweekday"]."</td>"."<td>".$row["gamestarttime"]."</td>"."<td>".$row["startdate"]."</td>"."<td>".$row["enddate"]."</td>"."<td><a  class='button' href='./torneiopage.php?torneio_id=1'>Info</a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?> 
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="text-content">
                    <h2>
                        <em>Os Teus Jogos</em>
                    </h2>
                    <!-- <div class="primary-white-button">
                        <a href="./torneios.php" ><b>Os Teus Jogos</b></a> -->
                    <!-- </div> -->
                    <div class="primary-white-button">
                        <?php
                            $sql2="SELECT game.teamone,game.teamtwo,game.gamedate,game.starttime,game.gamefield from game,substitute WHERE substitute.game_gameid=game.gameid and substitute.user_cc1=$cc and game.gamedate>CURRENT_DATE";
                            $result2 = mysqli_query($conn, $sql2);
                            $notf=mysqli_num_rows($result2);
                        ?>
                        <a href="./paginaSubstitutos.php" ><b>Pedidos Substituição *<?php echo $notf?>*</b></a>
                        <!-- <a href="#" class="scroll-link" data-id="reglog" ><b>Jogar Já</b></a> -->
                        <!-- <button type="submit" formaction="/action_page2.php">Submit to another page</button> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="text-content">
                    <h3> Próximos Jogos das tuas Equipas </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>Jogo</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Local</th>
                            
                            
                        </tr>    
                        <?php
                            // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                            // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                            $sql="SELECT game.gamedate,game.teamone,game.teamtwo,game.starttime,game.gamefield FROM game,player WHERE player.user_cc=$cc and (player.teamname=game.teamone or player.teamname=game.teamtwo) and game.gamedate>CURRENT_DATE";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    // $url="./torneioPage.php?torneio_id=".$row["tournamentid"];
                                    // echo $url;
                                    echo "<td>".$row["teamone"]." vs ".$row["teamtwo"]."</td>"."<td>".$row["gamedate"]."</td>"."<td>".$row["starttime"]."</td>"."<td>".$row["gamefield"]."</td>";
                                    // echo "<td>".$row["tournamentname"]."</td>"."<td>".$row["freespots"]."</td>"."</td>" ."<td>".$row["currentteams"]."</td>"."<td>".$row["gameweekday"]."</td>"."<td>".$row["gamestarttime"]."</td>"."<td>".$row["startdate"]."</td>"."<td>".$row["enddate"]."</td>"."<td><a  class='button' href='./torneiopage.php?torneio_id=1'>Info</a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?> 
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>