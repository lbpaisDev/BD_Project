<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}

// $sql = "SELECT username,name, email, contact, password FROM `user` where cc=$_SESSION[cc]";
// $sql = "SELECT `tournamentname` FROM `tournament` where `tournamentid`=$torId";
$sql="SELECT tournament.tournamentid,tournament.tournamentname, tournament.startdate, tournament.enddate, tournamentdetails.gameweekday, tournamentdetails.gamestarttime from tournament, tournamentdetails WHERE tournamentdetails.tournament_tournamentid=tournament.tournamentid and tournament.tournamentid=$torId";
$result = mysqli_query($conn, $sql);
$torneio=mysqli_fetch_assoc($result);
$urlCriarEquipa="./criarEquipa.php?torneio_id=".$torId;
$urlEntrarEquipa="./entrarEquipa.php?torneio_id=".$torId;
$urlReservaTorneio= "./inscreverReserva.php?torneio_id=".$torId;
$urlMarcadoresTorneio= "./marcadoresTorneio.php?torneio_id=".$torId;
$_SESSION["variavel"]="Teste";

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

    <script>
        function popupwindow(url, title, w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }

        function pageResult(){
            window.location.replace("./resultadosTorneio.php?torneio_id=<?php echo $torId?>");
        }

        function pageReserva(){
            // $urlReservaTorneio= "./inscreverReserva.php?torneio_id=".$torId;
            window.location.replace("./inscreverReserva.php?torneio_id=<?php echo $torId?>");
        }
        function pageMarcadores(){
            // $urlReservaTorneio= "./inscreverReserva.php?torneio_id=".$torId;
            window.location.replace("./marcadoresTorneio.php?torneio_id=<?php echo $torId?>");
        }

    </script>

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
                            <a href="../backEnd/checkTeam.php"><b>Home</b></a>
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
            <!-- <div class="col-lg-4">
            <p>So teste </p>
            </div> -->
            <div>
                <h2>
                    <em><?php
                        echo $torneio["tournamentname"];
                    ?></em>
                </h2> 
            </div>

            <div class="col-lg-2" style="position:relative;left:-10%">
                <div class="text-content">
                    <button class="button" style="border:2px solid white" onclick="popupwindow('<?php echo $urlEntrarEquipa; ?>','Home',500,500)"  > <b>Entrar Equipa</b> </button>
                    <br>
                    <button class="button" style="border:2px solid white" onclick="popupwindow('<?php echo $urlCriarEquipa; ?>','Home',500,500)"> <b>Criar Equipa</b> </button>
                    <br>
                    <button class="button" style="border:2px solid white" onclick="pageResult();"> <b>Resultados Torneio</b> </button>
                    <br>
                    <button class="button" style="border:2px solid white" onclick="pageMarcadores();"> <b>Melhores Marcadores</b> </button>
                    <br>
                    <button class="button" style="border:2px solid white" onclick="pageReserva();"> <b>Reservas Torneio</b> </button>
                </div>
            </div>

            <div class="col-lg-6" style="position:relative; right:10%">
                <div class="text-content">
                    <h3> Classificações </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>Equipas</th>
                            <th>Jogos</th>
                            <th>Pontos</th>
                            <th>Vitórias</th>
                            <th>Empates</th>
                            <th>Derrotas</th>
                            <th>Ver Plantel</th>
                        </tr>    
                        <?php
                            // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                            // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                            // $sql1="SELECT `team_teamname`,`team_points`,`team_ngames`,`team_victories`,`team_draws`,`team_defeats` FROM `captain_team` WHERE `tournament_tournamentid`=$torId Order by 2";
                            $sql1="SELECT team_teamname,team_points,team_ngames,team_victories,team_draws,team_defeats FROM captain_team,request WHERE request.tournament_tournamentid=captain_team.tournament_tournamentid and captain_team.tournament_tournamentid=$torId and captain_team.team_teamname=request.teamname and request.accepted='1' order by 2 desc";
                            $result1 = mysqli_query($conn, $sql1);
                            
                            if (mysqli_num_rows($result1) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result1)) {
                                    echo "<tr>";
                                    $url="./plantel.php?torneio_id=".$torId."&t_name=".$row["team_teamname"];
                                    echo "<td>".$row["team_teamname"]."</td>"."<td>".$row["team_ngames"]."</td>"."</td>" ."<td>".$row["team_points"]."</td>"."<td>".$row["team_victories"]."</td>"."<td>".$row["team_draws"]."</td>"."<td>".$row["team_defeats"]."</td>"."<td><a class='button' href='".$url."'><b>Plantel</b></a></td>";
                                    // echo "<td>".$row["team_teamname"]."</td>"."<td>".$row["team_ngames"]."</td>"."</td>" ."<td>".$row["team_points"]."</td>"."<td>".$row["team_victories"]."</td>"."<td>".$row["team_draws"]."</td>"."<td>".$row["team_defeats"]."</td>"."<td><a class='button' href='javascript:popupwindow(".$url.",'Home',500,500);'><b>Plantel</b></a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>  
                    </table>
                </div>
            </div>
            <div class="col-lg-2" style="position:relative; right:5%">
                <div class="text-content">
                    <h3> Informações Torneio </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>Jogos</th>
                            <td><?php echo $torneio["gameweekday"]?></td>
                        </tr>    
                        <tr>
                            <th>Horas</th>
                            <td><?php echo $torneio["gamestarttime"]."H"?></td>
                        </tr>
                        <tr>
                            <th>Desde</th>
                            <td><?php echo $torneio["startdate"]?></td>
                        </tr> 
                        <tr>
                            <th>Até</th>
                            <td><?php echo $torneio["enddate"]?></td>
                        </tr>   
                    </table>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="text-content">
                    <h3> Reservas Torneio </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>UserName</th>
                            <th>Nome</th>
                        </tr>
                        <?php
                            // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                            // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                            $sql="SELECT reservastorneio.user_cc,user.username,user.name from reservastorneio,user where reservastorneio.tournament_tournamentid=$torId and reservastorneio.user_cc=user.cc";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>".$row["username"]."</td>"."<td>".$row["name"]."</td>";
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