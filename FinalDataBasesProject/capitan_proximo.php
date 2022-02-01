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


    $sqlgk="SELECT name FROM user INNER JOIN player where user.cc=player.user_cc and player.teamname='$teamname' and position  = 'GR' and player.isvisible = 1";
    $sqldef="SELECT name FROM user INNER JOIN player where user.cc=player.user_cc and player.teamname='$teamname' and position  = 'Defesa' and player.isvisible = 1";
    $sqlmed="SELECT name FROM user INNER JOIN player where user.cc=player.user_cc and player.teamname='$teamname' and position  = 'Medio' and player.isvisible = 1";
    $sqlava="SELECT name FROM user INNER JOIN player where user.cc=player.user_cc and player.teamname='$teamname' and position  = 'Avancado' and player.isvisible = 1";

    $resultgr = mysqli_query($connection, $sqlgk);
    $resultdef = mysqli_query($connection, $sqldef);
    $resultmed = mysqli_query($connection, $sqlmed);
    $resultava = mysqli_query($connection, $sqlava);



    //SELECTS FOR GOALKEEPERS
    $gr = "<select name='gk'  id='select' >";
    $grs = "<select name='gks'  id='select' >";
    $gr .="<option>Seleciona Jogador</option>";
    $grs .="<option>Seleciona Jogador</option>";
    while($row = mysqli_fetch_assoc($resultgr)){
        $gr .="<option value='{$row['name']}' >{$row['name']}</option>";
        $grs .="<option value='{$row['name']}' >{$row['name']}</option>";
    }


    //SELECTS FOR DEF
    $def1 = "<select name='def1'  id='select' >";
    $def2 = "<select name='def2'  id='select' >";
    $def3 = "<select name='def3'  id='select' >";
    $def4 = "<select name='def4'  id='select' >";
    $def5 = "<select name='def5'  id='select' >";
    $def1 .="<option>Seleciona Jogador</option>";
    $def2 .="<option>Seleciona Jogador</option>";
    $def3 .="<option>Seleciona Jogador</option>";
    $def4 .="<option>Seleciona Jogador</option>";
    $def5 .="<option>Seleciona Jogador</option>";
    while($row = mysqli_fetch_assoc($resultdef)){
        $def1 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $def2 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $def3 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $def4 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $def5 .="<option value='{$row['name']}' >{$row['name']}</option>";
    }


    //SELECT MED

    $med1 = "<select name='med1'  id='select' >";
    $med2 = "<select name='med2'  id='select' >";
    $med3 = "<select name='med3'  id='select' >";
    $med4 = "<select name='med4'  id='select' >";
    $med1 .="<option>Seleciona Jogador</option>";
    $med2 .="<option>Seleciona Jogador</option>";
    $med3 .="<option>Seleciona Jogador</option>";
    $med4 .="<option>Seleciona Jogador</option>";

    while($row = mysqli_fetch_assoc($resultmed)){
        $med1 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $med2 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $med3 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $med4 .="<option value='{$row['name']}' >{$row['name']}</option>";
    }

    //SELECT AVA

    $ava1 = "<select name='ava1'  id='select' >";
    $ava2 = "<select name='ava2'  id='select' >";
    $ava3 = "<select name='ava3'  id='select' >";
    $ava4 = "<select name='ava4'  id='select' >";
    $ava5 = "<select name='ava5'  id='select' >";
    $ava1 .="<option>Seleciona Jogador</option>";
    $ava2 .="<option>Seleciona Jogador</option>";
    $ava3 .="<option>Seleciona Jogador</option>";
    $ava4 .="<option>Seleciona Jogador</option>";
    $ava5 .="<option>Seleciona Jogador</option>";
    while($row = mysqli_fetch_assoc($resultava)){
        $ava1 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $ava2 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $ava3 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $ava4 .="<option value='{$row['name']}' >{$row['name']}</option>";
        $ava5 .="<option value='{$row['name']}' >{$row['name']}</option>";
    }


if (isset($_POST['buttone'])) {
    $players = array($_POST['gk'], $_POST['gks'], $_POST['def1'], $_POST['def2'], $_POST['def3'], $_POST['def4'], $_POST['def5'], $_POST['med1'], $_POST['med2'], $_POST['med3'], $_POST['med4'], $_POST['ava1'], $_POST['ava2'], $_POST['ava3'], $_POST['ava4'], $_POST['ava5']);
    if (count(array_unique($players)) != count($players)) {
        //has duplicates
        $_SESSION['error'] = true;
    } else {
        //no duplicates
        $sql = "UPDATE capitan_team SET team_gk = '$players[0]',team_def1 = '$players[2]',team_def2 = '$players[3]',team_def3 = '$players[4]',team_def4 = '$players[5]',team_med1 ='$players[7]',team_med2 = '$players[8]',team_med3 = '$players[9]',team_ava1 = '$players[11]',team_ava2 = '$players[12]',team_ava3 = '$players[13]',team_sub_gk = '$players[1]',team_sub_def = '$players[6]',team_sub_med = '$players[10]',team_sub_ava = '$players[14]',team_sub_ava1 = '$players[15]'  WHERE  capitan_team.team_teamname = '$teamname'";
        $connection->query($sql);
    }
}

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

      <form method="post" id = "data" >
      <div class="parallax-content baner-content">
          <div class="container">
              <div>
                  <div class="text-content" style="position:relative; bottom:100px;!important">
                      <h2>
                          <?php
                          echo "<em>Plantel ".$teamname."</em>";
                          ?>
                          <!-- <em>Plantel</em> -->
                      </h2>
                      <div>
                          <div class="col-lg-4" style="position:relative; left:14%;!important;">
                              <div class="text-content">
                                  <h3><b>Titulares</b></h3>
                                  <br>
                                  <table class="table">
                                      <tr>
                                          <th>Guarda Redes</th>
                                          <td><?php echo $gr?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa Esquerdo</th>
                                          <td><?php echo $def1?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa Central</th>
                                          <td><?php echo $def2?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa Central</th>
                                          <td><?php echo $def3?></td>
                                      </tr>
                                      <tr>
                                          <th>Defesa Direito</th>
                                          <td><?php echo $def4?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio Esquerdo</th>
                                          <td><?php echo $med1?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio Centro</th>
                                          <td><?php echo $med2?></td>
                                      </tr>
                                      <tr>
                                          <th>Medio Direito</th>
                                          <td><?php echo $med3?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado Esquedo</th>
                                          <td><?php echo $ava1?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado Centro</th>
                                          <td><?php echo $ava2?></td>
                                      </tr>
                                      <tr>
                                          <th>Avancado Direito</th>
                                          <td><?php echo $ava3?></td>
                                      </tr>
                                  </table>
                              </div>
                          </div>

                          <div>
                              <div class="col-lg-4" style="position:relative; left:14%;!important;">
                                  <div class="text-content">
                                      <h3><b>Suplentes</b></h3>
                                      <br>
                                      <table class="table">
                                          <tr>
                                              <th>Guarda Redes</th>
                                              <td><?php echo $grs?></td>
                                          </tr>
                                          <tr>
                                              <th>Defesa</th>
                                              <td><?php echo $def5?></td>
                                          </tr>
                                          <tr>
                                              <th>Medio</th>
                                              <td><?php echo $med4?></td>
                                          </tr>
                                          <tr>
                                              <th>Avancado</th>
                                              <td><?php echo $ava4?></td>
                                          </tr>
                                          <tr>
                                              <th>Avancado</th>
                                              <td><?php echo $ava5?></td>
                                          </tr>
                                      </table>
                                  </div>
                                  <button name = "buttone"class="button" style="position:relative; left:78%;" ><b>Confirmar</b></button>
                                  <?php

                                  if(isset($_SESSION['error'])){
                                      echo '<div style="color: red;margin-top: 40px;margin-bottom: 10px;font-size: x-large">Existem Jogadores Repetidos</div>';
                                  }
                                  ?>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
      </form>

      <br><br><br><br>
    <div>
      <br><br>
      <div class="menu-esquerda btn-group">
      <form action="capitan_resultados.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Resultado</button>
        </form>
        <form action="capitan_gestao.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Gestao de Plantel</button>
        </form>
        <form action="capitan_pedidos.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Pedidos Entrada</button>
        </form>
        <form action="indexcapitan.php">
          <button type="submit" class='btn' style="margin-bottom: 10px;">Dados da Equipa</button>
        </form>
      </div>
    </div>
    </body>

  </html>

