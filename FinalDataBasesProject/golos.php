<!-- BackEnd PhP-->
<?php

    require_once 'connect.php';
    $db = OpenCon();
    $id='';
    session_start();
    $capcc = $_SESSION['cc'];
    $resp = $db->query("SELECT team_teamname FROM captain_team where user_cc = $capcc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];
    if (!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    if (empty($_GET['id'])){
        throw new Exception("ID is Blank");
    }
    if (!empty($_GET['teamname'])){
        $teamname = $_GET['teamname'];
    }
    if (empty($_GET['teamname'])){
        throw new Exception("Teamname is Blank");
    }

    $opt = "<select name='players'  id='select'  class='list-group' style='background: #4CAF50;position: relative;left: 47%;bottom: 55px;'>";
    $query = "SELECT user.name from user INNER JOIN player ON user.cc = player.user_cc AND player.teamname = '$teamname' and player.isvisible = 1";
    $response=$db->query($query);
    while ($row = mysqli_fetch_assoc($response)) {
            $opt .= "<option value='{$row['name']}' >{$row['name']}</option>";
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
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.css">
    <link rel="stylesheet" href="css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/userNL.js"></script>

</head>


<!--Body-->

<body>
<br><br><br>
<h2 class="text-center">Adicionar Golos</h2>
<h2 class="text-center">Escolha o Jogador</h2>
<form method="post" id = "data"  >
    <button name = "adiciona" class="button" style="position:relative;left: 52%;top: 100px"><b>Adicionar</b></button>
    <button name = "back"class="button" style="position:relative;left:44%;top: 60px"><b>Voltar</b></button>
        <?php
            echo $opt;
        ?>
</form>

</body>
</html>

<?php
if(isset($_POST['adiciona'])){
    echo "meda";
    $name = $_POST['players'];
    $sql = "SELECT cc FROM user where name = '$name'";
    $resp = $db->query($sql);
    $row = mysqli_fetch_assoc($resp);
    $cc = $row['cc'];

    //update player data
    $sql = "UPDATE player SET goalsscored = goalsscored+1  WHERE user_cc = $cc and teamname = '$teamname'";
    $resp = $db->query($sql);

    //create a new instance of goal
    $sql = "INSERT INTO goals (usercc, teamname, isvisible, game_gameid) VALUES ($cc, '$teamname', 1, $id);";
    $resp = $db->query($sql);

    header("Location: addresult.php?id=$id");
}
if(isset($_POST['back'])){
    header("Location: addresult.php?id=$id");
}
?>