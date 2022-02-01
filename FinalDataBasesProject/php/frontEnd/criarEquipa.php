<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}
$cc=$_SESSION['cc'];
$sql="SELECT tournament.tournamentid,tournament.tournamentname, tournament.startdate, tournament.enddate, tournamentdetails.gameweekday, tournamentdetails.gamestarttime from tournament, tournamentdetails WHERE tournamentdetails.tournament_tournamentid=tournament.tournamentid and tournament.tournamentid=$torId";
$result = mysqli_query($conn, $sql);
$torneio=mysqli_fetch_assoc($result);



// echo $_SESSION["cc"];
// echo $_SESSION["variavel"];

if(isset($_POST['equipaName'])){
    // verificar se clicou no cancelou
    if(isset($_POST['validar1'])){
        echo "<script>window.close();</script>";
        // echo "teste";
    }
    else if(isset($_POST['validar2'])){
        //verificacoes nome
        $flagEverythingOk = true;
        $nomeEquipa=$_POST['equipaName'];
        if ((strlen($nomeEquipa) < 1)) {
            $flagEverythingOk = false;
            // $_SESSION['e_name'] = "Name field cannot be empty!";
            echo "<script> alert('Name field cannot be empty!'); </script>";
        }
        else if($nomeEquipa=="Nome Equipa"){
            $flagEverythingOk = false;
            echo "<script> alert('Insert a Name!'); </script>";
        }

        //check if name is taken
        $query ="SELECT `team_teamname` FROM `captain_team` WHERE `team_teamname` LIKE '$nomeEquipa' and `tournament_tournamentid`='$torId'";
        $result1 = $conn->query($query);
        $count_nomes = $result1->num_rows;
        if ($count_nomes > 0) {
            $flagEverythingOk = false;
            echo "<script> alert('Nome de Equipa já existe!'); </script>";
        }
        $posicaoEquipa=$_POST['posicao'];

        // verificar se o user já é player numa equipa do torneio
        $sql=" SELECT player.user_cc, player.teamname
        from player, captain_team
        where player.user_cc=$cc
        and player.teamname in (SELECT captain_team.team_teamname from captain_team WHERE captain_team.tournament_tournamentid=$torId);";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $flagEverythingOk=false;
            echo "<script> alert('Erro!Já é jogador por outra equipa!'); </script>";
        }

        // verificar se o user já é reserva do torneio
        $sql10=" SELECT reservastorneio.user_cc from reservastorneio
        WHERE reservastorneio.tournament_tournamentid=$torId
        and reservastorneio.user_cc=$cc;";
        $result10 = mysqli_query($conn, $sql10);
        if (mysqli_num_rows($result10) > 0) {
        
            $flagEverythingOk=false;
            echo "<script> alert('Erro!Já é reserva do torneio!'); </script>";
        }

        // submit para DataBase
        if($flagEverythingOk==true){
            $sql = "SELECT username,name,contact FROM `user` where cc=$cc";
            $result = mysqli_query($conn, $sql);
            $user=mysqli_fetch_assoc($result);
            $username=$user['username'];
            $nomeuser=$user['name'];
            $contact=$user['contact'];

            //criar a equipa com o jogador na posicao que quer
            if($posicaoEquipa=="Gr"){
                $query="INSERT INTO `captain_team` (`team_teamname`, `team_creationdate`, `team_points`, `team_ngames`, `team_nplayers`, `team_goalsscored`, `team_goalssuffered`, `team_victories`, `team_draws`, `team_defeats`, `team_gk`, `team_def1`, `team_def2`, `team_def3`, `team_def4`, `team_med1`, `team_med2`, `team_med3`, `team_ava1`, `team_ava2`, `team_ava3`, `team_sub_gk`, `team_sub_def`, `team_sub_med`, `team_sub_ava`, `team_sub_ava1`, `team_isvisible`, `user_cc`, `tournament_tournamentid`) VALUES ('$nomeEquipa', current_timestamp(), '0', '0', NULL, '0', '0', '0', '0', '0', '$nomeuser', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '$cc', '$torId');";
                if ($conn->query($query)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                    // $url="./torneioPage.php?torneio_id=".$torId;
                    // header('Location:'.$url);
                    // echo "<script>window.close();</script>";
                } else {
                    throw new Exception($conn->error);
                }
            }
            else if($posicaoEquipa=="Defesa"){
                $query="INSERT INTO `captain_team` (`team_teamname`, `team_creationdate`, `team_points`, `team_ngames`, `team_nplayers`, `team_goalsscored`, `team_goalssuffered`, `team_victories`, `team_draws`, `team_defeats`, `team_gk`, `team_def1`, `team_def2`, `team_def3`, `team_def4`, `team_med1`, `team_med2`, `team_med3`, `team_ava1`, `team_ava2`, `team_ava3`, `team_sub_gk`, `team_sub_def`, `team_sub_med`, `team_sub_ava`, `team_sub_ava1`, `team_isvisible`, `user_cc`, `tournament_tournamentid`) VALUES ('$nomeEquipa', current_timestamp(), '0', '0', NULL, '0', '0', '0', '0', '0', NULL, '$nomeuser', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '$cc', '$torId');";
                if ($conn->query($query)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                    // $url="./torneioPage.php?torneio_id=".$torId;
                    // header('Location:'.$url);
                    // echo "<script>window.close();</script>";
                } else {
                    throw new Exception($conn->error);
                }
            }  
            else if($posicaoEquipa=="Medio"){
                $query="INSERT INTO `captain_team` (`team_teamname`, `team_creationdate`, `team_points`, `team_ngames`, `team_nplayers`, `team_goalsscored`, `team_goalssuffered`, `team_victories`, `team_draws`, `team_defeats`, `team_gk`, `team_def1`, `team_def2`, `team_def3`, `team_def4`, `team_med1`, `team_med2`, `team_med3`, `team_ava1`, `team_ava2`, `team_ava3`, `team_sub_gk`, `team_sub_def`, `team_sub_med`, `team_sub_ava`, `team_sub_ava1`, `team_isvisible`, `user_cc`, `tournament_tournamentid`) VALUES ('$nomeEquipa', current_timestamp(), '0', '0', NULL, '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, '$nomeuser', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '$cc', '$torId');";
                if ($conn->query($query)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                    // $url="./torneioPage.php?torneio_id=".$torId;
                    // header('Location:'.$url);
                    // echo "<script>window.close();</script>";
                } else {
                    throw new Exception($conn->error);
                }
            } 
            else if($posicaoEquipa=="Avancado"){
                $query="INSERT INTO `captain_team` (`team_teamname`, `team_creationdate`, `team_points`, `team_ngames`, `team_nplayers`, `team_goalsscored`, `team_goalssuffered`, `team_victories`, `team_draws`, `team_defeats`, `team_gk`, `team_def1`, `team_def2`, `team_def3`, `team_def4`, `team_med1`, `team_med2`, `team_med3`, `team_ava1`, `team_ava2`, `team_ava3`, `team_sub_gk`, `team_sub_def`, `team_sub_med`, `team_sub_ava`, `team_sub_ava1`, `team_isvisible`, `user_cc`, `tournament_tournamentid`) VALUES ('$nomeEquipa', current_timestamp(), '0', '0', NULL, '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$nomeuser', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '$cc', '$torId');";
                if ($conn->query($query)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                    // $url="./torneioPage.php?torneio_id=".$torId;
                    // header('Location:'.$url);
                    // echo "<script>window.close();</script>";
                } else {
                    throw new Exception($conn->error);
                }
            } 

            // criar request para poder entrar no torneio
            $query1="INSERT INTO `request` (`accepted`, `reqid`, `teamname`, `tournament_tournamentid`) VALUES (NULL, NULL, '$nomeEquipa', '$torId');";
            if ($conn->query($query1)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                // $url="./torneioPage.php?torneio_id=".$torId;
                // header('Location:'.$url);
                echo "<script>window.close();</script>";
            } else {
                throw new Exception($conn->error);
            }

            // criar um player
            $query9="INSERT INTO `player` (`balance`, `callnumber`, `position`, `isavailable`, `gamesplayed`, `goalsscored`, `gamesmissed`, `faults`, `teamname`, `isvisible`, `user_cc`) VALUES ('0', '$contact', '$posicaoEquipa', '1', '0', '0', '0', '0', '$nomeEquipa', '1', '$cc');";
            if ($conn->query($query9)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
            } else {
                throw new Exception($conn->error);
            }

            // meter user como captain
            $query10="update user set user.iscaptain=1 WHERE user.cc=$cc";
            if ($conn->query($query10)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
            } else {
                throw new Exception($conn->error);
            }
        }
    }   
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>FOOTBALLERS'R'US</title>
    <meta name="description" content="">

    <!-- View Port - reactive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styling -->
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.css">
    <link rel="stylesheet" href="../../css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../js/userNL.js"></script>
</head>


<!--Body-->

<body>

    <div class="parallax-content baner-content">
        <div class="container">
            <div>
                <div class="text-content" style="position:relative; bottom:150px;!important">
                    <h2>
                        <em>Criar Equipa</em>
                    </h2>
                <div>
                <div>     
                    <p>Criar Equipa para o Torneio</p>
                    <p><font size = "5"> <b>
                    <?php
                    echo $torneio["tournamentname"];
                    ?>
                     </font></b></p>
                    <p>     Atenção!!<br>Ao Criar um equipa está-se a tornar capitão da mesma!</p>
                    <form action="" method="post">
                    <input name="equipaName" type="text" value="Nome Equipa">
                    <br>
                    <p><b>Escolhe uma Posição</b></p>
                    <select class="form-control" style="position:relative; left:26%;max-width:50%;" name="posicao">
                        <option class="btn" value="Avancado">Avançado</option>
                        <option class="btn" value="Medio">Médio</option>
                        <option class="btn" value="Defesa">Defesa</option>
                        <option class="btn" value="Gr">Guarda-Redes</option>
                    </select>
                    <br>
                    <button name="validar1" class="button" type="submit" style="position:relative; background:red;!important;" value="cancelar"> Cancelar </button>
                    <button name="validar2" class="button" type="submit" style="position:relative; display:inline;left:190px;top:-40px;!important;" value="salvar"> Salvar </button>
                    <!-- <input name="validar" class="button" type="submit" style="position:relative; display:inline;left:190px;top:-40px;!important;" value ="Salvar"> -->
                    </form>
                </div>
            </div>
        </div>
    </div> 
</body>

</html>