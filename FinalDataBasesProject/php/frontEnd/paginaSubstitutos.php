<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// echo $_SESSION['cc'];

$cc=$_SESSION['cc'];

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
            window.location.replace("../backEnd/checkTeam.php");
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
                        <em>Pedidos de Substituição</em>
                    </h2>
                <div>
                <div class="col-lg-6" style="position:relative; left:26%;!important" >
                    <div class="text-content">
                        <!-- <h3><b>Titulares</b></h3> -->
                        <br>
                        <table class="table">
                        <tr>
                            <th>Jogo</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Local</th>
                        </tr>    

                        <?php
                            $sql="SELECT game.teamone,game.teamtwo,game.gamedate,game.starttime,game.gamefield from game,substitute WHERE substitute.game_gameid=game.gameid and substitute.user_cc1=$cc and game.gamedate>CURRENT_DATE";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>".$row["teamone"]." Vs ".$row['teamtwo']."</td>"."<td>".$row["gamedate"]."</td>"."<td>".$row["starttime"]."</td>"."<td>".$row["gamefield"]."</td>";
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