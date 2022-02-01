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

if(isset($_POST['nome'])){
    // verificar se clicou no cancelou
    if(isset($_POST['validar1'])){
        header('Location: ./substituto.php?torneio_id='.$torId."&t_name=".$teamname."&game_id=".$gameId."&available_id=".$availabeId);
    }
    // verificar se clicou no Salvar
    else if(isset($_POST['validar2'])){
        $flagEverythingOk = true;
        $nome=$_POST['nome'];
        $contacto=$_POST['contacto'];
        $email=$_POST['email'];
        
        //verificacoes nome
        // verificar se nome já existe

        if ((strlen($nome) < 1)) {
            $flagEverythingOk = false;
            $_SESSION['e_name'] = "Name field cannot be empty!";
            echo "<script> alert('Name field cannot be empty!'); </script>";
        }

        if ($nome=="nome") {
            $flagEverythingOk = false;
            $_SESSION['e_name'] = "Name field cannot be empty!";
            echo "<script> alert('Tem de preencher um Nome!'); </script>";
        }
        
        //verificacoes contacto
        if ((strlen($contacto) != 9)) {
            //$flagEverythingOk = false;
            $_SESSION['e_phonenumber'] = "Phone number must be nine digits!";
            echo "<script> alert('Phone number must be nine digits!'); </script>";
        }
        if (is_numeric($contacto) == false) {
            //$flagEverythingOk = false;
            $_SESSION['e_phonenumber'] = "Phone number has to consist of only numbers!";
            echo "<script> alert('Phone number has to consist of only numbers!'); </script>";
        }

        //verificacoes email
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
            $flagEverythingOk = false;
            $_SESSION['e_email'] = "Incorrect email address!";
            echo "<script> alert('Tem de fornecer um email veridico!'); </script>";
        }
        
        if($flagEverythingOk==true){

            // verificar se o jogador já disse que não ia ao jogo
            $sql="SELECT playergameavailable.user_cc from playergameavailable WHERE playergameavailable.user_cc=$cc and playergameavailable.game_gameid=$gameId and playergameavailable.isavailable=0";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
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

            // dizer que o player não está available
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
        
            // submeter um substituto de fora para a DB
            $query = "INSERT INTO `substituteout` (`outsideid`, `nome`, `telemovel`, `email`, `user_cc`, `game_gameid`) VALUES (NULL, '$nome', '$contacto', '$email', '$cc', '$gameId');";
            if ($conn->query($query)) {
                $_SESSION['registration_success'] = true;
                $_SESSION['loggedin'] = true;
                header('Location: ./equipaPlay.php?torneio_id='.$torId."&t_name=".$teamname);
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
                        <em>Diz-nos quem é o teu Substituto</em>
                    </h2>
                    <br>
                <div class="col-lg-5" style="position:relative; left:30%;top:30px;">
                    <form action="" method="post">
                        <b>First name:</b><br>
                        <input type="text" name="nome" value="nome">
                        <br>
                        <b>Contacto:</b><br>
                        <input type="text" name="contacto" value="contacto">
                        <br>
                        <b>Email:</b><br>
                        <input type="text" name="email" value="email">
                        <br><br>
                        <button name="validar1" class="button" type="submit" style="position:relative; background:red;!important;" value="cancelar"> Cancelar </button>
                        <button name="validar2" class="button" type="submit" style="position:relative;display:inline;left:41%;bottom:40px; !important;" value="salvar"> Salvar </button>

                    </form>     
                </div>
            </div>
        </div>
    </div> 
</body>

</html>