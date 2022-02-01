<?php

	session_start();
    require_once "connect.php";
    $cc = $_SESSION['cc'];
    $connection = OpenCon();
    $resp = $connection->query("SELECT team_teamname FROM captain_team where user_cc = $cc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];

    require_once "connect.php";
    $connection = OpenCon();

    if ($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    $sql="SELECT team_gk,team_def1,team_def2,team_def3,team_def4,team_med1,team_med2,team_med3,team_ava1,team_ava2,team_ava3,team_sub_gk,team_sub_def,team_sub_med,team_sub_ava,team_sub_ava1 FROM captain_team where team_teamname like '$teamname'";
    $result = mysqli_query($connection, $sql);
    $team=mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>

    <!--Header -->
    <!--References all css and js usages-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-Uto be mysqli_result, bool given inA-Compatible" content="IE=edge,chrome=1">
        <title>FOOTBALLERS'R'US</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Page Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

        <!-- Styling -->
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/capitan_pedidos.css">
        <link rel="stylesheet" href="css/userNLStyle.css">

        <!--Scripts-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

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
                      <a href="indexcapitan.php" class="scroll-top">A minha equipa</a>
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
      <div class="parallax-content baner-content">
          <div class="container">
              <div>
                  <div class="text-content" style="position:relative; bottom:100px;!important">
                      <h2 style="position: relative;top: -60px;">
                          <?php
                          echo "<em>Proximo Jogo ".$teamname."</em>";
                          ?>
                          <!-- <em>Plantel</em> -->
                      </h2>
                      <div>
                          <div class="col-lg-2" style="position:relative; left:14%;!important;">
                              <div class="text-content">
                                  <h3><b>Titulares</b></h3>
                                  <br>
                                  <table class="table">
                                      <tr>
                                          <th>Guarda Redes</th>
                                          <td><?php echo $team['team_gk']?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa</th>
                                          <td><?php echo $team['team_def1']?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa</th>
                                          <td><?php echo $team['team_def2']?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa</th>
                                          <td><?php echo $team['team_def3']?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa</th>
                                          <td><?php echo $team['team_def4']?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio</th>
                                          <td><?php echo $team['team_med1']?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio</th>
                                          <td><?php echo $team['team_med2']?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio</th>
                                          <td><?php echo $team['team_med3']?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado</th>
                                          <td><?php echo $team['team_ava1']?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado</th>
                                          <td><?php echo $team['team_ava2']?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado</th>
                                          <td><?php echo $team['team_ava3']?></td>
                                      </tr>
                                  </table>
                              </div>
                          </div>

                          <div>
                              <div class="col-lg-2" style="position:relative; left:14%;!important;">
                                  <div class="text-content">
                                      <h3><b>Suplentes</b></h3>
                                      <br>
                                      <table class="table">
                                          <tr>
                                              <th >Guarda Redes</th>
                                              <td><?php echo $team['team_sub_gk']?></td>
                                          </tr>
                                          <tr>
                                              <th>Defesa</th>
                                              <td><?php echo $team['team_sub_def']?></td>
                                          </tr>
                                          <tr>
                                              <th>Medio</th>
                                              <td><?php echo $team['team_sub_med']?></td>
                                          </tr>
                                          <tr>
                                              <th>Avancado</th>
                                              <td><?php echo $team['team_sub_ava']?></td>
                                          </tr>
                                          <tr>
                                              <th>Avancado</th>
                                              <td><?php echo $team['team_sub_ava1']?></td>
                                          </tr>
                                      </table>
                          </div>
                      </div>
                  </div>
              </div>

                      <br><br><br><br>
      <div class="menu-esquerda btn-group" style="position:relative;left: -85%;top: 30px;">
      <form action="capitan_proximo.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Proximo Jogo</button>
        </form>
        <form action="capitan_gestao.php">
            <button type="submit" class='btn' style="margin-bottom: 10px;">Gestao de Equipa</button>
        </form>
        <form action="capitan_resultados.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Resultados</button>
        </form>
          <form action="capitan_pedidos.php">
              <button type="submit" class='btn' style="margin-bottom: 10px;">Pedidos Entrada</button>
          </form>
      </div>
      <?php
            $result = $connection->query("SELECT tournament_tournamentid from captain_team WHERE captain_team.team_teamname = '$teamname'");
            $row = mysqli_fetch_assoc($result);
            $tid= $row['tournament_tournamentid'];
            if(is_numeric($tid)) {
                $teams = $connection->query("SELECT team_teamname,team_points,team_goalssuffered,team_goalsscored,team_victories,team_draws,team_defeats,team_ngames FROM captain_team INNER JOIN tournament ON tournament.tournamentid = captain_team.tournament_tournamentid and tournament.tournamentid=$tid ORDER BY captain_team.team_points DESC");
                $num = mysqli_num_rows($teams);
            }
            if(isset($num) and $num > 0){
                echo '<table id="Classificacao" class="mytable"> <!-- style="width:70%">  -->
                       <tr>
                       <div class="text-content" style="position:relative; bottom:100px;!important">
                      <h2 style="position: relative;bottom: 230px;left: 350px;">Classificacao</h2>
                           <th>Equipa</th>
                           <th>Pontos</th>
                           <th>Jogos Feitos</th>
                           <th>Vitorias</th>
                           <th>Empates</th>
                           <th>Derrotas</th>
                           <th>Golos Marcados</th> 
                           <th>Golos Sofridos</th>   
                       </tr>';
                for ($i = 1;$i <=  $num ;$i++){
                    $row = mysqli_fetch_assoc($teams);
                    $name= $row['team_teamname'];
                    $points = $row['team_points'];
                    $vic = $row['team_victories'];
                    $draws = $row['team_draws'];
                    $defeats = $row['team_defeats'];
                    $ngames = $row['team_ngames'];
                    $suf = $row['team_goalssuffered'];
                    $scor = $row['team_goalsscored'];
                    echo
                        '<tr>
                       <td>'.$name.'</td>
                       <td>'.$points.'</td>
                       <td>'.$vic.'</td>
                       <td>'.$draws.'</td> 
                       <td>'.$defeats.'</td> 
                       <td>'.$ngames.'</td> 
                       <td>'.$scor.'</td> 
                       <td>'.$suf.'</td> 
                       </tr>';
                }
                echo '</table>';
            }else {
                echo '<br><br>';
                echo '<h2 style="color: red; position: relative; left: -70%;">Classificacao Nao Encontrada</h2>';
            }
            ?>
    </body>

  </html>


<?php
  
?>