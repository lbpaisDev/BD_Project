<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
    // $_SESSION['editTourId'] = $torId;
    // console_log($torId);
}

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
// $sql="SELECT game.teamone,game.teamtwo,game.tournament_tournamentid,game.gamedate,game.gamefield,game.starttime from game where game.gameid=$gameId";
// $result = mysqli_query($conn, $sql);
// $game=mysqli_fetch_assoc($result);



// echo $_SESSION["cc"];
// echo $_SESSION["variavel"];

if(isset($_POST['equipaName'])){
    // verificar se clicou no cancelou

    if(isset($_POST['validar1'])){        
        header('location: ./disponibilidade.php?t_name='.$teamname.'&game_id='.$gameId.'&available_id='.$availabeId);
    }
    // verificar se clicou no jogador de fora
    if(isset($_POST['validar3'])){
        
        header('Location: ./substitutoOut.php?torneio_id='.$torId."&t_name=".$teamname."&game_id=".$gameId."&available_id=".$availabeId);
    }
    // verificar se clicou num jogador das tabelas
    else if(isset($_POST['validar2'])){
        //verificacoes nome
        $flagEverythingOk = true;
        
        // verificar se as duas tabelas estão selecionadas
        if(isset($_POST['escolha1']) && isset($_POST['escolha2']) ){
            $flagEverythingOk=false;

            // echo $_POST['escolha'];
            $escolha=$_POST['escolha1[0]'];
            // $colunas=mysqli_num_rows($escolha);
            echo "<script> var r=confirm('$escolha') </script>"; 
        }
        // verificar se não selecionou mais que uma checbox
        if(isset($_POST['escolha1'])){
            $count1=count($_POST['escolha1']);
            if($count1>1){
                $flagEverythingOk=false;
            }
        }
        // verificar se não selecionou mais que uma checkbox
        if(isset($_POST['escolha2'])){
            $count2=count($_POST['escolha2']);
            if($count2>1){
                $flagEverythingOk=false;
            }
        }
        
        // se já só estiver uma checkbox selecionada
        // verificar se o user escolhido não está inscrito em nenhuma equipa do torneio
        if(isset($_POST['escolha1'])){
            foreach($_POST['escolha1'] as $escolha){
                $sql=" SELECT player.user_cc, player.teamname
                from player, captain_team
                where player.user_cc=$escolha
                and player.teamname in (SELECT captain_team.team_teamname from captain_team WHERE captain_team.tournament_tournamentid=$torId);";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $flagEverythingOk=false;
                    echo "<script> alert('Erro!O jogador que selecionou é jogador por outra equipa neste torneio!'); </script>";
                }
            }
        }

        // se já só estiver uma checkbox selecionada utilizar o seu value
        // verificar se o user escolhido não está inscrito em nenhuma equipa do torneio
        if(isset($_POST['escolha2'])){
            foreach($_POST['escolha2'] as $escolha){
                $sql=" SELECT player.user_cc, player.teamname
                from player, captain_team
                where player.user_cc=$escolha
                and player.teamname in (SELECT captain_team.team_teamname from captain_team WHERE captain_team.tournament_tournamentid=$torId);";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $flagEverythingOk=false;
                    echo "<script> alert('Erro!O jogador que selecionou é jogador por outra equipa neste torneio!'); </script>";
                }
            }
        }



        // submit para DataBase
        if($flagEverythingOk==true){

            // se ele já tiver um substituto, apagar esse e inserir o novo
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
                // tirar a falta para no algoritmo seguinte adicionar
                $query10="UPDATE player set player.gamesmissed=player.gamesmissed-1 where player.user_cc=$cc and player.teamname like '$teamname'";
                if ($conn->query($query10)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                } else {
                    throw new Exception($conn->error);
                }
            }

            // se ele já tiver um substituto  de fora, apagar esse e inserir o novo
            $sql="SELECT * FROM `substituteout` WHERE `user_cc`=$cc and game_gameid=$gameId";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // delete da substituição relativa ao jogo
                // DELETE FROM `substitute` WHERE `user_cc`=123456789 and game_gameid=1
                $query1="DELETE FROM `substituteout` WHERE `user_cc`=$cc and game_gameid=$gameId";
                if ($conn->query($query1)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                } else {
                    throw new Exception($conn->error);
                }
                // tirar a falta para no algoritmo seguinte adicionar
                $query10="UPDATE player set player.gamesmissed=player.gamesmissed-1 where player.user_cc=$cc and player.teamname like '$teamname'";
                if ($conn->query($query10)) {
                    $_SESSION['registration_success'] = true;
                    $_SESSION['loggedin'] = true;
                } else {
                    throw new Exception($conn->error);
                }
            }

            // inserir uma falta ao jogador
            // UPDATE player set player.gamesmissed=player.gamesmissed+1 where player.user_cc=123456789
            $query="UPDATE player set player.gamesmissed=player.gamesmissed+1 where player.user_cc=$cc and player.teamname like '$teamname'";
            if ($conn->query($query)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
            } else {
                throw new Exception($conn->error);
            }


            if(isset($_POST['escolha1'])){
                foreach($_POST['escolha1'] as $escolha){
                    $query1="UPDATE playergameavailable 
                    set playergameavailable.isavailable=0
                    WHERE playergameavailable.user_cc=$cc
                    and playergameavailable.game_gameid=$gameId";
                    if ($conn->query($query1)) {
                            $_SESSION['registration_success'] = true;
                            $_SESSION['loggedin'] = true;
                    } else {
                        throw new Exception($conn->error);
                    }

                    // fazer a substituição
                    // INSERT INTO `substitute` (`substituteid`, `game_gameid`, `user_cc`, `user_cc1`) VALUES (NULL, '1', '123456789', '111111111');
                    $query2="INSERT INTO `substitute` (`substituteid`, `game_gameid`, `user_cc`, `user_cc1`) VALUES (NULL, '$gameId', '$cc', '$escolha');";
                    if ($conn->query($query2)) {
                        $_SESSION['registration_success'] = true;
                        $_SESSION['loggedin'] = true;                            
                        header('Location: ./equipaPlay.php?torneio_id='.$torId."&t_name=".$teamname);
                    } else {
                        throw new Exception($conn->error);
                    }
                }
            }

            
            if(isset($_POST['escolha2'])){
                foreach($_POST['escolha2'] as $escolha){
                    $query1="UPDATE playergameavailable 
                    set playergameavailable.isavailable=0
                    WHERE playergameavailable.user_cc=$cc
                    and playergameavailable.game_gameid=$gameId";
                    if ($conn->query($query1)) {
                            $_SESSION['registration_success'] = true;
                            $_SESSION['loggedin'] = true;
                            // $url="./torneioPage.php?torneio_id=".$torId;
                            // header('Location:'.$url);
                            // echo "<script>window.close();</script>";
                            // header('Location: ./torneioPage.php?torneio_id='.$torId);
                            // header('Location: ./equipaPlay.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname);
                            // header('Location: ./substituto.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname."&game_id=".$gameId."&available_id=".$availabeId);
                            
                            // header('Location: ./equipaPlay.php?torneio_id='.$torId."&t_name=".$teamname);
                    } else {
                        throw new Exception($conn->error);
                    }

                    // fazer a substituição
                    // INSERT INTO `substitute` (`substituteid`, `game_gameid`, `user_cc`, `user_cc1`) VALUES (NULL, '1', '123456789', '111111111');
                    $query2="INSERT INTO `substitute` (`substituteid`, `game_gameid`, `user_cc`, `user_cc1`) VALUES (NULL, '$gameId', '$cc', '$escolha');";
                    if ($conn->query($query2)) {
                        $_SESSION['registration_success'] = true;
                        $_SESSION['loggedin'] = true;
                            // $url="./torneioPage.php?torneio_id=".$torId;
                            // header('Location:'.$url);
                            // echo "<script>window.close();</script>";
                            // header('Location: ./torneioPage.php?torneio_id='.$torId);
                            // header('Location: ./equipaPlay.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname);
                            // header('Location: ./substituto.php?torneio_id='.$game['tournament_tournamentid']."&t_name=".$teamname."&game_id=".$gameId."&available_id=".$availabeId);
                            
                        header('Location: ./equipaPlay.php?torneio_id='.$torId."&t_name=".$teamname);
                    } else {
                        throw new Exception($conn->error);
                    }
                }
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

    <div class="parallax-content baner-content" style="position:relative; bottom:100px;"> 
        <div class="container">
            <div>
            
            <form action="" method="post">
                <div class="text-content" style="position:relative; bottom:100px;!important">
                    <h2>
                        <em>Escolhe um Substituto</em>
                    </h2>
                <div>
                    <div>     
                        <br>
                        <p><font size = "4"> <b>
                        Para jogar pela tua vez
                        </font></p>
                    </div>
                    <br>

                    <div class="col-lg-6">
                        <div class="text-content">
                            <h3> Reservas Torneio </h3>
                            <br>
                            <table class="table">
                                <tr>
                                    <th>UserName</th>
                                    <th>Nome</th>
                                    <th>Contacto</th>
                                    <th>Substituto</th>
                                </tr>
                                <?php
                                    // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                                    // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                                    $sql="SELECT count(reservastorneio.user_cc) as numreservas,reservastorneio.user_cc,user.username,user.name,user.cc,user.contact from reservastorneio,user where reservastorneio.tournament_tournamentid=$torId and reservastorneio.user_cc=user.cc and reservastorneio.user_cc!=$cc";
                                    $result = mysqli_query($conn, $sql);
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $numReservas=$row['numreservas'];
                                            echo "<tr>";
                                            echo "<td>".$row["username"]."</td>"."<td>".$row["name"]."</td>"."<td>".$row["contact"]."</td>"."<td><input type='checkbox' style='transform:scale(0.5);' name='escolha1[]' value=".$row['cc'].">";
                                            // echo "<td>".$row["tournamentname"]."</td>"."<td>".$row["freespots"]."</td>"."</td>" ."<td>".$row["currentteams"]."</td>"."<td>".$row["gameweekday"]."</td>"."<td>".$row["gamestarttime"]."</td>"."<td>".$row["startdate"]."</td>"."<td>".$row["enddate"]."</td>"."<td><a  class='button' href='./torneiopage.php?torneio_id=1'>Info</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?> 
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="text-content">
                            <h3> All Users </h3>
                            <br>
                            <table class="table">
                                <tr>
                                    <th>UserName</th>
                                    <th>Nome</th>
                                    <th>Contacto</th>
                                    <th>Substituto</th>
                                </tr>
                                <?php
                                    // $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                                    // $sql="SELECT `tournamentid`,`tournamentname`,`freespots`,`currentteams`,`startdate`,`enddate` FROM `tournament` Order by 2";
                                    $sql = "SELECT username, email, contact,name,cc,contact FROM `user` where cc!=$cc ORDER BY 1";
                                    $result = mysqli_query($conn, $sql);
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>".$row["username"]."</td>"."<td>".$row["name"]."</td>"."<td>".$row["contact"]."</td>"."<td><input type='checkbox' style='transform:scale(0.5);' name='escolha2[]' value=".$row['cc'].">";
                                            // echo "<td>".$row["tournamentname"]."</td>"."<td>".$row["freespots"]."</td>"."</td>" ."<td>".$row["currentteams"]."</td>"."<td>".$row["gameweekday"]."</td>"."<td>".$row["gamestarttime"]."</td>"."<td>".$row["startdate"]."</td>"."<td>".$row["enddate"]."</td>"."<td><a  class='button' href='./torneiopage.php?torneio_id=1'>Info</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?> 
                            </table>
                        </div>
                    </div>
                        
                    <div class="col-lg-12">
                        <!-- <form action="" method="post"> -->
                        
                        <input name="equipaName" type="hidden" value="Nome Equipa">
                        
                        <button name="validar1" class="button" type="submit" style="position:relative; background:red;left:28% !important;" value="cancelar"> Cancelar </button>
                        <button name="validar2" class="button" type="submit" style="position:relative; display:inline;left:5%;top:-40px;!important;" value="salvar"> Escolher </button>
                        <button name="validar3" class="button" type="submit" style="position:relative;background:orange; display:inline;left:18%;top:-40px;!important;" value="salvar"> Fora do Website </button>
                        </form>
                    </div>                  
                </div>
            </div>
        </div>
    </div> 
</body>

</html>