<?php

session_start();
require_once "connect.php";


?>

<!DOCTYPE html>
<html lang="pt">

<!--Header -->
<!--References all css and js usages-->

<head>

</head>

<!--Body-->

<body style="background-color: lightblue">

    <b>Pretende dar as permissões do torneio a outros gestores?</b>
    <form method="post">
        <button style="background-color: lightgreen" type="submit" name="saidyes" onclick="">Sim</button>
        <button style="background-color: lightcoral" type="submit" name="saidno" onclick="">Não</button>
    </form>


</body>

</html>

<?php



    $quick = $_SESSION['editTourId'];
    $mycc = ($_SESSION['cc']);
    $db = OpenCon();
    $result = $db->query("SELECT user_cc from tournament where tournamentid=$quick");
    $row = mysqli_fetch_assoc($result);
    $result2 = $row['user_cc'];


    if(isset($_POST['saidyes'])){
        if($result2!=$mycc){
            echo '<p style="color:red;">Apenas quem criou o torneio pode dar permissões!</p>';
        }elseif(isset($_SESSION['editTourId'])){
            $quick = $_SESSION['editTourId'];
            require_once "connect.php";
            $db = OpenCon();
            $query = "UPDATE tournament SET shared = '1' where tournamentid=$quick";
            $resp = mysqli_query($db, $query);
            console_log($resp);

            echo '<p style="color:green;">Permissões a outros gestores dada com sucesso!</p>';
        }
    }

    if(isset($_POST['saidno'])){
        if($result2!=$mycc){
            echo '<p style="color:red;">Apenas quem criou o torneio pode dar permissões!</p>';
        }elseif(isset($_SESSION['editTourId'])){
            $quick = $_SESSION['editTourId'];
            require_once "connect.php";
            $db = OpenCon();
            $query = "UPDATE tournament SET shared = '0' where tournamentid=$quick";
            $resp = mysqli_query($db, $query);
            console_log($resp);
            echo '<p style="color:green;">Permissões a outros gestores retirada com sucesso!</p>';
        }
    }
    
?>