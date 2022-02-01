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
        // echo "<script> var r=confirm('Clique cancelar confirm!');"; 
        // echo "if(r==true){";
        // echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
        // echo "}";
        // echo "else{";
        // echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
        // echo "}";
        // echo "</script>";
        
        header('Location: ./torneioPage.php?torneio_id='.$torId);
        // echo "teste";
    }
    else if(isset($_POST['validar2'])){
        //verificacoes nome
        $flagEverythingOk = true;
        $nomeEquipa=$_POST['equipaName'];
        
        
        // verificar se o user já é player numa equipa do torneio
        $sql=" SELECT player.user_cc, player.teamname
        from player, captain_team
        where player.user_cc=$cc
        and player.teamname in (SELECT captain_team.team_teamname from captain_team WHERE captain_team.tournament_tournamentid=$torId);";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $flagEverythingOk=false;
            // echo "<script> alert('Erro!Já é jogador por uma equipa!'); </script>";
            echo "<script> var r=confirm('Erro!Já é jogador por uma equipa!');"; 
            echo "if(r==true){";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "else{";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "</script>";
        }

        // ver se o user já é reserva do torneio
        $sql1="SELECT COUNT(user_cc) as count1 from reservastorneio WHERE reservastorneio.user_cc=$cc and reservastorneio.tournament_tournamentid=$torId";
        $result0 = mysqli_query($conn, $sql1);
        $aux=mysqli_fetch_assoc($result0);
        $aux1=$aux['count1'];
        if($aux1>0){
            $flagEverythingOk=false;
            // echo "<script> alert('Já é Reserva do Torneio!'); </script>";
            echo "<script> var r=confirm('Já é Reserva do Torneio!');"; 
            echo "if(r==true){";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "else{";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "</script>";
            // echo "<script>window.close();</script>";
            // header('Location: ./torneioPage.php?torneio_id='.$torId);
        }

        // se o numero de reservas de um torneio já atingiu o limite
        if($numRes>4){
            $flagEverythingOk=false;
            echo "<script> var r=confirm('O Número total de Reservas foi atingido!');"; 
            echo "if(r==true){";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "else{";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "</script>";
        }
        
        

        // submit para DataBase
        if($flagEverythingOk==true){
            $query1="INSERT INTO `reservastorneio` (`reservaid`, `tournament_tournamentid`, `user_cc`) VALUES (NULL, '$torId', '$cc');";
            if ($conn->query($query1)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                // $url="./torneioPage.php?torneio_id=".$torId;
                // header('Location:'.$url);
                // echo "<script>window.close();</script>";
                header('Location: ./torneioPage.php?torneio_id='.$torId);
            } else {
                throw new Exception($conn->error);
            }
        }
    }
    else if(isset($_POST['validar3'])){
        //verificacoes nome
        $flagEverythingOk = true;
        
        // ver se o user já é reserva do torneio
        $sql1="SELECT COUNT(user_cc) as count1 from reservastorneio WHERE reservastorneio.user_cc=$cc and reservastorneio.tournament_tournamentid=$torId";
        $result0 = mysqli_query($conn, $sql1);
        $aux=mysqli_fetch_assoc($result0);
        $aux1=$aux['count1'];
        if($aux1!=1){
            $flagEverythingOk=false;
            // echo "<script> alert('Não é reserva do Torneio!'); </script>";
            echo "<script> var r=confirm('Não é Reserva do Torneio!');"; 
            echo "if(r==true){";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "else{";
            echo    "window.location.replace('./torneioPage.php?torneio_id=$torId');";
            echo "}";
            echo "</script>";
            // echo "<script>window.close();</script>";
            // header('Location: ./torneioPage.php?torneio_id='.$torId);
        }

        // submit para DataBase
        if($flagEverythingOk==true){
            $query1="DELETE FROM reservastorneio 
            WHERE reservastorneio.tournament_tournamentid=$torId
            and reservastorneio.user_cc=$cc";
            if ($conn->query($query1)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                // $url="./torneioPage.php?torneio_id=".$torId;
                // header('Location:'.$url);
                // echo "<script>window.close();</script>";
                header('Location: ./torneioPage.php?torneio_id='.$torId);
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
                <div class="text-content" style="position:relative; bottom:100px;!important">
                    <h2>
                        <em>Inscrever Como Reserva?</em>
                    </h2>
                <div>
                <div>     
                    <br>
                    <p><font size = "5"> <b>
                    <?php
                        $sql="SELECT COUNT(user_cc) as count1 from reservastorneio WHERE reservastorneio.tournament_tournamentid=$torId";
                        $result = mysqli_query($conn, $sql);
                        $result2=mysqli_fetch_assoc($result);
                        $numRes=$result2['count1'];
                        echo $torneio["tournamentname"];
                        echo "</font></b></p>";
                        echo "<p>".$numRes."/5 Reservas no Torneio</p>";
                    ?>
                     <!-- </font></b></p> -->

                    <!-- <p>Criar Equipa para o Torneio</p> -->

                    <form action="" method="post">
                    <br>
                    <input name="equipaName" type="hidden" value="Nome Equipa">
                    <br>
                    <button name="validar1" class="button" type="submit" style="position:relative; background:red;left:32% !important;" value="cancelar"> Cancelar </button>
                    <button name="validar2" class="button" type="submit" style="position:relative; display:inline;left:5%;top:-40px;!important;" value="salvar"> Inscrever </button>
                    <button name="validar3" class="button" type="submit" style="position:relative; background: orange;display:inline;left:13%;top:-40px;!important;" value="desinscrever"> Desinscrever </button>
                    <!-- <input name="validar" class="button" type="submit" style="position:relative; display:inline;left:190px;top:-40px;!important;" value ="Salvar"> -->
                    </form>
                </div>
            </div>
        </div>
    </div> 
</body>

</html>