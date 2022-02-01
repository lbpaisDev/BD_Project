<?php

    session_start();

    if (!isset($_SESSION['loggedin']))
    {
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

      <br><br><br>
      <h2 class="text-center">Criar torneio</h2>

      <div id="lala">
      <form method="post" id="formi">

        <b class="titles">Nome do torneio:</b>
        <label class="label">
          <input type="text" name="nome_torneio" placeholder="Nome do torneio"/>
        </label>


        <b class="start_label titles">Data de começo:</b>
        <b class="label_fim2 titles">Data de fim:</b>
        <br>
        <label class="start_label">
          <input type="date" name="start_date"/>
        </label>


        <label class="label_fim1">
          <input type="date" name="end_date"/>
        </label>


          <br>
        <b class="titles">Num. máximo de equipas:</b>
        <label class="label">
          <input type="number" name="number_max" placeholder="Número maximo de equipas"/>
        </label>

        <div class="btn-group botones">
          <button id="boto2" type="submit" name="criar" class="leButton">Criar Torneio</button>
        </div>
      </form>
      </div>


      <div class="spot">
          <form method="post" >
          <h5><b class="titles">Depois de criar o torneio adicione os detalhes</b></h5>


          <p>Horário de jogo:</p>
          <b>Dia:</b>

          <label>
              <select name="dias">
                  <option value="Domingo">Domingo</option>
                  <option value="Segunda">Segunda</option>
                  <option value="Terca">Terça</option>
                  <option value="Quarta">Quarta</option>
                  <option value="Quinta">Quinta</option>
                  <option value="Sexta">Sexta</option>
                  <option value="Sabado">Sabado</option>
              </select>
          </label>

          <b class="dual-pad">Das</b>
          <label>
              <select name="primeira_hora" class="hora">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12" >12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
              </select>
          </label>
          <b>H</b>
          <b class="dual-pad">ate</b>

          <label>
              <select name="segunda_hora" class="hora">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12" >12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
              </select>
          </label>
              <b>H</b>

              <p>Nome do campo:</p>
              <label >
                  <input style="color: #0f0f0f" type="text" name="nome_campo" placeholder="Nome do Campo"/>
              </label>
              <label>

          <label

                  <div class="btn-group botones">
                      <button type="submit" name="add_stuff" class="leButton">Adicionar</button>
                  </div>

          </label>
              </form>

          <div class="spot3">
              <form method="post" >
                  <p class="titles">Datas em que nao pode haver jogo:</p>
                  <label >
                      <input style="color: #0f0f0f" type="date" name="noPlay"/>
                  </label>
                  <label>

                      <div class="btn-group botones">
                          <button style="background-color: red" type="submit" name="add_stuff3" class="leButton">Adicionar</button>
                      </div>

                  </label>
              </form>
          </div>

      <form method="post">
          <div class="goback btn-group">
              <button style="background-color: lightseagreen;" formaction="indexGestao.php" type="submit" class="leButton">Voltar</button>
          </div>
      </form>

    </body>

  </html>


<?php



    require_once "connect.php";
    // initializing variables
    $nome_torneio = "";
    $start_date    = "";
    $end_date    = "";
    $number_max = "";
    $errors = array();

    // connect to the database
    $db = OpenCon();

    // REGISTER USER
    if (isset($_POST['criar'])) {
        // receive all input values from the form
        $nome_torneio = mysqli_real_escape_string($db, $_POST['nome_torneio']);
        $start_date = mysqli_real_escape_string($db, $_POST['start_date']);
        if(trim($start_date)==''){
            $start_date=NULL;
        }


        $end_date = mysqli_real_escape_string($db, $_POST['end_date']);
        if(trim($end_date)==''){
            $end_date=NULL;
        }

        //numero maximo equipas
        $number_max = trim(mysqli_real_escape_string($db, $_POST['number_max']));

        //verificar que o torneio dura 1 mes
        $diff = abs(strtotime($start_date) - strtotime($end_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

        //data de hoje
        $result = $db->query("SELECT CURRENT_DATE FROM tournament");
        $row = mysqli_fetch_assoc($result);
        $todayDate = $row['CURRENT_DATE'];
        console_log($todayDate);

        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($nome_torneio)) { array_push($errors, "Nome torneio is required"); }
        if (is_null($start_date)) { array_push($errors, "Start date is null"); }
        if (is_null($end_date)) {array_push($errors, "End date is null"); }else{if($start_date<$todayDate or $end_date < $todayDate){ array_push($errors, "Inseriu uma data passada");}}
        if($months<1){ array_push($errors, "O torneio tem de durar no minimo 1 mes");}
        if ($end_date < $start_date) { array_push($errors, "A data de término tem de ser depois da data de começo"); }
        if (is_null($number_max) || $number_max < 2) { array_push($errors, "O torneio tem de ter pelo menos duas equipas"); }
        echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) {
            console_log("cheguei aqui");
            $quick_cast = ($_SESSION['cc']);
            console_log($quick_cast);
            console_log($quick_cast);
            $start_date = date("Y-m-d", strtotime($start_date));
            console_log($start_date);
            //$query = "INSERT INTO tournament (tourname, startdate, finishdate,maxequipas,issegunda,isterca,isquarta,isquinta, issexta, issabado, isdomingo,vagas,startHora,endHora, user_cc) VALUES ('$nome_torneio','$start_date', '$end_date', $number_max, $segunda, $terca, $quarta, $quinta, $sexta, $sabado, $domingo, $number_max,$primeira_hora,$segunda_hora, $quick_cast)";
            $query = "INSERT INTO tournament ( tournamentname, classificationtable, creationdate, startdate, enddate, maxteams, currentteams, freespots, user_cc) VALUES ('$nome_torneio', null, CURRENT_TIMESTAMP, '$start_date', '$end_date', $number_max, 0, $number_max, $quick_cast )";
            mysqli_query($db, $query);

            $result = $db->query("SELECT tournamentid from tournament where tournamentname='$nome_torneio' and startdate='$start_date' and enddate='$end_date' and maxteams=$number_max");
            $row = mysqli_fetch_assoc($result);
            $_SESSION['last_created_tournament'] = $row['tournamentid'];
            console_log($_SESSION['last_created_tournament']);

            echo "<p id='things' class='errosPos' style='text-align: center; line-height: 0.7; color: greenyellow;'><b>Torneio criado com secesso!</b></p>";
        }



        echo "<div id='things' class='errosPos'>";
        foreach ($errors as $error) {
            echo "<p class='erros' style='text-align: center; line-height: 0.7; color: red;'><b>$error</b></p>";

        }
        echo "</div>";

        // initializing variables
        $nome_torneio = "";
        $start_date    = "";
        $end_date    = "";
        $number_max = "";
        $errors = array();

        $dia_semana = "";
        $start_hour = "";
        $end_hour = "";
        $errors = array();

    }





    if(isset($_POST['add_stuff'])){


        if(!isset($_SESSION['last_created_tournament'])) {
            echo '<h2 style="color: red; position:absolute; top: 10%;">Crie o torneio primeiro!</h2>';
        }else {

            $dia_semana = mysqli_real_escape_string($db, $_POST['dias']);
            $primeira_hora = trim(mysqli_real_escape_string($db, $_POST['primeira_hora']));
            $segunda_hora = trim(mysqli_real_escape_string($db, $_POST['segunda_hora']));
            // receive all input values from the form
            $nome_campo = mysqli_real_escape_string($db, $_POST['nome_campo']);
            console_log($nome_campo);

            console_log($dia_semana);
            console_log($primeira_hora);
            console_log($segunda_hora);

            if ($primeira_hora === $segunda_hora) {
                array_push($errors, "A hora de começo e termino têm de ser diferentes");
            }
            // Finally, register user if there are no errors in the form

            if (count($errors) == 0) {
                $quick_cast = ($_SESSION['cc']);
                $quick_cast2 = $_SESSION['last_created_tournament'];
                $query = "INSERT INTO tournamentdetails (gameweekday, gamestarttime,gamefield, gameendtime, tournament_tournamentid) VALUES ('$dia_semana', $primeira_hora, '$nome_campo', $segunda_hora, $quick_cast2)";
                $resp = mysqli_query($db, $query);
                console_log($quick_cast2);

                if ($resp == true) {
                    echo "<p id='things' class='errosPos2' style='text-align: center; line-height: 0.7; color: greenyellow;'><b>Informação adicionada com sucesso</b></p>";
                } else {
                    echo "<p id='things' class='errosPos2' style='text-align: center; line-height: 0.7; color: red;'><b>Insira os campos corretamente!</b></p>";
                }
            }

            $dia_semana = "";
            $start_hour = "";
            $end_hour = "";
            $errors = array();
        }

    }


        // REGISTER USER
        if (isset($_POST['add_stuff3'])) {
            if(!isset($_SESSION['last_created_tournament'])) {
                echo '<h2 style="color: red; position:absolute; top: 10%;">Crie o torneio primeiro!</h2>';
            }else {
                // receive all input values from the form
                $noPlay = mysqli_real_escape_string($db, $_POST['noPlay']);

                $quick_cast = ($_SESSION['cc']);
                $quick_cast2 = $_SESSION['last_created_tournament'];
                console_log($quick_cast2);
                $query = "INSERT INTO dates (nocontestdate, tournament_tournamentid) VALUES ('$noPlay',$quick_cast2)";
                $resp = mysqli_query($db, $query);

                if ($resp == true) {
                    echo "<p id='things' class='errosPos4' style='text-align: center; line-height: 0.7; color: greenyellow;'><b>Informação adicionada com sucesso</b></p>";
                } else {
                    echo "<p id='things' class='errosPos4' style='text-align: center; line-height: 0.7; color: red;'><b>Ja adicionou essa data</b></p>";
                }
            }
        }
?>
