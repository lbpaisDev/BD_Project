<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

if(isset($_GET['torneio_id'])){
    $torId = $_GET['torneio_id'];
}
if(isset($_GET['t_name'])){
    $teamname = $_GET['t_name'];
}

// $sql="SELECT tournament.tournamentid,tournament.tournamentname, tournament.startdate, tournament.enddate, tournamentdetails.gameweekday, tournamentdetails.gamestarttime from tournament, tournamentdetails WHERE tournamentdetails.tournament_tournamentid=tournament.tournamentid and tournament.tournamentid=$torId";
// $result = mysqli_query($conn, $sql);
// $torneio=mysqli_fetch_assoc($result);

$sql="SELECT team_gk,team_def1,team_def2,team_def3,team_def4,team_med1,team_med2,team_med3,team_ava1,team_ava2,team_ava3,team_sub_gk,team_sub_def,team_sub_med,team_sub_ava,team_sub_ava1 FROM captain_team WHERE tournament_tournamentid=$torId and team_teamname like '$teamname'";
$result = mysqli_query($conn, $sql);
$team=mysqli_fetch_assoc($result);

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
                        echo "<em>Plantel ".$teamname."</em>";
                        ?>
                        <!-- <em>Plantel</em> -->
                    </h2>
                <div>
                <div class="col-lg-4" style="position:relative; left:14%;!important;">
                    <div class="text-content">
                        <h3><b>Titulares</b></h3>
                        <br>
                        <table class="table">
                            <tr>
                                <th>GR</th>
                                <td><?php echo $team['team_gk']?></td>
                            </tr>    
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def1']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def2']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def3']?></td>
                            </tr>
                            <tr>
                                <th>DEF</th>
                                <td><?php echo $team['team_def4']?></td>
                            </tr>   
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med1']?></td>
                            </tr>   
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med2']?></td>
                            </tr>
                            <tr>
                                <th>MED</th>
                                <td><?php echo $team['team_med3']?></td>
                            </tr>    
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava1']?></td>
                            </tr>  
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava2']?></td>
                            </tr> 
                            <tr>
                                <th>AC</th>
                                <td><?php echo $team['team_ava3']?></td>
                            </tr>     
                        </table>
                    </div>
                </div>

                <div>
                <div class="col-lg-4" style="position:relative; left:14%;!important;">
                    <div class="text-content">
                        <h3><b>Suplentes</b></h3>
                        <br>
                        <table class="table">
                            <tr>
                                <td><?php echo $team['team_sub_gk']?></td>
                            </tr>    
                            <tr>
                                <td><?php echo $team['team_sub_def']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_med']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_ava']?></td>
                            </tr>
                            <tr>
                                <td><?php echo $team['team_sub_ava1']?></td>
                            </tr>      
                        </table>

                        
                    </div>
                    <button class="button" style="position:relative; left:78%;" onclick="voltar();" ><b>Voltar</b></button>
                </div>
                    
                </div>
            </div>
        </div>
    </div> 
</body>

</html>