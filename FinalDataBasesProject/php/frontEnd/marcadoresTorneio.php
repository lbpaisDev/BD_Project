<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
}

$query="SELECT tournament.tournamentname from tournament WHERE tournament.tournamentid=$torId";
$result2 = mysqli_query($conn, $query);
$torneio=mysqli_fetch_assoc($result2);

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

    <script>
        function voltar(){
            window.location.replace("./torneioPage.php?torneio_id=<?php echo $torId?>");
        }
    </script>

</head>


<!--Body-->

<body>

    <div class="parallax-content baner-content">
        <div class="container">
            <div>
                <div class="text-content" style="position:relative; bottom:100px;!important">
                    <h2>
                        <?php 
                        echo "<em>".$torneio['tournamentname']."</em>";
                        // echo "<em>Resultados</em>";
                        ?>
                        <!-- <em>Plantel</em> -->
                    </h2>
                <div>
                <div class="col-lg-6" style="position:relative; left:26%;!important" >
                    <div class="text-content">
                        <h3><b>Melhores Marcadores</b></h3>
                        <br>
                        <table class="table">
                        <tr>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Equipa</th>
                            <th>Golos Marcados</th>
                        </tr>    

                        <?php
                            $sql="SELECT player.goalsscored,player.teamname,user.username,user.name from player, user,captain_team where player.teamname =captain_team.team_teamname and captain_team.tournament_tournamentid=$torId and user.cc=player.user_cc order by 1 desc ";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>".$row["username"]."</td>"."<td>".$row["name"]."</td>"."<td>".$row["teamname"]."</td>"."<td>".$row["goalsscored"]."</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>  
                    </table>
                    <button class="button" style="position:relative; left:85%;" onclick="voltar();" ><b>Voltar</b></button>
                    </div>
                </div>

                <div>
                   
                </div>
                    
                </div>
            </div>
        </div>
    </div> 
</body>

</html>