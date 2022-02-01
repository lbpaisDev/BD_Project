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

if(isset($_POST['posicao'])){
    // verificar se clicou no cancelou
    if(isset($_POST['validar1'])){
        echo "<script>window.close();</script>";
        // echo "teste";
    }
    else if(isset($_POST['validar2'])){
        //verificacoes nome
        $flagEverythingOk = true;

        // verificar se existe equipa selecionada
        if(!isset($_POST['equipa'])){
            $flagEverythingOk=false;
            echo "<script> alert('Tem de escolher uma equipa!'); </script>";
        }
        else{
            $nomeEquipa=$_POST['equipa'];
        }
        
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

        $posicaoEquipa=$_POST['posicao'];
       
        // submit para DataBase
        if($flagEverythingOk==true){
            
            $sql = "SELECT username FROM `user` where cc=$cc";
            $result = mysqli_query($conn, $sql);
            $user=mysqli_fetch_assoc($result);
            $username=$user['username'];
            
            $query = "INSERT INTO `request_team` (`reqid`, `team_name`, `user_name`, `accepted`, `pos`, `user_cc`) VALUES (NULL, '$nomeEquipa', '$username', NULL, '$posicaoEquipa', '$cc');";
            if ($conn->query($query)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                // $url="./torneioPage.php?torneio_id=".$torId;
                // header('Location:'.$url);
                echo "<script>window.close();</script>";
            } else {
                throw new Exception($conn->error);
            }
        }
    }   
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
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
                        <em>Entrar Equipa</em>
                    </h2>
                <div>
                <div>     
                    <p><b>Escolhe uma Equipa</b></p>
                    <form action="" method="post">
                    <select class="form-control" style="position:relative; left:26%;max-width:50%;" name="equipa">
                        <!-- <option class="btn" value="volvo">Volvo</option>
                        <option class="btn" value="saab">Saab</option>
                        <option class="btn" value="fiat">Fiat</option>
                        <option class="btn" value="audi">Audi</option> -->

                        <?php 
                        $sql1="SELECT team_teamname FROM captain_team,request WHERE request.tournament_tournamentid=captain_team.tournament_tournamentid and captain_team.tournament_tournamentid=$torId and captain_team.team_teamname=request.teamname and request.accepted='1'";
                        $result1 = mysqli_query($conn, $sql1);
                        
                        if (mysqli_num_rows($result1) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result1)) {
                                // echo "<tr>";
                                // echo "<td>".$row["team_teamname"]."</td>"."<td>".$row["team_ngames"]."</td>"."</td>" ."<td>".$row["team_points"]."</td>"."<td>".$row["team_victories"]."</td>"."<td>".$row["team_draws"]."</td>"."<td>".$row["team_defeats"]."</td>";
                                // echo "</tr>";
                                echo "<option class='btn' value=".$row["team_teamname"].">".$row["team_teamname"]."</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <p><b>Escolhe uma Posição</b></p>
                    <form action="" method="post">
                    <select class="form-control" style="position:relative; left:26%;max-width:50%;" name="posicao">
                        <option class="btn" value="Avancado">Avançado</option>
                        <option class="btn" value="Medio">Médio</option>
                        <option class="btn" value="Defesa">Defesa</option>
                        <option class="btn" value="Gr">Guarda-Redes</option>
                    </select>
                    <button name="validar1" class="button" type="submit" style="position:relative;left:20%;top:20px;background:red;!important;" value="cancelar"> Cancelar </button>
                    <button name="validar2" class="button" type="submit" style="position:relative; display:inline;left:20%;top:-20px;!important;" value="salvar"> Salvar </button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</body>

</html>