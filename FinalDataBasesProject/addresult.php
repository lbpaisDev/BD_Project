<!-- BackEnd PhP-->
<?php

    require_once 'connect.php';
    session_start();
    $db = OpenCon();
    $id='';
    if (!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    if (empty($_GET['id'])){
        throw new Exception("ID is Blank");
    }

    //selecioar equipa consoante o nome da equipa

    $sql = "SELECT teamone,teamtwo FROM game  where gameid ='".$id."'";
    $resp = $db->query($sql);
    $row=mysqli_fetch_assoc($resp);
    $teamone = $row['teamone'];
    $teamtwo = $row['teamtwo'];

    $capcc = $_SESSION['cc'];
    $resp = $db->query("SELECT team_teamname FROM captain_team where user_cc = $capcc");
    $row = mysqli_fetch_assoc($resp);
    $teamname = $row['team_teamname'];
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
    <link rel="stylesheet" href="css/goalst.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/userNL.js"></script>

    <script>
        function voltar(){
            window.location.replace("capitan_resultados.php");
        }
    </script>


</head>


<!--Body-->

<body>
<br><br><br>
<h2 class="text-center">Adicionar resultado</h2>
<h2 class="text-center">do jogo</h2>
<h2 class="text-center"><?php echo $teamone?> vs <?php echo $teamtwo?></h2>

<br><br><br><br><br><br><br><br>
<form method="post" id = "data" >
    <label for="Name" style="position: relative;left: 36%"><?php echo $teamone?></label>
    <input type="number"name = "teamone" class="form-control"  step="1" value="0" min="0" style="width: 4%;  position: relative;left: 43%;top: 50%; text-align: center;"/>
    <label for="Name" style="position: relative;left: 36%;bottom: 70%"><?php echo $teamtwo?></label>
    <input type="number"name = "teamtwo" class="form-control"  step="1" value="0"  min="0" style="width: 4%;  position: relative;left: 43%; top: -20px; text-align: center;"/>
    <br><br>
    <button name = "buttone" type="submit" value="adiciona" class="button" style="position:relative; left:50%; top: 12px;"><b>Adicionar</b></button>
    <button name = "buttone" type="submit" value="back" class="button" style="position:relative; left:40%; top: -29px;" onclick="voltar()"><b>Voltar</b></button>
    <button name = "buttone" type="submit" value="faltas" class="button" style="position:relative; left:60%; bottom: 250px;"><b>Adicionar Faltas</b></button>
    <button name = "buttone" type="submit" value="golos" class="button" style="position:relative; left:60%; bottom: 220px;"><b>Adicionar Golos</b></button>
</form>
<?php
    $sql = "SELECT name,teamname,count(name) as t from user INNER JOIN goals ON user.cc = goals.usercc and goals.game_gameid = $id GROUP BY name ORDER BY COUNT(name) DESC";
    $result = $db->query($sql);
    if($result){
        $num_of_results = mysqli_num_rows($result);
        echo '<table id="Goals" class="mytable" style="right: 40%;"> <!-- style="width:70%">  -->
            <tr>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Equipa</th>
                <th style="text-align: center">NºGolos</th>
            </tr>';

            for ($i = 1;$i <=  $num_of_results ;$i++){
                $row = mysqli_fetch_assoc($result);
                $player = $row['name'];
                $teamn = $row['teamname'];
                $goals = $row['t'];
                echo '<tr>
                    <td>'.$player.'</td>
                    <td>'.$teamn.'</td>
                    <td>'.$goals.'</td>
                </tr>';
        }
        echo '</table>';
    }
?>

<?php
    $sql = "SELECT name,teamname,count(name) as t from user INNER JOIN fouls ON user.cc = fouls.usercc and fouls.game_gameid = $id GROUP BY name ORDER BY COUNT(name) DESC";
    $result = $db->query($sql);
    if($result){
        $num_of_results = mysqli_num_rows($result);
        echo '<table id="Faouls" class="mytable" style="right: 40%;"> <!-- style="width:70%">  -->
                <tr>
                    <th style="text-align: center">Nome</th>
                    <th style="text-align: center">Equipa</th>
                    <th style="text-align: center">NºFaltas</th>
                </tr>';

        for ($i = 1;$i <=  $num_of_results ;$i++){
            $row = mysqli_fetch_assoc($result);
            $player = $row['name'];
            $teamn = $row['teamname'];
            $number = $row['t'];
            echo '<tr>
                    <td>'.$player.'</td>
                    <td>'.$teamn.'</td>
                    <td>'.$number.'</td>
                </tr>';
        }
        echo '</table>';
}
?>
</body>
<script>
    function voltar(){
        window.location.replace("capitan_resultados.php");
    }
</script>
</html>


<?php
        if(isset($_REQUEST['buttone'])) {
            switch ($_REQUEST['buttone']) {
                case 'adiciona':
                    $resultone = $_POST['teamone'];
                    $resulttwo = $_POST['teamtwo'];
                    $sql = "SELECT * FROM game where teamone = '.$teamname.' and gameid = $id";
                    if($db->query($sql)){
                        $sql =  "UPDATE game SET goalsteam1cap1 = $resultone,goalsteam2cap1=$resulttwo where game.gameid = $id";
                        $db->query($sql);

                        $sql = "SELECT goalsteam1cap2,goalsteam2cap2 FROM game where game.gameid = $id";
                        $resp = $db->query($sql);
                        $row = mysqli_fetch_assoc($resp);
                        $otherresult1 = $row['goalsteam1cap2'];
                        $otherresult2 = $row['goalsteam2cap2'];

                        if($otherresult1 == $resultone and $otherresult2 == $resulttwo){
                            $sql =  "UPDATE game SET check_game = 1 where game.gameid= $id";
                            $db->query($sql);
                            header("Location: capitan_resultados.php");
                        }
                        else{
                            header("Location: capitan_resultados.php");
                        }
                    }
                    else{
                        $sql =  "UPDATE game SET goalsteam1cap2 = $resultone,goalsteam2cap2=$resulttwo where game.gameid= $id";
                        $db->query($sql);

                        $sql = "SELECT goalsteam2cap1,goalsteam2cap1 FROM game where game.gameid = $id";
                        $resp = $db->query($sql);
                        $row = mysqli_fetch_assoc($resp);
                        $otherresult1 = $row['goalsteam1cap1'];
                        $otherresult2 = $row['goalsteam2cap1'];

                        if($otherresult1 == $resultone and $otherresult2 == $resulttwo){
                            $sql =  "UPDATE game SET check_game = 1 where game.gameid= $id";
                            $db->query($sql);

                            //update teamdata
                            if($resultone > $resulttwo){
                                //team one wins
                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resultone,team_goalssuffered = team_goalssuffered + $resulttwo ,team_victories = team_victories +1 where team_teamname = '$teamone'";
                                $db->query($sql);

                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resulttwo,team_goalssuffered = team_goalssuffered + $resultone ,team_defeats = team_defeats +1 where team_teamname = '$teamtwo'";
                                $db->query($sql);
                            }
                            elseif($resultone<$resulttwo){
                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resultone,team_goalssuffered = team_goalssuffered + $resulttwo ,team_defeats = team_defeats +1 where team_teamname = '$teamone'";
                                $db->query($sql);

                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resulttwo,team_goalssuffered = team_goalssuffered + $resultone ,team_victories = team_victories +1 where team_teamname = '$teamtwo'";
                                $db->query($sql);
                            }
                            else{
                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resultone,team_goalssuffered = team_goalssuffered + $resulttwo ,team_draws = team_draws +1 where team_teamname = '$teamone'";
                                $db->query($sql);

                                $sql = "UPDATE captain_team SET team_ngames = team_ngames + 1 ,team_goalsscored = team_goalsscored + $resulttwo,team_goalssuffered = team_goalssuffered + $resultone ,team_draws = team_draws +1 where team_teamname = '$teamtwo'";
                                $db->query($sql);
                            }
                            header("Location: capitan_resultados.php");
                        }
                        else{
                            header("Location: capitan_resultados.php");
                        }
                    }
                    break;

                case 'back':
                    header("Location: capitan_resultados.php");
                    break;

                case 'faltas':
                    header("Location: faltas.php?id=$id&teamname=$teamname");
                    break;

                case 'golos':
                    header("Location: golos.php?id=$id&teamname=$teamname");
                    break;
            }
        }
?>