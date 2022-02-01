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

      <br><br><br><br>
    <div>
        <br><br><br>
      <h2 class="text-center">Pedidos da Equipa</h2>
      <br><br>
      <div class="menu-esquerda btn-group">
      <form action="capitan_proximo.php">
          <button type="submit" class='btn'>Proximo Jogo</button>
        </form>
        <form action="capitan_resultados.php">
          <button type="submit" class='btn'>Resultados</button>
        </form>
        <form action="capitan_gestao.php">
          <button type="submit" class='btn'>Gestao do Plantel</button>
        </form>
        <form action="indexcapitan.php">
          <button type="submit" class='btn'>Dados da Equipa</button>
        </form>
      </div>
    </div>
      <?php
      $query = "SELECT  reqid,user_cc,user_name,pos FROM request_team where team_name = $teamname and accepted is NULL";
      $requests = $connection->query($query);
      $num_of_results = mysqli_num_rows($requests);
      if ($num_of_results){
          echo '<table id="Pedidos" class="mytable" style="width:30%" align="center"> <!-- style="width:70%">  -->
               <tr>
                   <th>Nome</th>
                   <th>Posicao</th>
                   <th>Decisao</th>   
               </tr>';
          for ($i = 1; $i <= $num_of_results; $i++) {
              $row = mysqli_fetch_assoc($requests);
              $usercc = $row['user_cc'];
              $username = $row['user_name'];
              $reqid = $row['reqid'];
              $pos = $row['pos'];
                echo '<tr>
                    <td>'.$username.'</td>
                    <td>'.$pos.'</td>
                    <td><div>
                        <input class="btn-success" type="button" value="Aprovar"  onclick="AcceptPlayer('.$reqid.')" style="float: left">
                        <input class="btn-danger" type="button" value="Recusar" onclick="DeleteRequest('.$reqid.')" style="float: right">
                        </td> 
                    </div>
                    </tr>';
            }
              echo '</table>';
      }
      else{
          echo '<br><br>';
          echo '<h2 style="color: red; position: relative; top: 40px;right: -43%">Nao existem Pedidos</h2>';
      }
      ?>
    </body>
    <script>
            function DeleteRequest(subjectId) {
                window.location.href = 'deleterequest.php?id=' + subjectId + '';
            }
            function AcceptPlayer(subjectId) {
                window.location.href = 'acceptrequest.php?id=' + subjectId + '';
            }

    </script>

  </html>


<?php

?>