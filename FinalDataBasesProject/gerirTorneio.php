<?php

    session_start();
    require_once "connect.php";
    if(isset($_GET['edit_id'])){
        $torId = $_GET['edit_id'];
        $_SESSION['editTourId'] = $torId;
        console_log($torId);
    }

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit();
    }

    $torId =  $_SESSION['editTourId'];
    $connection = OpenCon();
    if ($connection->connect_errno != 0)
    {
        throw new Exception(mysqli_connect_errno());
    }

    $quick_cast = ($_SESSION['cc']);
    // filter by nome:

    $result4 = $connection->query("SELECT CURRENT_DATE FROM tournament");
    $row2 = mysqli_fetch_assoc($result4);
    $todayDate = $row2['CURRENT_DATE'];

    $result = $connection->query("SELECT gameid, weekday, gamedate, teamone, teamtwo, starttime, endtime, gameField from game, tournament where game.tournament_tournamentid = tournament.tournamentid=$torId and teamone is not null and teamtwo is not null and gamedate>='$todayDate'");
    $num_of_results = mysqli_num_rows($result);


    if($num_of_results>0)
    {

        echo '
        <table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                    <tr>
                        <th>Data</th>  
                        <th>Dia</th>   
                        <th>Casa</th>       
                        <th>Fora</th>                                                          
                        <th>Campo</th>   
                        <th>Horário</th>              
                    </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);


            $gameid = $row['gameid'];
            $weekday = $row['weekday'];
            $gamedate = $row['gamedate'];
            $teamone = $row['teamone'];
            $teamtwo = $row['teamtwo'];
            $starttime = $row['starttime'];
            $endtime = $row['endtime'];
            $gameField = $row['gameField'];


            echo
                '<tr>
                <td>'.$gamedate.'</td>
                <td>'.$weekday.'</td>
                <td>'.$teamone.'</td>
                <td>'.$teamtwo.'</td>   
                <td>'.$gameField.'</td>  
                <td>'.$starttime.'h  : '.$endtime.'h  </td>                                    
                </tr>';
        }

        echo '</table>';
    }else{
        echo '<br><br>';
        echo '<h2 style="color: red; position: relative; left: -70%;">Nao existem torneios, crie um agora!</h2>';
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

        <link rel="stylesheet" href="css/gerirTorneio.css">

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
      <h2 class="text-center">Gestão de torneios</h2>

        <div class="menu-esquerda2 btn-group">
            <form action="indexGestao.php">
                <button style="background-color: lightseagreen" type="submit"><- Voltar</button>
            </form>
        </div>

      <br><br>
      <div class="menu-esquerda btn-group">
          <form>
              <button type="submit" onclick="popupwindow4(300,200)">Iniciar torneio</button>
          </form>
          <form>
            <button type="submit" onclick="popupwindow5(350,250)">Gerar Jogos</button>
          </form>
          <form>
              <button type="submit" onclick="popupwindow6(450,350)">Expulsar Equipas</button>
          </form>
          <form >
              <button type="submit" onclick="popupwindow3(800,400)">Conf. Resultados</button>
          </form>

          <form >
          <button type="submit" onclick="popupwindow2(300,400)">Pedidos Equipas</button>
        </form>

        <form >
          <button type="submit" onclick="popupwindow(300,200)">Dar permissões</button>
        </form>

          <form action="adicionarDetalhes.php" method="post">
              <button type="submit">Adicionar Detalhes</button>
          </form>

      </div>

      <br>

    </div>

    <script>
        function popupwindow( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("popUpGivePermission.php", "Dar permissão a outros gestores", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }
        function popupwindow2( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("popUpRequest.php", "Pedidos de Equipas", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }

        function popupwindow3( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("confResult.php", "Conf Resultados", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }

        function popupwindow4( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("startTournament.php", "Iniciar Torneio", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }

        function popupwindow5( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("gerarJogos.php", "Gerar Jogos", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }

        function popupwindow6( w, h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            return window.open("expulsarEquipas.php", "Expulsar Equipas", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        }
    </script>


    </body>

  </html>
