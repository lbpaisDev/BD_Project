<!-- BackEnd PhP-->
<?php 
include('../backEnd/credentialsCheck.php');
// $cc=$_SESSION['cc'];
// session_start();

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}
if(isset($_GET['t_name'])){
    $teamname = $_GET['t_name'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}
$cc=$_SESSION['cc'];

$sql="SELECT team_gk,team_def1,team_def2,team_def3,team_def4,team_med1,team_med2,team_med3,team_ava1,team_ava2,team_ava3,team_sub_gk,team_sub_def,team_sub_med,team_sub_ava,team_sub_ava1 FROM captain_team WHERE tournament_tournamentid=$torId and team_teamname like '$teamname'";
$result = mysqli_query($conn, $sql);
$team=mysqli_fetch_assoc($result);

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
    <div class="parallax-content baner-content" id="home" style="position:relative;bottom:30px">
        <div class="container" style="position:relative;bottom:50px" >
            <h2>
                    <!-- <em>Menu</em> -->
                    <?php
                    echo "<em>".$teamname."</em>";
                    ?>
            </h2>
        </div>

        <div class="container">

            <div class="col-lg-5">
                <div class="text-content">
                    <h3> Gerir Disponibilidade </h3>
                    <br>
                    <table class="table">
                        <tr>
                            <th>Jogo</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Disponibilidade</th>
                            <th>Gerir</th>
                            
                        </tr>
                        <?php
                            // verificar se cada jogo tem uma tabela disponibilidade de cada player
                            // SELECT game.gameid from game, playergameavailable WHERE game.tournament_tournamentid=1 and playergameavailable.game_gameid!=game.gameid and playergameavailable.user_cc=123456789
                            $query="SELECT game.gameid from game where game.gameid not in (SELECT playergameavailable.game_gameid from playergameavailable WHERE playergameavailable.user_cc=$cc) and game.tournament_tournamentid=$torId";
                            $result = mysqli_query($conn, $query);
                            if(mysqli_num_rows($result) > 0){
                                // adicionar a tabela playergameavailable para cada jogo do jogador
                                while($row = mysqli_fetch_assoc($result)){
                                    $gameId=$row['gameid'];
                                    $query1="INSERT INTO `playergameavailable` (`availableid`, `isavailable`, `user_cc`, `game_gameid`) VALUES (NULL, NULL, '$cc', '$gameId');";
                                    if ($conn->query($query1)) {
                                        $_SESSION['registration_success'] = true;
                                        $_SESSION['loggedin'] = true;
                                    } else {
                                        throw new Exception($conn->error);
                                    }
                                }
                            }

                            // display dos jogos da equipa
                            $sql="SELECT game.gameid,game.gamedate,game.teamone,game.teamtwo, game.starttime,playergameavailable.isavailable,player.position,playergameavailable.availableid,player.user_cc FROM game,player,playergameavailable WHERE player.user_cc=$cc and game.gamedate>CURRENT_DATE and player.teamname like '$teamname' and playergameavailable.game_gameid=game.gameid and playergameavailable.user_cc=$cc";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    $url="./disponibilidade.php?t_name=".$teamname."&game_id=".$row["gameid"]."&available_id=".$row["availableid"];
                                    // echo $url;
                                    if($row['isavailable']==1){
                                        $dispobilidade="Vou";
                                    }
                                    else if($row['isavailable']==NULL){
                                        $dispobilidade="Sem Resposta";
                                    }
                                    else{
                                        $dispobilidade="Não Vou";
                                    }
                                    echo "<td>".$row["teamone"]." vs ".$row["teamtwo"]."</td>"."<td>".$row["gamedate"]."</td>"."<td>".$row["starttime"]."</td>"."<td>".$dispobilidade."</td>"."<td><a class='button' href='".$url."'><b>Gerir</b></a></td>";
                                    // echo "<td>".$row["tournamentname"]."</td>"."<td>".$row["freespots"]."</td>"."</td>" ."<td>".$row["currentteams"]."</td>"."<td>".$row["gameweekday"]."</td>"."<td>".$row["gamestarttime"]."</td>"."<td>".$row["startdate"]."</td>"."<td>".$row["enddate"]."</td>"."<td><a  class='button' href='./torneiopage.php?torneio_id=1'>Info</a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>     
                        
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="text-content" style="position:relative; left:10%">
                <h3><b>Titulares</b></h3>
                        <br>
                        <table class="table">
                            <tr>
                                <th>GR</th>
                                <td><?php echo $team['team_gk']?></td>
                            </tr>    
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def1']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def2']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def3']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def4']?></td>
                            </tr>   
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med1']?></td>
                            </tr>   
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med2']?></td>
                            </tr>
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med3']?></td>
                            </tr>    
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava1']?></td>
                            </tr>  
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava2']?></td>
                            </tr> 
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava3']?></td>
                            </tr>     
                        </table>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="text-content" style="position:relative;left:10%">
                <h3><b>Suplentes</b></h3>
                        <br>
                        <table class="table">
                            <tr>
                                <td><?php echo $team['team_sub_gk']?></td>
                            </tr>    
                            <tr>
                                <td><?php echo $team['team_sub_def']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_med']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_ava']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_ava1']?></td>
                            </tr>      
                        </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>