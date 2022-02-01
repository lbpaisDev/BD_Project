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
    // filter by nome:
    $result = $connection->query("SELECT gameid, teamone, teamtwo, goalsteam1cap1, goalsteam1cap2, goalsteam2cap1, goalsteam2cap2, goalsteam1manager, goalsteam2manager from game WHERE goalsteam1cap1 is not null and goalsteam1cap2 is not null and goalsteam2cap1 is not null and goalsteam2cap2 is not null and goalsteam1cap1!=goalsteam2cap1 and goalsteam1cap2!=goalsteam2cap2 and goalsteam1manager is null and goalsteam2manager is null");
    $num_of_results = mysqli_num_rows($result);



    if($num_of_results>0)
    {

        echo '
               <form method="post"> 
                    <table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                        <tr>
                            <th>Equipa1</th>   
                            <th>Equipa2</th>                   
                            <th>Result-Cap1</th>
                            <th>Result-Cap2</th> 
                            <th>Manager</th> 
                        </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);

            $gameid = $row['gameid'];
            $teamone = $row['teamone'];
            $teamtwo = $row['teamtwo'];
            $goalsteam1cap1 = $row['goalsteam1cap1'];
            $goalsteam1cap2 = $row['goalsteam1cap2'];
            $goalsteam2cap1 = $row['goalsteam2cap1'];
            $goalsteam2cap2 = $row['goalsteam2cap2'];

            echo
                '<tr>
                    <td>'.$teamone.'</td>    
                    <td>'.$teamtwo.'</td>   
                    <td>'.$goalsteam1cap1.' - '.$goalsteam1cap2.' </td>    
                    <td>'.$goalsteam2cap1.' - '.$goalsteam2cap2.'</td>             
                    <td>
                    <form method="post">
                    <input class="inp" type="number" name="re1" placeholder="team 1" ">
                    <input class="inp" type="number" name="re2"  placeholder="team 2" ">
                    <input class="bbt" type="submit" name="lale" value="Submeter">
                    </td>
                    </form>                                      
                    </tr>';
        }

        echo '</table></form>  ';
    }else{
        echo '<br><br>';
        echo '<h2 style="color: red; position: relative;">Nao existem pedidos</h2>';
    }

    if (isset($_POST['lale']) and isset($_POST['re1']) and isset($_POST['re2'])){
            if( $_POST['re1']>=0 and  $_POST['re2']>=0) {
                $_SESSION['tutu1'] = $_POST['re1'];
                $_SESSION['tutu2'] = $_POST['re2'];
                console_log($_SESSION['tutu1']);
                console_log($_SESSION['tutu2']);
                $query = "UPDATE game SET check_game='0' WHERE gameid=$gameid";
                mysqli_query($connection, $query);
                header('Location: updateResult.php?upt_id='.$gameid.'');
            }

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


    ?>