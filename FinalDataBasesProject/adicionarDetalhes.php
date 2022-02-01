<?php

session_start();

    if (!isset($_SESSION['loggedin']))
    {
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";
    $todo = $_SESSION['editTourId'];
    console_log($todo);

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

    <link rel="stylesheet" href="css/adicionarDetalhes.css">


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
                        <a href="indexGestao.php" class="scroll-top">Gestão</a>
                    </li>
                    <li>
                        <a href="CriarTorneio.php" class="scroll-link" data-id="torneios">Criar torneio</a>
                    </li>
                    <li>
                        <a href="#" class="scroll-link" data-id="Logout">Logout</a>
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
<h2 class="text-center">Adicionar detalhes ao torneio</h2>

<div class="spot">
    <form method="post" >
        <h5><b class="titles">Adicione os detalhes</b></h5>


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


        <div class="btn-group botones">
            <button type="submit" name="add_stuff" class="leButton">Adicionar</button>
        </div>

        </label>
    </form>
</div>


<form method="post">
    <div class="goback btn-group">
        <button formaction="gerirTorneio.php" type="submit" class="leButton">Voltar</button>
    </div>
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

</body>

</html>


<?php



require_once "connect.php";


    $dia_semana = "";
    $start_hour = "";
    $end_hour = "";
    $errors = array();


    // connect to the database
    $db = OpenCon();

    $search = $db->query("SELECT alreadystarted from tournament WHERE tournamentid=$todo");
    $leRow = mysqli_fetch_assoc($search);
    $alreadyStarted = $leRow['alreadystarted'];

    if($alreadyStarted=='1'){
        echo '<h1 style="color: red; position: absolute; top: 20%;right: 35%;">O torneio já começou!</h1>';
        echo '<h5 style="color: red; position: absolute; top: 79%;right: 47%;">Clique em voltar</h5>';
        echo '<script type="text/javascript">';
        echo 'alert("O torneio já começou por isso nao vai conseguir inserir nenhum dado na base de dados!")';
        echo '</script>';
    }else {

        if (isset($_POST['add_stuff'])) {

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
                    $query = "INSERT INTO tournamentdetails (gameweekday, gamestarttime,gamefield, gameendtime, tournament_tournamentid) VALUES ('$dia_semana', $primeira_hora, '$nome_campo', $segunda_hora, $todo)";
                    $resp = mysqli_query($db, $query);

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

            // receive all input values from the form
            $noPlay = mysqli_real_escape_string($db, $_POST['noPlay']);

            $quick_cast = ($_SESSION['cc']);
            $query = "INSERT INTO dates (nocontestdate, tournament_tournamentid) VALUES ('$noPlay',$todo)";
            $resp = mysqli_query($db, $query);

            if ($resp == true) {
                echo "<p id='things' class='errosPos4' style='text-align: center; line-height: 0.7; color: greenyellow;'><b>Informação adicionada com sucesso</b></p>";
            } else {
                echo "<p id='things' class='errosPos4' style='text-align: center; line-height: 0.7; color: red;'><b>Ja adicionou essa data</b></p>";
            }

        }

?>
