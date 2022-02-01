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
    console_log($quicko);
    // filter by nome:
    $result = $connection->query("SELECT teamName, reqId from request WHERE tournament_tournamentid = $quicko and accepted is null");
    console_log($result);
    $num_of_results = mysqli_num_rows($result);
    $vagas = $connection->query("SELECT freespots from tournament WHERE tournamentid=$quicko");
    console_log($vagas);
    $row2 = mysqli_fetch_assoc($vagas);
    $trueVagas = "";
    $trueVagas = $row2['freespots'];



    if($num_of_results>0)
    {

        echo '<h4><b>Vagas: '.$trueVagas.'</b></h4>
            <form method="post"> 
                <table id="Torneios" class="mytable"> <!-- style="width:70%">  -->
                    <tr>
                        <th>Equipa</th>                    
                        <th>Aceitar</th>
                        <th>Negar</th> 
                    </tr>';



        for ($i = 1; $i <= $num_of_results; $i++)
        {

            $row = mysqli_fetch_assoc($result);


            $teamName = $row['teamName'];
            $reqId = $row['reqId'];

            echo
                '<tr>
                <td>'.$teamName.'</td>                                
                <td><input class="bbt" type="button" value="Aceitar" onclick="deleteRow1(this, '.$reqId.')"></td> 
                   <td><input class="bbt" type="button" value="Recusar" onclick="deleteRow2(this, '.$reqId.')"></td>                    
                </tr>';
        }

        echo '</table></form>  ';
    }else{
        echo '<br><br>';
        echo '<h2 style="color: red; position: relative;">Nao existem pedidos</h2>';
    }

?>

    <!DOCTYPE html>
    <html lang="pt">

    <!--Header -->
    <!--References all css and js usages-->
    <link rel="stylesheet" href="css/popUpRequest.css">


    <script type="text/javascript">
        function deleteRow1(value, vl2) {
            console.log(value);
            console.log(vl2);
            window.location.href = 'accept.php?del_id='+ vl2 + '';
            value.closest("tr").remove();
        }

        function deleteRow2(value, vl2) {
            console.log(value);
            console.log(vl2);
            window.location.href = 'deny.php?del_id='+ vl2 + '';
            value.closest("tr").remove();
        }
    </script>

    <head>

    </head>

    <body>

    </body>

    </html>

<?php

    $search = $connection->query("SELECT alreadystarted from tournament WHERE tournamentid=$quicko");
    $leRow = mysqli_fetch_assoc($search);
    $alreadyStarted = $leRow['alreadystarted'];

    if($alreadyStarted=='1'){
        echo '<h3 style="color: red; text-align: center" >O torneio já começou!</h3>';
        echo '<script type="text/javascript">';
        echo '</script>';
    }



?>