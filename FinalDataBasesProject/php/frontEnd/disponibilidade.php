<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

if(isset($_GET['game_id'])){
    $gameId = $_GET['game_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}
if(isset($_GET['t_name'])){
    $teamname = $_GET['t_name'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}
if(isset($_GET['available_id'])){
    $availabeId = $_GET['available_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}

$cc=$_SESSION['cc'];
$sql="SELECT game.teamone,game.teamtwo,game.tournament_tournamentid,game.gamedate,game.gamefield,game.starttime from game where game.gameid=$gameId";
$result = mysqli_query($conn, $sql);
$game=mysqli_fetch_assoc($result);



// echo $_SESSION["cc"];
// echo $_SESSION["variavel"];

if(isset($_POST['equipaName'])){
    // verificar se clicou no cancelou
    if(isset($_POST['validar1'])){
        
        // echo "<script> var r=confirm('Clique cancelar confirm!');"; 
        // echo "if(r==true){";
        // echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
        // echo "}";
        // echo "else{";
        // echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
        // echo "}";
        // echo "</script>";
        
        header('Location: ./equipaPlay.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname);
        // header('Location: ./substituto.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname);

        // echo "teste";
    }
    else if(isset($_POST['validar2'])){
        //verificacoes nome
        $flagEverythingOk = true;
        
        // verificar se o user já disse que não ia ao jogo
        // se disse que não ia, apagar os substitutos
        $sql="SELECT * FROM `substitute` WHERE user_cc=$cc and game_gameid=$gameId";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // delete da substituição relativa ao jogo
            // DELETE FROM `substitute` WHERE `user_cc`=123456789 and game_gameid=1
            $query1="DELETE FROM `substitute` WHERE `user_cc`=$cc and game_gameid=$gameId";
            if ($conn->query($query1)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
            } else {
                throw new Exception($conn->error);
            }

            // update nos jogos em que o player faltou 
            // tirar a falta
            $query10="UPDATE player set player.gamesmissed=player.gamesmissed-1 where player.user_cc=$cc and player.teamname like '$teamname'";
            if ($conn->query($query10)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
            } else {
                throw new Exception($conn->error);
            }
        }

        
        // submit para DataBase
        if($flagEverythingOk==true){
            $query1="UPDATE playergameavailable 
            set playergameavailable.isavailable=1
            WHERE playergameavailable.user_cc=$cc
            and playergameavailable.game_gameid=$gameId";
            if ($conn->query($query1)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                // $url="./torneioPage.php?torneio_id=".$torId;
                // header('Location:'.$url);
                // echo "<script>window.close();</script>";
                // header('Location: ./torneioPage.php?torneio_id='.$torId);
                header('Location: ./equipaPlay.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname."&game_id=".$gam);
            } else {
                throw new Exception($conn->error);
            }
        }
    }
    else if(isset($_POST['validar3'])){
        $flagEverythingOk = true;

        // submit para DataBase
        if($flagEverythingOk==true){
            header('Location: ./substituto.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname."&game_id=".$gameId."&available_id=".$availabeId);
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
                <div class="text-content" style="position:relative; bottom:100px;!important">
                    <h2>
                        <em>Disponibilidade</em>
                    </h2>
                <div>
                    <div>     
                        <br>
                        <p><font size = "5"> <b>
                        <?php
                            // $sql="SELECT COUNT(user_cc) as count1 from reservastorneio WHERE reservastorneio.tournament_tournamentid=$torId";
                            // $result = mysqli_query($conn, $sql);
                            // $result2=mysqli_fetch_assoc($result);
                            // $numRes=$result2['count1'];
                            echo $game['teamone']." Vs ". $game['teamtwo'];
                            echo "</font></b></p>";
                            // echo "<p>".$numRes."/5 Reservas no Torneio</p>";
                        ?>
                    </div>
                    <br>
                        <div class="text-content" style="position:relative; left:35%;width:30%" >
                            <h4> Informações Jogo </h4>
                            <br>
                            <table class="table">   
                                <tr>
                                    <th>Horas</th>
                                    <td><?php echo $game['starttime']."H"?></td>
                                </tr>
                                <tr>
                                    <th>Data</th>
                                    <td><?php echo $game['gamedate']?></td>
                                </tr> 
                                <tr>
                                    <th>Local</th>
                                    <td><?php echo $game['gamefield']?></td>
                                </tr>   
                            </table>
                        </div>

                     <!-- </font></b></p> -->

                    <!-- <p>Criar Equipa para o Torneio</p> -->

                    <form action="" method="post">
                    <br>
                    <input name="equipaName" type="hidden" value="Nome Equipa">
                    <br>
                    <button name="validar1" class="button" type="submit" style="position:relative; background:red;left:32% !important;" value="cancelar"> Cancelar </button>
                    <button name="validar2" class="button" type="submit" style="position:relative; display:inline;left:5%;top:-40px;!important;" value="salvar"> Vou </button>
                    <button name="validar3" class="button" type="submit" style="position:relative; background: orange;display:inline;left:13%;top:-40px;!important;" value="desinscrever"> Não vou </button>
                    <!-- <input name="validar" class="button" type="submit" style="position:relative; display:inline;left:190px;top:-40px;!important;" value ="Salvar"> -->
                    </form>
                </div>
            </div>
        </div>
    </div> 
</body>

</html>