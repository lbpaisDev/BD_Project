<?php

    session_start();
    require_once "connect.php";
    $connection = OpenCon();

    if ($connection->connect_errno!=0) {
        echo "Error: " . $connection->connect_errno;
    }
    $capcc = $_SESSION['cc'];
    $resp = $db->query("SELECT team_teamname FROM captain_team where user_cc = $capcc");
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
        <link rel="stylesheet" href="css/userNLStyle.css">
        <link rel="stylesheet" href="css/capitan_gestao.css">

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
      <h2 class="text-center">Gestao de Plantel</h2>

      <br><br>
      <div class="menu-esquerda btn-group">
      <form action="capitan_proximo.php">
          <button type="submit" class='btn' >Proximo Jogo</button>
        </form>
        <form action="capitan_resultados.php">
          <button type="submit" class='btn'>Resultados</button>
        </form>
        <form action="capitan_pedidos.php">
          <button type="submit" class='btn'>Pedidos Entrada</button>
        </form>
        <form action="indexcapitan.php">
          <button type="submit" class='btn'>Dados Equipa</button>
        </form>
      </div>
    </div>
      <?php
      $query = "SELECT callnumber,position,user_cc,balance FROM player where teamname='$teamname' and player.isvisible = 1";
      $requests = $connection->query($query);
      $num_of_results = mysqli_num_rows($requests);

      if($requests) {
          echo '<table id="Table" class="mytable" style="width:75%"> <!-- style="width:70%">  -->
                <tr><td align="left" style="text-align: center"><b>Nome</b></td>
                     <td align="left" style="text-align: center"><b>Contact</b></td>
                     <td align="left" style="text-align: center"><b>Posicao</b></td>
                     <td align="left" style="text-align: center"><b>Saldo</b></td>
                     <td align="left" style="text-align: center"><b>Adicionar Saldo</b></td>
                     <td align="left" style="text-align: center"><b>Capitao</b></td>
                     <td align="left" style="text-align: center"><b>Expulsar</b></td></tr>';
          for ($i = 1; $i <= $num_of_results; $i++) {
              $row = mysqli_fetch_assoc($requests);
              $callnumber = $row['callnumber'];
              $position= $row['position'];
              $cc = $row['user_cc'];
              $balance = $row['balance'];
              $query = "SELECT name from user where cc =  $cc";
              $result = $connection->query($query);
              $row = mysqli_fetch_assoc($result);
              $name = $row['name'];



              echo '<tr>
                    <td>'.$name.'</td>
                    <td>'.$callnumber.'</td>
                    <td>'.$position.'</td>
                    <td>'.$balance.'</td>
                    <td><input class="btn-info" type="button" value="Adicionar Saldo" style="width:120px" onclick="addMoney('.$cc.' )"></td>
                    <td><input class="btn-toolbar" type="button" value="Nomear Capitao" onclick="confirmCapitan('.$cc.')"></td> 
                    <td><input class="btn-danger" type="button" value="Expulsar" onclick="confirmDelete('.$cc.')"></td> 
                    </tr>';
          }

          echo '</table>';
      }else{
          echo '<br><br>';
          echo '<h2 style="color: red; position: relative; top: 40px;right: -43%">A sua Equipa nao tem Jogadores</h2>';
      }
        ?>

    </body>

    <script>
        function confirmDelete(subjectcc) {
            if (confirm("Tens a certeza que queres remover este jogador da tua equipa?")) {
                window.location.href = 'deleteplayer.php?cc=' + subjectcc + '';
            }

        }
        function confirmCapitan(subjectcc) {
            if (confirm("Are you sure you want to make this User has the new Capitan")) {
                window.location.href = 'newcapitan.php?cc=' + subjectcc + '';
            }
        }
        function addMoney(subjectcc,) {
            if (confirm("Are you sure you want to add money to the user?")) {
                window.location.href = 'addmoney.php?cc=' + subjectcc + '';
            }
        }
    </script>


</html>