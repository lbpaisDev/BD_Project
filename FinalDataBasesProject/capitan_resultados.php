<?php

    session_start();
    require_once "connect.php";
    $connection = OpenCon();

    if ($connection->connect_errno!=0) {
        echo "Error: " . $connection->connect_errno;
    }
    $capcc = $_SESSION['cc'];
    $resp = $connection->query("SELECT team_teamname FROM captain_team where user_cc = $capcc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];

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
        <link rel="stylesheet" href="css/capitan_resultados.css">
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
              <a href="#" class="navbar-brand scroll-top">
                <em>FOOT</em>
                <span>'R'</span>US</a>
            </div>

            <!--/Nav options-->
            <div id="main-nav" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li>
                  <a href="#" class="scroll-top">Gestao</a>
                </li>
                <li><!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog"
   aria-labelledby = "myModalLabel" aria-hidden = "true">

   <div class = "modal-dialog">
      <div class = "modal-content">

         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>

            <h4 class = "modal-title" id = "myModalLabel">
               This Modal title
            </h4>
         </div>

         <div class = "modal-body">
            Add some text here
         </div>

         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Close
            </button>

            <button type = "button" class = "btn btn-primary">
               Submit changes
            </button>
         </div>

      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->

</div><!-- /.modal -->
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

      <br><br><br><br>
    <div>
      <h2 class="text-center">Resultados da Equipa</h2>

      <br><br>
      <div class="menu-esquerda btn-group">
      <form action="capitan_proximo.php">
          <button type="submit" class='btn'>Proximo Jogo</button>
        </form>
        <form action="capitan_gestao.php">
          <button type="submit" class='btn'>Gestao de Plantel</button>
        </form>
        <form action="capitan_pedidos.php">
          <button type="submit" class='btn'>Pedidos Entrada</button>
        </form>
        <form action="indexcapitan.php">
          <button type="submit" class='btn'>Dados da Equipa</button>
        </form>
      </div>
    </div>
      <?php
      $sql = "SELECT teamone,teamtwo,gamefield,gameid,gamedate FROM game WHERE (teamone = '$teamname' OR teamtwo = '$teamname') AND check_game IS NULL  AND gamedate < CURRENT_DATE  ORDER BY game.gamedate ASC ";
      $result = $db->query($sql);
      if($result){
          $num_of_results = mysqli_num_rows($result);

            echo '<table id="Table" class="mytable" style="right: 40%;"> <!-- style="width:70%">  -->
                <caption>Jogos sem Resultado</caption>
                <tr>
                    <th style="text-align: center">Equipa</th>
                    <th style="text-align: center">Oponente</th>
                    <th style="text-align: center">Campo</th>
                    <th style="text-align: center">Data do Jogo</th>
                    <th style="text-align: center">Adicionar Resultado</th>   
                </tr>';

            for ($i = 1;$i <=  $num_of_results ;$i++){
                $row = mysqli_fetch_assoc($result);
                $teamone = $row['teamone'];
                $teamtwo = $row['teamtwo'];
                $field = $row['gamefield'];
                $gameid = $row['gameid'];
                $gamedate = $row['gamedate'];
                echo '<tr>
                    <td>'.$teamone.'</td>
                    <td>'.$teamtwo.'</td>
                    <td>'.$field.'</td>
                    <td>'.$gamedate.'</td>
                    <td><input class="btn-success" type="button" value="Adicionar Resultado" onclick="addresultado('.$gameid.' )"></td>
                    </tr>';
            }
          echo '</table>';
        }

      $sql = "SELECT teamone,teamtwo,goalsteam1manager,goalsteam2manager FROM game WHERE (teamone = '$teamname' OR teamtwo = '$teamname') AND check_game = 1 ";
      $result = $db->query($sql);
      if($result){
          $num_of_results = mysqli_num_rows($result);
          echo '<table id="Resultados2" class="mytable" style="right: 40%;"> <!-- style="width:70%">  -->
                <tr>
                    <th style="text-align: center">Equipa</th>
                    <th style="text-align: center">Oponente</th>
                    <th style="text-align: center">Resultado</th>
                </tr>';

          for ($i = 1;$i <=  $num_of_results ;$i++){
              $row = mysqli_fetch_assoc($result);
              $teamone = $row['teamone'];
              $teamtwo = $row['teamtwo'];
              $teamonegoals = $row['goalsteam1manager'];
              $teamtwogoals = $row['goalsteam2manager'];
              echo '<tr>
                    <td>'.$teamone.'</td>
                    <td>'.$teamtwo.'</td>
                    <td>'.$teamonegoals.' - '.$teamtwogoals.'</td>
                    </tr>';
          }
          echo '</table>';
      }
      ?>

    </body>
    <script>
        function addresultado(subjectid) {
            window.location.href = 'addresult.php?id=' + subjectid + '';
        }
    </script>
  </html>


