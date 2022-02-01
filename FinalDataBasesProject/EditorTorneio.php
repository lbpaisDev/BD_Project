<?php

    session_start();


    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit();
    }

?>

<!DOCTYPE html>
<html>

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

      <link rel="stylesheet" href="css/criarTorneio.css">
      <link rel="stylesheet" href="css/all.css">

      <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
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
      <h2 class="text-center">Criar torneio</h2>

      <div>
      <form action="update_torneio.php" method="post">

        <b>Nome do torneio:</b>
        <label class="label">
          <input type="text" name="torneio_nome"/>
        </label>


        <b class="start_label">Data de começo:</b>
        <b class="label_fim2">Data de fim:</b>
        <br>
        <label class="start_label">
          <input type="date" name="start_date"/>
        </label>


        <label class="label_fim1">
          <input type="date" name="end_date"/>
        </label>
        <br>

        <b class="start_label">Primeiro jogo:</b>
        <b id="second_game">Segundo jogo:</b>
        <br>
        <label class="start_label">
          <select>
            <option value="segunda">Segunda</option>
            <option value="terca">Terça</option>
            <option value="quarta">Quarta</option>
            <option value="quinta">Quinta</option>
            <option value="sexta">Sexta</option>
            <option value="sabado">Domingo</option>
          </select>
        </label>


        <label class="label_fim1">
          <select>
            <option value="segunda">Segunda</option>
            <option value="terca">Terça</option>
            <option value="quarta">Quarta</option>
            <option value="quinta">Quinta</option>
            <option value="sexta">Sexta</option>
            <option value="sabado">Domingo</option>
          </select>
        </label>
        <br>

        <b>Num. máximo de equipas:</b>
        <label class="label">
          <input type="number" name="number_team"/>
        </label>

        <div class="btn-group">
          <button formaction="eliminarTorneio.php" type="submit" >Eliminar</button>
          <button formaction="indexGestao.php" type="submit" >Cancelar</button>
          <button type="submit" class="label_fim1">Criar Torneio</button>
        </div>
      </form>
      </div>

    </body>

  </html>
