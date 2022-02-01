<?php

    session_start();
    require_once "connect.php";

    $connection = OpenCon();
    if ($connection->connect_errno != 0)
    {
        throw new Exception(mysqli_connect_errno());
    }

    $quick_cast = ($_SESSION['cc']);
    $quicko = $_SESSION['editTourId'];

    $result = $connection->query("SELECT team_teamname, team_nplayers, accepted from captain_team, request where captain_team.tournament_tournamentid=$quicko and request.tournament_tournamentid = $quicko and accepted='1'");
    $num_of_results = mysqli_num_rows($result);


    if($num_of_results>0)
    {

        echo '
            <table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                    <tr>
                        <th>Nome da equipa</th>
                        <th>Num. jogadores</th>                 
                        <th>Apagar</th> 
                    </tr>';


        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);

            $team_teamname = $row['team_teamname'];
            $team_nplayers = $row['team_nplayers'];

            echo
                '<tr>
                <td>'.$team_teamname.'</td>
                <td>'.$team_nplayers.'</td>             
                <form method="post">     
                <td><input style="color:white; background-color: red;" name="ajax3" id="apagar1" class="bbt" type="submit" value="Expulsar"></td> 
               </form>
                </tr>';
        }

        echo '</table>';
    }else{
        echo '<br><br>';
        echo '<h3 style="color: red; position: absolute; left: 20%; top: 40%;">Nao existem equipas</h3>';

    }

?>

    <!DOCTYPE html>
    <html lang="pt">

    <!--Header -->
    <!--References all css and js usages-->
    <link rel="stylesheet" href="css/confResult.css">

    <head>

    </head>

    <body>
    <script>
        function lul(value) {
            console.log("yolo");
            window.location.href = 'updateResult.php?upt_id='+ value + '';
        }
    </script>

    </body>

    </html>

<?php
require_once "connect.php";
if(isset($_POST['ajax3']) and isset($team_teamname)) {
    //por o request a 0, apagar equipa e o player com o cc da equipa
    $db = OpenCon();

    console_log($team_teamname);

    $result = $connection->query("SELECT reqid from request WHERE tournament_tournamentid=$quicko and teamname = '$team_teamname'");
    $num_of_results = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $reqid = $row['reqid'];

    $query = "UPDATE request SET accepted='0' where tournament_tournamentid =$quicko and reqid=$reqid";
    $result = mysqli_query($db, $query);
    console_log($result);

    $result = $connection->query("SELECT user_cc from captain_team where team_teamname='$team_teamname' and tournament_tournamentid=$quicko");
    $num_of_results = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $user_cc2 = $row['user_cc'];


    $query = "DELETE FROM player WHERE user_cc = $user_cc2";
    $result = mysqli_query($db, $query);
    console_log($result);

    $query = "DELETE FROM captain_team WHERE tournament_tournamentid=$quicko and user_cc=$user_cc2";
    $result = mysqli_query($db, $query);
    console_log($result);



}