<?php

	session_start();

	if (!isset($_SESSION['loggedin']))
	{
		header('Location: index.php');
		exit();
	}

    require_once "connect.php";
    $connection = OpenCon();

    if ($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }

/**
 * Busca os torneios criados pelo utilizador logado
 * @throws Exception Connection Error
 */
function getTorneios(){

    $connection = OpenCon();
    if ($connection->connect_errno != 0)
    {
        throw new Exception(mysqli_connect_errno());
    }

    $quick_cast = ($_SESSION['cc']);
    // filter by nome:
    $result = $connection->query("SELECT tournamentid, user_cc,creationdate, tournamentname, creationdate,freespots, startdate, enddate, alreadystarted from tournament where user_cc=$quick_cast or shared = '1' ORDER BY startdate DESC");
    $num_of_results = mysqli_num_rows($result);


    if($num_of_results>0)
    {

        echo '<table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                <tr>
                    <th>Nome</th>   
                    <th>Data de criação</th>       
                    <th>Data de começo</th>
                    <th>Data de termino</th> 
                    <th>Vagas</th>
                    <th>Começou</th>
                    <th>Detalhes</th>
                    <th>Gerir torneio</th> 
                </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);


            $tournamentid = $row['tournamentid'];
            $tournamentname = $row['tournamentname'];
            $startdate = $row['startdate'];
            $enddate = $row['enddate'];
            $freespots = $row['freespots'];
            $creationdate = $row['creationdate'];
            $alreadystarted = $row['alreadystarted'];

            if($alreadystarted=='1'){
                $alreadystarted='Sim';
            }else{
                $alreadystarted='Não';
            }

            echo
                '<tr>
            <td>'.$tournamentname.'</td>
            <td>'.$creationdate.'</td>
            <td>'.$startdate.'</td>
            <td>'.$enddate.'</td> 
            <td>'.$freespots.'</td> 
            <td>'.$alreadystarted.'</td> 
            <td><input class="bbt" type="button" value="+Detalhes" onclick="tournamentDetails('.$tournamentid.')"></td> 
            <td><input class="bbt" type="button" value="Gerir" onclick="deleteSubjects('.$tournamentid.')"></td> 
            </tr>';
        }

        echo '</table>';
    }else{
        echo '<br><br>';
        echo '<h2 style="color: red; position: relative; left: -70%;">Nao existem torneios, crie um agora!</h2>';
    }
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
        <script src="js/GerirTorneio.js"></script>


        <link rel="stylesheet" href="css/index.css">
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
    <div class="bodyy">
      <h2 class="text-center">Gestão de torneios</h2>
        <div class="menu-esquerda btn-group">
            <form action="CriarTorneio.php">
                <button type="submit">+ Criar torneio</button>
            </form>
        </div>
      <br><br>
      <br>
        <div class="btn-group menu-centro">
            <div>
            <div>
                <?php
                    require_once "connect.php";

                    try {
                    getTorneios();
                } catch (Exception $e) {
                }
                ?>
                <script>
                    function deleteSubjects(subjectId){
                        window.location.href = 'gerirTorneio.php?edit_id='+ subjectId + '';
                        console.log(subjectId);
                    }

                    function tournamentDetails(subjectId){
                        window.location.href = 'seeDetails.php?edit_id='+ subjectId + '';
                        console.log(subjectId);
                    }
                </script>
            </div>
      </div>

    </div>

    </body>

  </html>
