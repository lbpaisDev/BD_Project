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

    <b>Tem a certeza que pretende iniciar o torneio?</b>
    <form method="post">
        <button style="background-color: lightgreen" type="submit" name="saidyes">Sim</button>
    </form>


    </body>

    </html>

<?php

if(isset($_POST['saidyes'])) {
    if (isset($_SESSION['editTourId'])) {
        $quick = $_SESSION['editTourId'];
        require_once "connect.php";
        $db = OpenCon();

        $result = $db->query("SELECT alreadystarted from tournament WHERE tournamentid=$quick");
        $num_of_results = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $alreadystarted = $row['alreadystarted'];


        if ($alreadystarted == '0') {
            $query = "UPDATE tournament SET alreadystarted = '1' where tournamentid=$quick";
            $resp = mysqli_query($db, $query);
            console_log($resp);

            echo "<p style='color: green'>Torneio iniciado com sucesso!</p>";
        } else
            if ($alreadystarted == '1') {
                echo "<p style='color: red'>O torneio ja começou!</p>";

            }else
                if ($alreadystarted == null) {
                    echo "<p style='color: red'>Ainda não gerou os jogos!</p>";

                }
    }
}


?>